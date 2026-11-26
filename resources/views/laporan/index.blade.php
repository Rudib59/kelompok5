@extends('layouts.galangkita')
@section('title', 'Laporan')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-extrabold">{{ __('Laporan Penggalangan Dana') }}</h1>
        <p class="mt-1 text-slate-600">{{ __('Dihitung dari donasi yang sudah terverifikasi.') }}</p>
    </div>
    <a href="{{ route('laporan.export-pdf') }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl bg-teal-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-teal-800">
        {{ __('Cetak PDF') }}
    </a>
</div>

@php $maks = max(1, (int) $rekap->max('total')); @endphp
<div class="mt-6 grid gap-4 sm:grid-cols-2">
    <x-stat label="Total dana terverifikasi" :nilai="'Rp ' . number_format($rekap->sum('total'), 0, ',', '.')" ikon="wallet" />
    <x-stat label="Jumlah donasi terverifikasi" :nilai="$rekap->sum('jumlah')" ikon="receipt" warna="bg-sky-50 text-sky-700" />
</div>

<section class="mt-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
    <h2 class="text-lg font-extrabold">{{ __('Dana per kampanye') }}</h2>
    <ul class="mt-4 space-y-4">
        @forelse ($rekap as $r)
            <li>
                <div class="flex flex-wrap justify-between gap-2 text-sm">
                    <span class="font-semibold">{{ app()->getLocale() === 'en' && $r->judul_en ? $r->judul_en : $r->judul }}</span>
                    <span class="text-slate-500">{{ $r->jumlah }} donasi &middot; <span class="font-extrabold text-slate-900">Rp {{ number_format($r->total, 0, ',', '.') }}</span></span>
                </div>
                <div class="mt-1.5 h-2.5 rounded-full bg-slate-100"><div class="h-2.5 rounded-full bg-gradient-to-r from-teal-500 to-emerald-400" style="width: {{ $r->total / $maks * 100 }}%"></div></div>
            </li>
        @empty
            <li class="py-8 text-center text-slate-500">{{ __('Belum ada donasi terverifikasi.') }}</li>
        @endforelse
    </ul>
</section>
@endsection
