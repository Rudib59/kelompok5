@extends('layouts.galangkita')
@section('title', 'Riwayat Donasi')

@section('content')
<h1 class="text-3xl font-extrabold">{{ __('Riwayat Donasi Saya') }}</h1>
<p class="mt-1 text-slate-600">{{ __('Terima kasih atas kebaikanmu.') }}</p>

@php $total = $donasis->getCollection()->whereNotNull('tanggal_verifikasi')->sum('nominal'); @endphp
<div class="mt-6 grid gap-4 sm:grid-cols-2">
    <x-stat label="Total donasi terverifikasi (halaman ini)" :nilai="'Rp ' . number_format($total, 0, ',', '.')" ikon="heart" />
    <x-stat label="Jumlah donasi" :nilai="$donasis->total()" ikon="receipt" warna="bg-sky-50 text-sky-700" />
</div>

<ul class="mt-6 space-y-3">
    @forelse ($donasis as $d)
        <li>
            <a href="{{ route('donasi.show', $d->id) }}" class="flex flex-wrap items-center gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:shadow-md">
                <x-kategori-ikon :nama="$d->kampanye->kategori->nama ?? ''" ukuran="h-11 w-11" />
                <div class="min-w-0 flex-1">
                    <p class="truncate font-bold">{{ $d->kampanye->judul_tampil }}</p>
                    <p class="text-xs text-slate-500">{{ $d->tanggal_donasi }}</p>
                </div>
                <p class="font-extrabold">Rp {{ number_format($d->nominal, 0, ',', '.') }}</p>
                <x-status-badge :terverifikasi="(bool) $d->tanggal_verifikasi" />
            </a>
        </li>
    @empty
        <li class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center">
            <x-icon name="leaf" class="mx-auto h-10 w-10 text-teal-600" />
            <p class="mt-2 font-extrabold">{{ __('Belum ada donasi') }}</p>
            <a href="{{ route('kampanye.index') }}" class="mt-3 inline-block rounded-xl bg-teal-700 px-5 py-2.5 text-sm font-bold text-white hover:bg-teal-800">{{ __('Cari kampanye') }}</a>
        </li>
    @endforelse
</ul>
<div class="mt-4">{{ $donasis->links() }}</div>
@endsection
