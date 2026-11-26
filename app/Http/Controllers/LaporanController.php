<?php

namespace App\Http\Controllers;

use App\Models\Donasi;

class LaporanController extends Controller
{
    public function index()
    {
        $rekap = Donasi::join('kampanyes', 'kampanyes.id', '=', 'donasis.kampanye_id')
            ->whereNotNull('donasis.tanggal_verifikasi')
            ->selectRaw('kampanyes.judul, kampanyes.judul_en, COUNT(donasis.id) as jumlah, SUM(donasis.nominal) as total')
            ->groupBy('kampanyes.id', 'kampanyes.judul', 'kampanyes.judul_en')
            ->orderByDesc('total')
            ->get();

        return view('laporan.index', compact('rekap'));
    }
}
