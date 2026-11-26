@extends('layouts.galangkita')
@section('title', __('Kampanye'))

@section('content')
<div class="flex flex-wrap items-end justify-between gap-3">
    <div>
        <h1 class="text-3xl font-extrabold">{{ __('Kampanye') }}</h1>
        <p class="mt-1 text-slate-600">{{ __('Temukan kampanye yang ingin kamu dukung.') }}</p>
    </div>
    @can('kelola-kampanye')
        <button type="button" id="btn-tambah" class="rounded-xl bg-teal-700 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-teal-800">{{ __('+ Tambah kampanye') }}</button>
    @endcan
</div>

{{-- Pencarian dan filter --}}
<div class="mt-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex flex-col gap-3 sm:flex-row">
        <div class="relative flex-1">
            <svg class="pointer-events-none absolute left-3 top-3 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="m20 20-3.500-3.500"/></svg>
            <input id="cari" type="search" placeholder="{{ __('Cari judul, penggalang, atau lokasi...') }}" class="w-full rounded-xl border border-slate-200 py-2.5 pl-10 pr-3 text-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-200">
        </div>
        <div class="flex gap-2">
            <button type="button" id="mode-kartu" class="rounded-xl border px-3 py-2 text-sm font-semibold" title="{{ __('Tampilan kartu') }}">{{ __('Kartu') }}</button>
            <button type="button" id="mode-tabel" class="rounded-xl border px-3 py-2 text-sm font-semibold" title="{{ __('Tampilan tabel') }}">{{ __('Tabel') }}</button>
        </div>
    </div>
    <div id="chip-kategori" class="mt-3 flex flex-wrap gap-2"></div>
</div>

<p id="info" class="mt-4 text-sm text-slate-500"></p>

{{-- Kartu --}}
<div id="grid" class="mt-3 grid gap-5 sm:grid-cols-2 lg:grid-cols-3"></div>

{{-- Tabel (Modul 4 Soal 1) --}}
<div id="tabel-wrap" class="mt-3 hidden overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
    <table class="w-full min-w-[640px] text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
            <tr><th class="p-3">{{ __('Kategori') }}</th><th class="p-3">{{ __('Judul') }}</th><th class="p-3">{{ __('Lokasi') }}</th><th class="p-3">{{ __('Tahun') }}</th><th class="p-3">{{ __('Target') }}</th><th class="p-3">{{ __('Donasi') }}</th><th class="p-3 text-right">{{ __('Aksi') }}</th></tr>
        </thead>
        <tbody id="isi-tabel" class="divide-y divide-slate-100"></tbody>
    </table>
</div>

<div id="kosong" class="mt-6 hidden rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center">
    <x-icon name="search" class="mx-auto h-10 w-10 text-slate-400" />
    <h3 class="mt-2 text-lg font-extrabold">{{ __('Kampanye tidak ditemukan') }}</h3>
    <p class="text-slate-500">{{ __('Coba kata kunci atau kategori lain.') }}</p>
</div>

<nav id="paging" class="mt-8 flex flex-wrap items-center justify-center gap-2"></nav>

@can('kelola-kampanye')
{{-- Form tambah/ubah (Modul 4 Soal 2 dan 3) --}}
<dialog id="dlg-form" class="w-full max-w-lg rounded-2xl p-0 shadow-xl">
    <form id="form-kampanye" class="p-6">
        <h2 id="judul-form" class="text-xl font-extrabold">{{ __('Tambah kampanye') }}</h2>
        <input type="hidden" id="kampanye-id">
        <div class="mt-4 grid gap-3">
            <label class="text-sm font-semibold">{{ __('Kategori') }}
                <select id="kategori_id" class="mt-1 w-full rounded-xl border border-slate-200 p-2.5"></select>
            </label>
            <label class="text-sm font-semibold">{{ __('Judul') }}
                <input id="judul" class="mt-1 w-full rounded-xl border border-slate-200 p-2.5" placeholder="{{ __('Judul kampanye') }}">
            </label>
            <label class="text-sm font-semibold">{{ __('Penggalang') }}
                <input id="penggalang" class="mt-1 w-full rounded-xl border border-slate-200 p-2.5" placeholder="{{ __('Nama yayasan / komunitas') }}">
            </label>
            <div class="grid grid-cols-2 gap-3">
                <label class="text-sm font-semibold">{{ __('Tahun mulai') }}
                    <input id="tahun_mulai" type="number" class="mt-1 w-full rounded-xl border border-slate-200 p-2.5" placeholder="2026">
                </label>
                <label class="text-sm font-semibold">{{ __('Target dana (Rp)') }}
                    <input id="target_dana" type="number" class="mt-1 w-full rounded-xl border border-slate-200 p-2.5" placeholder="25000000">
                </label>
            </div>
            <p id="galat-form" class="hidden rounded-lg bg-red-50 p-3 text-sm font-semibold text-red-700"></p>
        </div>
        <div class="mt-6 flex justify-end gap-2">
            <button type="button" id="btn-batal" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold hover:bg-slate-50">{{ __('Batal') }}</button>
            <button type="submit" id="btn-simpan" class="rounded-xl bg-teal-700 px-5 py-2 text-sm font-bold text-white hover:bg-teal-800">{{ __('Simpan') }}</button>
        </div>
    </form>
