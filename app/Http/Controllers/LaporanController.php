<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    private function getRekap()
    {
        return Donasi::join('kampanyes', 'kampanyes.id', '=', 'donasis.kampanye_id')
            ->whereNotNull('donasis.tanggal_verifikasi')
            ->selectRaw('kampanyes.judul, kampanyes.judul_en, COUNT(donasis.id) as jumlah, SUM(donasis.nominal) as total')
            ->groupBy('kampanyes.id', 'kampanyes.judul', 'kampanyes.judul_en')
            ->orderByDesc('total')
            ->get();
    }

    public function index()
    {
        $rekap = $this->getRekap();

        return view('laporan.index', compact('rekap'));
    }

    public function exportPdf()
    {
        $rekap = $this->getRekap();
        $pdf = Pdf::loadView('laporan.pdf', compact('rekap'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('laporan-penggalangan-dana-' . now()->format('Y-m-d') . '.pdf');
    }
}
