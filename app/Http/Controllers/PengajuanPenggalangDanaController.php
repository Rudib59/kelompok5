<?php

namespace App\Http\Controllers;

use App\Models\PengajuanPenggalangDana;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PengajuanPenggalangDanaController extends Controller
{
    public function create(): View
    {
        $user = auth()->user();

        return view('penggalang-dana.pengajuan', [
            'pengajuanTerakhir' => $user->pengajuanPenggalangDana()
                ->latest()
                ->first(),
            'sudahMenjadiPenggalang' => $user->hasRole('penggalang_dana'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasRole('penggalang_dana')) {
            return back()->with('error', __('Kamu sudah menjadi Penggalang Dana.'));
        }

        if ($user->pengajuanPenggalangDana()->where('status', 'menunggu')->exists()) {
            return back()->with('error', __('Pengajuan kamu masih menunggu pemeriksaan Admin.'));
        }

        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'min:3', 'max:150'],
            'nik' => ['required', 'digits:16'],
            'foto_ktp' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:3072'],
            'no_whatsapp' => ['required', 'string', 'regex:/^[0-9]{10,15}$/'],
            'alamat' => ['required', 'string', 'min:10', 'max:1000'],
            'alasan' => ['required', 'string', 'min:30', 'max:2000'],
        ], [
            'nama_lengkap.required' => __('Nama lengkap sesuai KTP wajib diisi.'),
            'nama_lengkap.min' => __('Nama lengkap minimal 3 karakter.'),
            'nik.required' => __('NIK wajib diisi.'),
            'nik.digits' => __('NIK harus terdiri dari 16 angka.'),
            'foto_ktp.required' => __('Foto KTP wajib diunggah.'),
            'foto_ktp.image' => __('File yang diunggah harus berupa gambar.'),
            'foto_ktp.mimes' => __('Foto KTP harus berformat JPG, JPEG, atau PNG.'),
            'foto_ktp.max' => __('Ukuran foto KTP maksimal 3 MB.'),
            'no_whatsapp.required' => __('Nomor WhatsApp wajib diisi.'),
            'no_whatsapp.regex' => __('Nomor WhatsApp harus terdiri dari 10 sampai 15 angka.'),
            'alamat.required' => __('Alamat lengkap wajib diisi.'),
            'alamat.min' => __('Alamat minimal 10 karakter.'),
            'alasan.required' => __('Alasan pengajuan wajib diisi.'),
            'alasan.min' => __('Alasan minimal 30 karakter.'),
            'alasan.max' => __('Alasan maksimal 2000 karakter.'),
        ]);

        $fotoKtpPath = $request->file('foto_ktp')
            ->store("identitas-penggalang/{$user->id}", 'private');

        $user->pengajuanPenggalangDana()->create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'nik' => $validated['nik'],
            'foto_ktp' => $fotoKtpPath,
            'no_whatsapp' => $validated['no_whatsapp'],
            'alamat' => $validated['alamat'],
            'alasan' => $validated['alasan'],
            'status' => 'menunggu',
        ]);

        return redirect()
            ->route('pengajuan-penggalang-dana.create')
            ->with('success', __('Pengajuan berhasil dikirim. Data identitas kamu sedang diperiksa Admin.'));
    }
}
