<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKampanyeRequest;
use App\Http\Requests\UpdateKampanyeRequest;
use App\Models\Kampanye;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

class KampanyeController extends Controller
{
    public function index()
    {
        return view('admin.kampanye.index', [
            'kampanyes' => Kampanye::with(['kategori', 'user'])
                ->latest()
                ->paginate(10),
        ]);
    }

    public function create()
    {
        return view('admin.kampanye.form', [
            'kampanye' => new Kampanye,
            'kategoris' => Kategori::orderBy('nama')->get(),
        ]);
    }

    public function store(StoreKampanyeRequest $request)
    {
        $data = $request->safe()->except('gambar');

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('kampanye', 'public');
        }

        Kampanye::create($data);

        return redirect()->route('admin.kampanye.index')
            ->with('success', __('Kampanye ditambahkan.'));
    }

    public function edit(Kampanye $kampanye)
    {
        return view('admin.kampanye.form', [
            'kampanye' => $kampanye,
            'kategoris' => Kategori::orderBy('nama')->get(),
        ]);
    }

    public function update(UpdateKampanyeRequest $request, Kampanye $kampanye)
    {
        $data = $request->safe()->except('gambar');

        if ($request->boolean('hapus_gambar') && $kampanye->gambar) {
            Storage::disk('public')->delete($kampanye->gambar);
            $data['gambar'] = null;
        }

        if ($request->hasFile('gambar')) {
            if ($kampanye->gambar) {
                Storage::disk('public')->delete($kampanye->gambar);
            }

            $data['gambar'] = $request->file('gambar')->store('kampanye', 'public');
        }

        $kampanye->update($data);

        return redirect()->route('admin.kampanye.index')
            ->with('success', __('Kampanye diperbarui.'));
    }

    public function setujui(Kampanye $kampanye)
    {
        if ($kampanye->status !== 'menunggu') {
            return back()->with('error', __('Kampanye ini sudah diproses atau bukan pengajuan baru.'));
        }

        $kampanye->update([
            'status' => 'disetujui',
            'catatan_admin' => null,
            'diproses_oleh' => auth()->id(),
            'diproses_pada' => now(),
        ]);

        return back()->with('success', __('Kampanye berhasil disetujui dan dapat ditampilkan kepada publik.'));
    }

    public function tolak(Kampanye $kampanye)
    {
        if ($kampanye->status !== 'menunggu') {
            return back()->with('error', __('Kampanye ini sudah diproses atau bukan pengajuan baru.'));
        }

        $kampanye->update([
            'status' => 'ditolak',
            'catatan_admin' => null,
            'diproses_oleh' => auth()->id(),
            'diproses_pada' => now(),
        ]);

        return back()->with('success', __('Kampanye berhasil ditolak.'));
    }

    public function destroy(Kampanye $kampanye)
    {
        if ($kampanye->gambar) {
            Storage::disk('public')->delete($kampanye->gambar);
        }

        $kampanye->delete();

        return redirect()->route('admin.kampanye.index')
            ->with('success', __('Kampanye dihapus.'));
    }
}
