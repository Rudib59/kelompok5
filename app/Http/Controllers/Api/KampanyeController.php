<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\KampanyeResource;
use App\Models\Kampanye;
use Illuminate\Http\Request;

class KampanyeController extends Controller
{
    // GET /api/kampanye?cari=&kategori=&tahun=&page=
    public function index(Request $request)
    {
        $kampanyes = Kampanye::with('kategori')->withCount('donasis')
            ->withSum(['donasis as terkumpul' => fn ($q) => $q->whereNotNull('tanggal_verifikasi')], 'nominal')
            ->when($request->cari, fn ($q, $c) => $q->where(
                fn ($q) => $q->where('judul', 'like', "%{$c}%")->orWhere('judul_en', 'like', "%{$c}%")
                    ->orWhere('penggalang', 'like', "%{$c}%")->orWhere('lokasi', 'like', "%{$c}%")
            ))
            ->when($request->kategori, fn ($q, $id) => $q->where('kategori_id', $id))
            ->when($request->tahun, fn ($q, $t) => $q->where('tahun_mulai', $t))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return KampanyeResource::collection($kampanyes);
    }

    // POST /api/kampanye
    public function store(Request $request)
    {
        $data = $request->validate($this->aturan(), $this->pesan(), $this->atribut());

        $kampanye = Kampanye::create($data)->load('kategori');

        return (new KampanyeResource($kampanye))
            ->additional(['message' => __('Kampanye berhasil ditambahkan.')])
            ->response()->setStatusCode(201);
    }

    // GET /api/kampanye/{id}
    public function show(string $id)
    {
        $kampanye = Kampanye::with('kategori')->withCount('donasis')
            ->withSum(['donasis as terkumpul' => fn ($q) => $q->whereNotNull('tanggal_verifikasi')], 'nominal')->find($id);
        abort_if(! $kampanye, 404, 'not found');

        return new KampanyeResource($kampanye);
    }

    // PUT /api/kampanye/{id}
    public function update(Request $request, string $id)
    {
        $kampanye = Kampanye::find($id);
        abort_if(! $kampanye, 404, 'not found');

        $kampanye->update($request->validate($this->aturan(sebagian: true), $this->pesan(), $this->atribut()));

        return (new KampanyeResource($kampanye->load('kategori')))
            ->additional(['message' => __('Kampanye berhasil diperbarui.')]);
    }

    // DELETE /api/kampanye/{id}
    public function destroy(string $id)
    {
        $kampanye = Kampanye::find($id);
        abort_if(! $kampanye, 404, 'not found');

        $kampanye->delete();

        return response()->json(['message' => __('Kampanye berhasil dihapus.')], 200);
    }

    private function aturan(bool $sebagian = false): array
    {
        $rules = [
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'judul'       => ['required', 'string', 'min:3', 'max:150'],
            'penggalang'  => ['required', 'string', 'min:3', 'max:100'],
            'tahun_mulai' => ['required', 'integer', 'between:2000,' . date('Y')],
            'target_dana' => ['required', 'integer', 'min:100000'],
        ];

        return $sebagian
            ? collect($rules)->map(fn ($r) => array_merge(['sometimes'], $r))->all()
            : $rules;
    }

    private function pesan(): array
    {
        return [
            'required'            => __(':attribute wajib diisi.'),
            'kategori_id.exists'  => __('Kategori yang dipilih tidak valid.'),
            'judul.min'           => __('Judul kampanye minimal :min karakter.'),
            'judul.string'        => __('Judul kampanye harus berupa teks.'),
            'tahun_mulai.between' => __('Tahun mulai harus antara :min sampai :max.'),
            'target_dana.min'     => __('Target dana minimal Rp :min.'),
        ];
    }

    private function atribut(): array
    {
        return ['kategori_id' => __('kategori'), 'judul' => __('judul'), 'penggalang' => __('penggalang'), 'tahun_mulai' => __('tahun mulai'), 'target_dana' => __('target dana')];
    }
}
