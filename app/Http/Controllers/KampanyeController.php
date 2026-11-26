<?php

namespace App\Http\Controllers;

use App\Models\Kampanye;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KampanyeController extends Controller
{
    public function show($id)
    {
        $terverifikasi = fn ($q) => $q->whereNotNull('tanggal_verifikasi');

        $kampanye = Kampanye::with([
                'kategori',
                'donasis' => fn ($q) => $q->whereNotNull('tanggal_verifikasi')->latest()->limit(8)->with('donatur'),
            ])
            ->withSum(['donasis as terkumpul' => $terverifikasi], 'nominal')
            ->withCount(['donasis as jumlah_donatur' => $terverifikasi])
            ->findOrFail($id);

        return view('kampanye.show', compact('kampanye'));
    }

    // Modul 6 (A2 sudah ditambal): query dengan binding
    public function cari(Request $request)
    {
        $judul = $request->query('judul');

        $hasil = DB::select('SELECT * FROM kampanyes WHERE judul = ?', [$judul]);

        return response()->json($hasil);
    }
}
