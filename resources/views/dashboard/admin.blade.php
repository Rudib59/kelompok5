@extends('layouts.galangkita')
@section('title', 'Dashboard Admin')

@section('content')
<h1 class="text-3xl font-extrabold">{{ __('Dashboard Admin') }}</h1>
<p class="mt-1 text-slate-600">{{ __('Halo, :nama. Ini ringkasan GalangKita hari ini.', ['nama' => auth()->user()->name]) }}</p>

<div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <x-stat label="Pengguna" :nilai="$jumlahUser" ikon="users" warna="bg-sky-50 text-sky-700" />
    <x-stat label="Kampanye" :nilai="$jumlahKampanye" ikon="megaphone" warna="bg-violet-50 text-violet-700" />
    <x-stat label="Dana terverifikasi" :nilai="'Rp ' . number_format($totalTerverifikasi, 0, ',', '.')" ikon="wallet" />
    <x-stat label="Menunggu verifikasi" :nilai="$menunggu" ikon="clock" warna="bg-teal-50 text-teal-700" />
</div>

<div class="mt-6 grid gap-6 lg:grid-cols-3">
    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm lg:col-span-2">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-extrabold">{{ __('Donasi terbaru') }}</h2>
            <a href="{{ route('donasi.index') }}" class="text-sm font-bold text-teal-700 hover:underline">{{ __('Lihat semua') }}</a>
        </div>
        <ul class="mt-3 divide-y divide-slate-100">
            @foreach ($terbaru as $d)
                <li class="flex items-center gap-3 py-3">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-teal-100 font-bold text-teal-700">{{ strtoupper(mb_substr($d->donatur->nama, 0, 1)) }}</span>
                    <div class="min-w-0 flex-1">
                        <p class="truncate font-semibold">{{ $d->donatur->nama }}</p>
                        <p class="truncate text-xs text-slate-500">{{ $d->kampanye->judul_tampil }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-extrabold">Rp {{ number_format($d->nominal, 0, ',', '.') }}</p>
                        <x-status-badge :terverifikasi="(bool) $d->tanggal_verifikasi" />
                    </div>
                </li>
            @endforeach
        </ul>
    </section>

    <div class="space-y-6">
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-lg font-extrabold">{{ __('Kampanye per kategori') }}</h2>
            @php $maks = max(1, $perKategori->max('kampanyes_count')); @endphp
            <ul class="mt-4 space-y-3">
                @foreach ($perKategori as $kat)
                    <li>
                        <div class="flex justify-between text-sm"><span class="font-semibold">{{ $kat->nama_tampil }}</span><span class="text-slate-500">{{ $kat->kampanyes_count }}</span></div>
                        <div class="mt-1 h-2 rounded-full bg-slate-100"><div class="h-2 rounded-full bg-teal-500" style="width: {{ $kat->kampanyes_count / $maks * 100 }}%"></div></div>
                    </li>
                @endforeach
            </ul>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-lg font-extrabold">{{ __('Pintasan') }}</h2>
            <div class="mt-3 grid gap-2">
                <a href="{{ route('admin.kampanye.create') }}" class="rounded-xl bg-teal-700 px-4 py-2.5 text-center text-sm font-bold text-white hover:bg-teal-800">{{ __('+ Kampanye baru') }}</a>
                <a href="{{ route('admin.pengguna.index') }}" class="rounded-xl border border-slate-200 px-4 py-2.5 text-center text-sm font-bold hover:bg-slate-50">{{ __('Kelola pengguna & role') }}</a>
                <a href="{{ route('laporan.index') }}" class="rounded-xl border border-slate-200 px-4 py-2.5 text-center text-sm font-bold hover:bg-slate-50">{{ __('Lihat laporan') }}</a>
            </div>
        </section>
    </div>
</div>
@endsection