</dialog>
@endcan

@php
    $teks = [
        'semua' => __('Semua'), 'oleh' => __('oleh'), 'terkumpul' => __('terkumpul'), 'target' => __('Target'), 'donasi' => __('donasi'),
        'lihat' => __('Lihat & donasi'), 'detail' => __('Detail'), 'ubah' => __('Ubah'), 'hapus' => __('Hapus'),
        'ditemukan' => __('kampanye ditemukan'), 'gagalKategori' => __('Gagal memuat kategori'), 'gagalData' => __('Gagal memuat data'),
        'apiMati' => __('API tidak dapat diakses.'), 'tidakDimuat' => __('Data tidak dapat dimuat. Periksa koneksi lalu coba lagi.'),
        'tambah' => __('Tambah kampanye'), 'ubahJudul' => __('Ubah kampanye'), 'permintaanGagal' => __('Permintaan gagal'),
        'berhasilUbah' => __('Kampanye berhasil diperbarui.'), 'berhasilTambah' => __('Kampanye berhasil ditambahkan.'),
        'berhasilHapus' => __('Kampanye berhasil dihapus.'), 'gagalHapus' => __('Gagal menghapus'),
    ];
@endphp
<script>
    const API = '/api/kampanye';
    const HEADERS = { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-Locale': document.documentElement.lang,
                      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' };
    const LOCALE = document.documentElement.lang === 'en' ? 'en-US' : 'id-ID';
    const T = @json($teks);
    const IKON_SVG = {
        'Pendidikan':   '<path d="M4 5.5C6.5 4.5 9.5 4.5 12 6c2.5-1.5 5.5-1.5 8-.5v13c-2.5-1-5.5-1-8 .5-2.5-1.5-5.5-1.5-8-.5z"/><path d="M12 6v13.5"/>',
        'Kesehatan':    '<rect x="4" y="4" width="16" height="16" rx="3.5"/><path d="M12 8v8M8 12h8"/>',
        'Lingkungan':   '<path d="M5 19c0-8 5-13 14-14 0 9-5 14-13 14"/><path d="M5 19c3-4 6-6.5 9-8"/>',
        'Kemanusiaan':  '<path d="M12 20s-7-4.4-9-9c-1.4-3.2.2-6 3.2-6 1.9 0 3.2 1 3.8 2.2.6-1.2 1.9-2.2 3.8-2.2 3 0 4.6 2.8 3.2 6-2 4.6-9 9-9 9z"/>',
        'Bencana Alam': '<path d="M12 3.5s6 6.2 6 10.5a6 6 0 0 1-12 0c0-4.3 6-10.5 6-10.5z"/>',
    };
    const ikonSvg = (kat, kelas) => {
        const s = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        s.setAttribute('viewBox', '0 0 24 24'); s.setAttribute('fill', 'none'); s.setAttribute('stroke', 'currentColor');
        s.setAttribute('stroke-width', '1.8'); s.setAttribute('stroke-linecap', 'round'); s.setAttribute('stroke-linejoin', 'round');
        s.setAttribute('class', kelas);
        s.innerHTML = IKON_SVG[kat] || IKON_SVG['Kemanusiaan'];
        return s;
    };
    const BISA_KELOLA = @can('kelola-kampanye') true @else false @endcan;

    const state = { cari: (new URLSearchParams(location.search).get('q') || '').trim(), kategori: new URLSearchParams(location.search).get('kategori') || '', page: 1, mode: localStorage.getItem('gk-mode') || 'kartu' };
    const daftar = new Map();
    const $ = (id) => document.getElementById(id);
    const rupiah = (n) => 'Rp ' + Number(n).toLocaleString(LOCALE);
    const el = (tag, cls = '', teks = '') => { const e = document.createElement(tag); if (cls) e.className = cls; if (teks !== '') e.textContent = teks; return e; };
    const ukuranHalaman = 10;

    // ---------- pengambilan data (Fetch API + async/await + response.ok + try/catch) ----------
    async function muatKategori() {
        const res = await fetch('/api/kategori', { headers: HEADERS });
        if (!res.ok) throw new Error(T.gagalKategori + ' (HTTP ' + res.status + ')');
        const data = await res.json();

        const chip = $('chip-kategori');
        chip.replaceChildren(...[{ id: '', nama: T.semua }, ...data].map((k) => {
            const b = el('button', '', k.nama);
            b.type = 'button';
            b.dataset.id = k.id;
            b.onclick = () => { state.kategori = String(k.id); state.page = 1; tandaiChip(); muatKampanye(); };
            return b;
        }));
        tandaiChip();

        if (BISA_KELOLA) $('kategori_id').replaceChildren(...data.map((k) => new Option(k.nama, k.id)));
    }

    function tandaiChip() {
        document.querySelectorAll('#chip-kategori button').forEach((b) => {
            const aktif = b.dataset.id === state.kategori;
            b.className = 'rounded-full px-4 py-1.5 text-sm font-semibold transition ' +
                (aktif ? 'bg-teal-700 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200');
        });
    }

    async function muatKampanye() {
        tampilkanSkeleton();
        try {
            const q = new URLSearchParams();
            if (state.cari) q.set('cari', state.cari);
            if (state.kategori) q.set('kategori', state.kategori);
            q.set('page', state.page);

            const res = await fetch(API + '?' + q.toString(), { headers: HEADERS });
            if (!res.ok) throw new Error(T.gagalData + ' (HTTP ' + res.status + ')');
            const json = await res.json();
            render(json.data, json.meta);
        } catch (e) {
            $('grid').replaceChildren();
            window.toast(e.message || T.apiMati, 'error');
            $('info').textContent = T.tidakDimuat;
        }
    }

    // ---------- tampilan ----------
    function tampilkanSkeleton() {
        $('kosong').classList.add('hidden');
        if (state.mode !== 'kartu') return;
        $('grid').replaceChildren(...Array.from({ length: 6 }, () => el('div', 'gk-skeleton h-52 rounded-2xl bg-slate-200')));
    }

    function persen(k) { return k.target > 0 ? Math.min(100, Math.round(k.terkumpul / k.target * 100)) : 0; }

    function kartu(k) {
        const a = el('div', 'group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md');
        if (k.gambar_url) {
            const img = el('img', 'h-40 w-full object-cover'); img.src = k.gambar_url; img.alt = ''; img.loading = 'lazy';
            a.append(img);
        } else {
            const cover = el('div', 'grid h-28 place-items-center bg-gradient-to-br from-teal-700 to-teal-900 text-white/90');
            cover.append(ikonSvg(k.kategori, 'h-12 w-12 opacity-80'));
            a.append(cover);
        }
        const isiKartu = el('div', 'flex flex-1 flex-col p-5');
        const kat = el('span', 'text-xs font-bold uppercase tracking-wide text-teal-700', k.kategori_tampil || '');
        if (k.lokasi) kat.append(el('span', 'font-medium normal-case tracking-normal text-slate-400', ' · ' + k.lokasi));
        const judul = el('a', 'mt-1 block font-extrabold leading-snug hover:text-teal-700', k.judul_tampil || k.judul);
        judul.href = '/kampanye/' + k.id;
        isiKartu.append(kat, judul);

        const bar = el('div', 'mt-4 h-2.5 overflow-hidden rounded-full bg-slate-100');
        const isi = el('div', 'gk-grow h-full rounded-full bg-gradient-to-r from-teal-500 to-emerald-400');
        isi.style.width = persen(k) + '%';
        bar.append(isi);
        const info = el('div', 'mt-2 flex items-end justify-between text-sm');
        const kiri = el('p');
        kiri.append(el('span', 'font-extrabold text-slate-900', rupiah(k.terkumpul)), el('span', 'text-slate-500', ' ' + T.terkumpul));
        info.append(kiri, el('p', 'font-bold text-teal-700', persen(k) + '%'));
        isiKartu.append(bar, info, el('p', 'mt-3 text-xs text-slate-500', T.target + ' ' + rupiah(k.target) + ' · ' + k.jumlah_donasi + ' ' + T.donasi));

        const aksi = el('div', 'mt-4 flex items-center gap-2 border-t border-slate-100 pt-3');
        const detail = el('a', 'rounded-lg bg-teal-50 px-3 py-1.5 text-sm font-bold text-teal-700 hover:bg-teal-100', T.lihat);
        detail.href = '/kampanye/' + k.id;
        aksi.append(detail);
        if (BISA_KELOLA) aksi.append(...tombolKelola(k));
        isiKartu.append(aksi);
        a.append(isiKartu);
        return a;
    }

    function tombolKelola(k) {
        const ubah = el('button', 'ml-auto rounded-lg px-3 py-1.5 text-sm font-semibold text-blue-600 hover:bg-blue-50', T.ubah);
        ubah.type = 'button'; ubah.onclick = () => bukaForm(k.id);
        const hapus = el('button', 'rounded-lg px-3 py-1.5 text-sm font-semibold text-red-600 hover:bg-red-50', T.hapus);
        hapus.type = 'button';
        hapus.onclick = () => window.dispatchEvent(new CustomEvent('konfirmasi', { detail: { nama: k.judul_tampil || k.judul, cb: () => hapusKampanye(k.id) } }));
        return [ubah, hapus];
    }

    function baris(k) {
        const tr = el('tr', 'hover:bg-slate-50');
        [k.kategori_tampil, k.judul_tampil || k.judul, k.lokasi || '-', k.tahun, rupiah(k.target), k.jumlah_donasi].forEach((v, i) => tr.append(el('td', 'p-3' + (i === 1 ? ' font-semibold' : ''), v)));
        const aksi = el('td', 'p-3 text-right whitespace-nowrap');
        const detail = el('a', 'mr-1 rounded-lg px-2 py-1 text-sm font-semibold text-teal-700 hover:bg-teal-50', T.detail);
        detail.href = '/kampanye/' + k.id;
        aksi.append(detail);
        if (BISA_KELOLA) aksi.append(...tombolKelola(k).map((b) => { b.classList.remove('ml-auto'); return b; }));
        tr.append(aksi);
        return tr;
    }

    function render(items, meta) {
        daftar.clear();
        items.forEach((k) => daftar.set(k.id, k));
        $('kosong').classList.toggle('hidden', items.length > 0);
        $('info').textContent = meta.total + ' ' + T.ditemukan;

        $('grid').classList.toggle('hidden', state.mode !== 'kartu');
        $('tabel-wrap').classList.toggle('hidden', state.mode !== 'tabel' || items.length === 0);
        $('grid').replaceChildren(...(state.mode === 'kartu' ? items.map(kartu) : []));
        $('isi-tabel').replaceChildren(...(state.mode === 'tabel' ? items.map(baris) : []));
        renderPaging(meta);
    }

    function renderPaging(meta) {
        const nav = $('paging');
        nav.replaceChildren();
        if (meta.last_page <= 1) return;
        const tombol = (label, page, aktif = false, mati = false) => {
            const b = el('button', 'min-w-[2.5rem] rounded-lg border px-3 py-2 text-sm font-semibold ' +
                (aktif ? 'border-teal-700 bg-teal-700 text-white' : 'border-slate-200 bg-white hover:bg-slate-50') + (mati ? ' opacity-40' : ''), label);
            b.type = 'button'; b.disabled = mati;
            b.onclick = () => { state.page = page; muatKampanye(); window.scrollTo({ top: 0, behavior: 'smooth' }); };
            return b;
        };
        nav.append(tombol('\u2039', meta.current_page - 1, false, meta.current_page === 1));
        for (let p = 1; p <= meta.last_page; p++) nav.append(tombol(p, p, p === meta.current_page));
        nav.append(tombol('\u203A', meta.current_page + 1, false, meta.current_page === meta.last_page));
    }

    function setMode(mode) {
        state.mode = mode;
        try { localStorage.setItem('gk-mode', mode); } catch (e) {}
        const aktif = 'rounded-xl border px-3 py-2 text-sm font-semibold border-teal-700 bg-teal-50 text-teal-700';
        const biasa = 'rounded-xl border px-3 py-2 text-sm font-semibold border-slate-200';
        $('mode-kartu').className = mode === 'kartu' ? aktif : biasa;
        $('mode-tabel').className = mode === 'tabel' ? aktif : biasa;
    }
    $('mode-kartu').onclick = () => { setMode('kartu'); muatKampanye(); };
    $('mode-tabel').onclick = () => { setMode('tabel'); muatKampanye(); };

    $('cari').value = state.cari;
    let timer;
    $('cari').addEventListener('input', (e) => {
        clearTimeout(timer);
        timer = setTimeout(() => { state.cari = e.target.value.trim(); state.page = 1; muatKampanye(); }, 350);
    });

    // ---------- tambah / ubah / hapus (Modul 4 Soal 2, 3, 4, 5) ----------
    if (BISA_KELOLA) {
        const dlg = $('dlg-form');

        $('btn-tambah').onclick = () => { $('form-kampanye').reset(); $('kampanye-id').value = ''; $('judul-form').textContent = T.tambah; $('galat-form').classList.add('hidden'); dlg.showModal(); };
        $('btn-batal').onclick = () => dlg.close();

        window.bukaForm = (id) => {
            const k = daftar.get(id);
            $('kampanye-id').value = k.id;
            $('kategori_id').value = k.kategori_id;
            $('judul').value = k.judul;
            $('penggalang').value = k.penggalang;
            $('tahun_mulai').value = k.tahun;       // atribut API "tahun" -> kolom tahun_mulai
            $('target_dana').value = k.target;      // atribut API "target" -> kolom target_dana
            $('judul-form').textContent = T.ubahJudul;
            $('galat-form').classList.add('hidden');
            dlg.showModal();
        };

        $('form-kampanye').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = $('kampanye-id').value;
            const payload = {
                kategori_id: $('kategori_id').value, judul: $('judul').value, penggalang: $('penggalang').value,
                tahun_mulai: $('tahun_mulai').value, target_dana: $('target_dana').value,
            };
            const tombol = $('btn-simpan');
            tombol.disabled = true;
            try {
                const res = await fetch(id ? `${API}/${id}` : API, { method: id ? 'PUT' : 'POST', headers: HEADERS, body: JSON.stringify(payload) });
                const json = await res.json().catch(() => ({}));

                if (res.status === 422) {                                   // galat validasi
                    const g = $('galat-form');
                    g.textContent = Object.values(json.errors).flat().join(' ');
                    g.classList.remove('hidden');
                    return;
                }
                if (!res.ok) throw new Error(json.message || T.permintaanGagal + ' (HTTP ' + res.status + ')');

                dlg.close();
                window.toast(id ? T.berhasilUbah : T.berhasilTambah);
                await muatKampanye();                                       // tabel/kartu diperbarui tanpa reload
            } catch (err) {
                const g = $('galat-form');
                g.textContent = err.message || T.apiMati;
                g.classList.remove('hidden');
            } finally {
                tombol.disabled = false;
            }
        });
    }

    async function hapusKampanye(id) {
        try {
            const res = await fetch(`${API}/${id}`, { method: 'DELETE', headers: HEADERS });
            if (!res.ok) throw new Error(T.gagalHapus + ' (HTTP ' + res.status + ')');
            window.toast(T.berhasilHapus);
            await muatKampanye();
        } catch (err) {
            window.toast(err.message || T.apiMati, 'error');
        }
    }

    setMode(state.mode);
    muatKategori().then(muatKampanye).catch((e) => window.toast(e.message, 'error'));
</script>
@endsection