<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\Donatur;
use App\Models\Kampanye;
use App\Models\Kategori;

class BerandaController extends Controller
{
    public function __invoke()
    {
        $terverifikasi = fn ($q) => $q->whereNotNull('tanggal_verifikasi');

        return view('beranda', [
            'jumlahKampanye'  => Kampanye::count(),
            'jumlahDonatur'   => Donatur::count(),
            'jumlahDonasi'    => Donasi::whereNotNull('tanggal_verifikasi')->count(),
            'totalTerkumpul'  => Donasi::whereNotNull('tanggal_verifikasi')->sum('nominal'),
            'kategoris'       => Kategori::withCount('kampanyes')->orderBy('nama')->get(),
            'unggulan'        => Kampanye::with('kategori')
                                    ->withSum(['donasis as terkumpul' => $terverifikasi], 'nominal')
                                    ->latest()->take(6)->get(),
        ]);
    }
}
