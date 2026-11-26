<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\Kategori;
use Illuminate\Http\JsonResponse;

class RekapController extends Controller
{
    // GET /api/rekap/kampanye-per-kategori
    public function kampanyePerKategori(): JsonResponse
    {
        $data = Kategori::withCount('kampanyes')->get()
            ->map(fn ($k) => ['kategori' => $k->nama_tampil, 'jumlah_kampanye' => $k->kampanyes_count]);

        return response()->json(['data' => $data], 200);
    }

    // GET /api/rekap/donasi-per-kampanye
    public function donasiPerKampanye(): JsonResponse
    {
        $data = Donasi::join('kampanyes', 'kampanyes.id', '=', 'donasis.kampanye_id')
            ->selectRaw('kampanyes.id, kampanyes.judul, COUNT(donasis.id) as jumlah_donasi, SUM(donasis.nominal) as total_nominal')
            ->groupBy('kampanyes.id', 'kampanyes.judul')
            ->orderByDesc('total_nominal')
            ->get();

        return response()->json(['data' => $data], 200);
    }
}
