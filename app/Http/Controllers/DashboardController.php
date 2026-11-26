<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\Kampanye;
use App\Models\Kategori;
use App\Models\User;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('dashboard.admin', [
            'jumlahUser'         => User::count(),
            'jumlahKampanye'     => Kampanye::count(),
            'totalTerverifikasi' => Donasi::whereNotNull('tanggal_verifikasi')->sum('nominal'),
            'menunggu'           => Donasi::whereNull('tanggal_verifikasi')->count(),
            'terbaru'            => Donasi::with(['donatur', 'kampanye'])->latest()->take(6)->get(),
            'perKategori'        => Kategori::withCount('kampanyes')->orderBy('nama')->get(),
        ]);
    }

    public function petugas()
    {
        return view('dashboard.petugas', [
            'menunggu'      => Donasi::whereNull('tanggal_verifikasi')->count(),
            'selesaiHariIni' => Donasi::whereDate('tanggal_verifikasi', today())->count(),
            'totalDonasi'   => Donasi::count(),
            'antrian'       => Donasi::with(['donatur', 'kampanye'])->whereNull('tanggal_verifikasi')->latest()->take(10)->get(),
        ]);
    }
}
