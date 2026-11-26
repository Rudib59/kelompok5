<?php

use App\Http\Controllers\Admin\KampanyeController as AdminKampanyeController;
use App\Http\Controllers\Admin\PengajuanPenggalangDanaController as AdminPengajuanPenggalangDanaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\BahasaController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\KampanyeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengajuanPenggalangDanaController;
use App\Http\Controllers\PenggalangDanaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', BerandaController::class)
    ->middleware('log.aktivitas')
    ->name('beranda');

Route::get('/tentang', fn () => view('tentang'))->name('tentang');
Route::get('/bahasa/{locale}', BahasaController::class)->name('bahasa');

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        $u = auth()->user();

        return redirect()->route(match (true) {
            $u->hasRole('admin') => 'admin.dashboard',
            $u->hasRole('petugas') => 'petugas.dashboard',
            $u->hasRole('penggalang_dana') => 'penggalang.dashboard',
            default => 'kampanye.index',
        });
    })->name('dashboard');

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->middleware('permission:akses-dashboard-admin')
        ->name('admin.dashboard');

    Route::get('/petugas/dashboard', [DashboardController::class, 'petugas'])
        ->middleware('permission:akses-dashboard-petugas')
        ->name('petugas.dashboard');

    Route::prefix('penggalang')
        ->name('penggalang.')
        ->middleware('role:penggalang_dana')
        ->group(function () {
            Route::get('/dashboard', [PenggalangDanaController::class, 'dashboard'])
                ->name('dashboard');

            Route::resource('/kampanye', PenggalangDanaController::class)
                ->except('show')
                ->names('kampanye');
        });

    Route::get('/kampanye', fn () => view('kampanye.index'))
        ->middleware('permission:lihat-daftar-kampanye')
        ->name('kampanye.index');

    Route::get('/kampanye-cari', [KampanyeController::class, 'cari'])
        ->name('kampanye.cari');

    Route::get('/kampanye/{id}', [KampanyeController::class, 'show'])
        ->middleware('permission:lihat-daftar-kampanye')
        ->name('kampanye.show');

    Route::resource('admin/kampanye', AdminKampanyeController::class)
        ->names('admin.kampanye')
        ->except('show')
        ->middleware('can:kelola-kampanye');

    Route::prefix('admin/kampanye')
        ->name('admin.kampanye.')
        ->middleware('can:kelola-kampanye')
        ->group(function () {
            Route::patch('/{kampanye}/setujui', [AdminKampanyeController::class, 'setujui'])
                ->name('setujui');

            Route::patch('/{kampanye}/tolak', [AdminKampanyeController::class, 'tolak'])
                ->name('tolak');
        });

    Route::get('/admin/pengguna', [UserController::class, 'index'])
        ->middleware('permission:kelola-pengguna')
        ->name('admin.pengguna.index');

    Route::patch('/admin/pengguna/{user}/role', [UserController::class, 'updateRole'])
        ->middleware('permission:kelola-role')
        ->name('admin.pengguna.role');

    Route::prefix('admin/pengajuan-penggalang-dana')
        ->name('admin.pengajuan-penggalang-dana.')
        ->middleware('permission:kelola-pengajuan-penggalang-dana')
        ->group(function () {
            Route::get('/', [AdminPengajuanPenggalangDanaController::class, 'index'])
                ->name('index');

            Route::get('/{pengajuan}', [AdminPengajuanPenggalangDanaController::class, 'show'])
                ->name('show');

            Route::get('/{pengajuan}/foto-ktp', [AdminPengajuanPenggalangDanaController::class, 'fotoKtp'])
                ->name('foto-ktp');

            Route::patch('/{pengajuan}/setujui', [AdminPengajuanPenggalangDanaController::class, 'setujui'])
                ->name('setujui');

            Route::patch('/{pengajuan}/tolak', [AdminPengajuanPenggalangDanaController::class, 'tolak'])
                ->name('tolak');
        });

    Route::get('/pengajuan-penggalang-dana', [PengajuanPenggalangDanaController::class, 'create'])
        ->middleware('permission:mengajukan-permohonan-penggalang-dana')
        ->name('pengajuan-penggalang-dana.create');

    Route::post('/pengajuan-penggalang-dana', [PengajuanPenggalangDanaController::class, 'store'])
        ->middleware('permission:mengajukan-permohonan-penggalang-dana')
        ->name('pengajuan-penggalang-dana.store');

    Route::get('/donasi', [DonasiController::class, 'index'])
        ->middleware('permission:kelola-donasi')
        ->name('donasi.index');

    Route::post('/donasi', [DonasiController::class, 'store'])
        ->middleware('permission:mengajukan-donasi')
        ->name('donasi.store');

    Route::patch('/donasi/{donasi}/verifikasi', [DonasiController::class, 'verifikasi'])
        ->middleware('permission:mencatat-verifikasi-pembayaran')
        ->name('donasi.verifikasi');

    Route::get('/riwayat-donasi', [DonasiController::class, 'riwayat'])
        ->middleware('permission:lihat-riwayat-donasi-sendiri')
        ->name('donasi.riwayat');

    Route::get('/donasi/{id}', [DonasiController::class, 'show'])
        ->name('donasi.show');

    Route::get('/laporan', [LaporanController::class, 'index'])
        ->middleware('permission:lihat-laporan')
        ->name('laporan.index');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->middleware('permission:lihat-profil-sendiri')
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware('permission:ubah-profil-sendiri')
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->middleware('permission:ubah-profil-sendiri')
        ->name('profile.destroy');

    Route::middleware('permission:ubah-profil-sendiri')->prefix('profile')->group(function () {
        Route::post('email/kode', [ProfileController::class, 'mintaKodeEmail'])
            ->middleware('throttle:5,1')
            ->name('profile.email.kode');

        Route::post('email', [ProfileController::class, 'konfirmasiEmail'])
            ->middleware('throttle:10,1')
            ->name('profile.email.konfirmasi');

        Route::post('sandi/kode', [ProfileController::class, 'mintaKodeSandi'])
            ->middleware('throttle:5,1')
            ->name('profile.sandi.kode');

        Route::post('sandi', [ProfileController::class, 'konfirmasiSandi'])
            ->middleware('throttle:10,1')
            ->name('profile.sandi.konfirmasi');
    });
});

require __DIR__ . '/auth.php';
