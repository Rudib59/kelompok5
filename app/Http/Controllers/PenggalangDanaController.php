<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKampanyeRequest;
use App\Http\Requests\UpdateKampanyeRequest;
use App\Models\Kampanye;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PenggalangDanaController extends Controller
{
    public function dashboard(): View
    {
        $user = auth()->user();

        $kampanyes = Kampanye::where('user_id', $user->id);

        return view('penggalang-dana.dashboard', [
            'jumlahKampanye' => (clone $kampanyes)->count(),
            'menunggu' => (clone $kampanyes)->where('status', 'menunggu')->count(),
            'disetujui' => (clone $kampanyes)->where('status', 'disetujui')->count(),
            'ditolak' => (clone $kampanyes)->where('status', 'ditolak')->count(),
            'kampanyesTerbaru' => (clone $kampanyes)->with('kategori')->latest()->take(5)->get(),
        ]);
    }

    public function index(): View
    {
        $kampanyes = Kampanye::with('kategori')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('penggalang-dana.kampanye.index', compact('kampanyes'));
    }

    public function create(): View
    {
        return view('penggalang-dana.kampanye.form', [
            'kampanye' => new Kampanye(),
            'kategoris' => Kategori::orderBy('nama')->get(),
        ]);
    }

    public function store(StoreKampanyeRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('gambar');

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('kampanye', 'public');
        }

        $data['user_id'] = auth()->id();
        $data['penggalang'] = auth()->user()->name;
        $data['status'] = 'menunggu';
        $data['catatan_admin'] = null;
        $data['diproses_oleh'] = null;
        $data['diproses_pada'] = null;

        Kampanye::create($data);

        return redirect()
            ->route('penggalang.kampanye.index')
            ->with('success', __('Kampanye berhasil diajukan dan sedang menunggu pemeriksaan Admin.'));
    }

    public function edit(Kampanye $kampanye): View
    {
        abort_unless($kampanye->user_id === auth()->id(), 403);

        return view('penggalang-dana.kampanye.form', [
            'kampanye' => $kampanye,
            'kategoris' => Kategori::orderBy('nama')->get(),
        ]);
    }

    public function update(UpdateKampanyeRequest $request, Kampanye $kampanye): RedirectResponse
    {
        abort_unless($kampanye->user_id === auth()->id(), 403);

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

        $data['penggalang'] = auth()->user()->name;
        $data['status'] = 'menunggu';
        $data['catatan_admin'] = null;
        $data['diproses_oleh'] = null;
        $data['diproses_pada'] = null;

        $kampanye->update($data);

        return redirect()
            ->route('penggalang.kampanye.index')
            ->with('success', __('Perubahan kampanye berhasil dikirim dan menunggu pemeriksaan Admin kembali.'));
    }

    public function destroy(Kampanye $kampanye): RedirectResponse
    {
        abort_unless($kampanye->user_id === auth()->id(), 403);

        if ($kampanye->gambar) {
            Storage::disk('public')->delete($kampanye->gambar);
        }

        $kampanye->delete();

        return redirect()
            ->route('penggalang.kampanye.index')
            ->with('success', __('Kampanye berhasil dihapus.'));
    }
}
