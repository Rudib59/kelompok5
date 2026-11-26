<?php

use App\Http\Controllers\Api\KampanyeController;
use App\Http\Controllers\Api\RekapController;
use App\Models\Kategori;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Bagian baca: publik
|--------------------------------------------------------------------------
*/

// Rekap didaftarkan sebelum apiResource
Route::prefix('rekap')->group(function () {
    Route::get('kampanye-per-kategori', [RekapController::class, 'kampanyePerKategori']);
    Route::get('donasi-per-kampanye', [RekapController::class, 'donasiPerKampanye']);
});

Route::get('kategori', fn () => Kategori::orderBy('nama')->get()->map(fn ($kategori) => ['id' => $kategori->id, 'nama' => $kategori->nama_tampil]));

Route::apiResource('kampanye', KampanyeController::class)
    ->only(['index', 'show'])
    ->names('api.kampanye');

/*
|--------------------------------------------------------------------------
| Bagian tulis: wajib login (sesi atau token Sanctum) dan role admin/petugas
|--------------------------------------------------------------------------
| Aturannya sama dengan halaman admin di web (Gate "kelola-kampanye").
*/
Route::middleware(['auth:sanctum', 'can:kelola-kampanye'])->group(function () {
    Route::apiResource('kampanye', KampanyeController::class)
        ->only(['store', 'update', 'destroy'])
        ->names('api.kampanye');
});
