<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DonasiController extends Controller
{
    public function index(Request $request)   // admin dan petugas
    {
        $donasis = Donasi::with(['donatur', 'kampanye'])
            ->when($request->status === 'menunggu', fn ($q) => $q->whereNull('tanggal_verifikasi'))
            ->when($request->status === 'terverifikasi', fn ($q) => $q->whereNotNull('tanggal_verifikasi'))
            ->latest()->paginate(15)->withQueryString();

        return view('donasi.index', [
            'donasis'    => $donasis,
            'status'     => $request->status,
            'jumlahSemua' => Donasi::count(),
            'jumlahMenunggu' => Donasi::whereNull('tanggal_verifikasi')->count(),
        ]);
    }

    public function riwayat(Request $request)   // hanya milik sendiri
    {
        $donasis = Donasi::with('kampanye')
            ->whereHas('donatur', fn ($q) => $q->where('user_id', $request->user()->id))
            ->latest()->paginate(15);

        return view('donasi.riwayat', compact('donasis'));
    }

    public function store(Request $request)   // mengajukan donasi
    {
        $data = $request->validate([
            'kampanye_id' => ['required', 'exists:kampanyes,id'],
            'nominal'     => ['required', 'integer', 'min:10000'],
        ], [
            'kampanye_id.exists' => __('Kampanye tidak ditemukan.'),
            'nominal.required'   => __('Nominal donasi wajib diisi.'),
            'nominal.integer'    => __('Nominal harus berupa angka bulat.'),
            'nominal.min'        => __('Nominal donasi minimal Rp 10.000.'),
        ]);

        $donatur = $request->user()->donatur;   // identitas dari sesi, bukan dari input
        abort_if(! $donatur, 403, __('Akun ini belum terhubung ke data donatur.'));

        Donasi::create($data + [
            'donatur_id'     => $donatur->id,
            'tanggal_donasi' => now()->toDateString(),
        ]);

        return back()->with('success', __('Donasi diajukan, menunggu verifikasi petugas.'));
    }

    public function verifikasi(Donasi $donasi)
    {
        $donasi->update(['tanggal_verifikasi' => now()->toDateString()]);

        return back()->with('success', __('Donasi diverifikasi.'));
    }

    // Modul 6 (A4 sudah ditutup): Policy
    public function show($id)
    {
        $donasi = Donasi::with(['donatur', 'kampanye'])->findOrFail($id);

        Gate::authorize('view', $donasi);

        return view('donasi.show', compact('donasi'));
    }
}
