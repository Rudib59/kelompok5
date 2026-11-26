<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanPenggalangDana;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PengajuanPenggalangDanaController extends Controller
{
    public function index(): View
    {
        $pengajuans = PengajuanPenggalangDana::with(['user', 'admin'])
            ->latest()
            ->paginate(10);

        return view('admin.pengajuan-penggalang-dana.index', compact('pengajuans'));
    }

    public function show(PengajuanPenggalangDana $pengajuan): View
    {
        $pengajuan->load(['user', 'admin']);

        return view('admin.pengajuan-penggalang-dana.show', compact('pengajuan'));
    }

    public function fotoKtp(PengajuanPenggalangDana $pengajuan)
    {
        abort_unless(
            $pengajuan->foto_ktp &&
            Storage::disk('private')->exists($pengajuan->foto_ktp),
            404
        );

        return Storage::disk('private')->response(
            $pengajuan->foto_ktp,
            null,
            ['X-Content-Type-Options' => 'nosniff'],
            'inline'
        );
    }

    public function setujui(PengajuanPenggalangDana $pengajuan): RedirectResponse
    {
        if ($pengajuan->status !== 'menunggu') {
            return back()->with('error', __('Pengajuan ini sudah diproses sebelumnya.'));
        }

        if (
            !$pengajuan->nama_lengkap ||
            !$pengajuan->nik ||
            !$pengajuan->foto_ktp ||
            !$pengajuan->no_whatsapp ||
            !$pengajuan->alamat
        ) {
            return back()->with('error', __('Pengajuan belum memiliki data identitas yang lengkap.'));
        }

        DB::transaction(function () use ($pengajuan) {
            $pengajuan->user->assignRole('penggalang_dana');

            $pengajuan->update([
                'status' => 'disetujui',
                'diproses_oleh' => auth()->id(),
                'diproses_pada' => now(),
                'catatan_admin' => null,
            ]);
        });

        return redirect()
            ->route('admin.pengajuan-penggalang-dana.index')
            ->with('success', __('Pengajuan berhasil disetujui. Pengguna sekarang menjadi Penggalang Dana.'));
    }

    public function tolak(Request $request, PengajuanPenggalangDana $pengajuan): RedirectResponse
    {
        if ($pengajuan->status !== 'menunggu') {
            return back()->with('error', __('Pengajuan ini sudah diproses sebelumnya.'));
        }

        $validated = $request->validate([
            'catatan_admin' => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'catatan_admin.required' => __('Catatan penolakan wajib diisi.'),
            'catatan_admin.min' => __('Catatan minimal 5 karakter.'),
            'catatan_admin.max' => __('Catatan maksimal 1.000 karakter.'),
        ]);

        $pengajuan->update([
            'status' => 'ditolak',
            'catatan_admin' => $validated['catatan_admin'],
            'diproses_oleh' => auth()->id(),
            'diproses_pada' => now(),
        ]);

        return redirect()
            ->route('admin.pengajuan-penggalang-dana.index')
            ->with('success', __('Pengajuan berhasil ditolak.'));
    }
}
