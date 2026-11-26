@extends('layouts.galangkita')
@section('title', 'Dashboard Petugas')

@section('content')
<h1 class="text-3xl font-extrabold">{{ __('Dashboard Petugas') }}</h1>
<p class="mt-1 text-slate-600">{{ __('Verifikasi donasi yang masuk agar tercatat di kampanye.') }}</p>

<div class="mt-6 grid gap-4 sm:grid-cols-3">
    <x-stat label="Menunggu verifikasi" :nilai="$menunggu" ikon="clock" warna="bg-teal-50 text-teal-700" />
    <x-stat label="Diverifikasi hari ini" :nilai="$selesaiHariIni" ikon="check" />
    <x-stat label="Total donasi" :nilai="$totalDonasi" ikon="receipt" warna="bg-sky-50 text-sky-700" />
</div>

<section class="mt-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-extrabold">{{ __('Antrian verifikasi') }}</h2>
        <a href="{{ route('donasi.index', ['status' => 'menunggu']) }}" class="text-sm font-bold text-teal-700 hover:underline">{{ __('Lihat semua antrian') }}</a>
    </div>
    <ul class="mt-3 divide-y divide-slate-100">
        @forelse ($antrian as $d)
            <li class="flex flex-wrap items-center gap-3 py-3">
                <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-teal-100 font-bold text-teal-700">{{ strtoupper(mb_substr($d->donatur->nama, 0, 1)) }}</span>
                <div class="min-w-0 flex-1">
                    <p class="truncate font-semibold">{{ $d->donatur->nama }} <span class="font-normal text-slate-500">&middot; Rp {{ number_format($d->nominal, 0, ',', '.') }}</span></p>
                    <p class="truncate text-xs text-slate-500">{{ $d->kampanye->judul_tampil }}</p>
                </div>
                <a href="{{ route('donasi.show', $d->id) }}" class="text-sm font-semibold text-slate-600 hover:underline">{{ __('Detail') }}</a>
                @can('mencatat-verifikasi-pembayaran')
                    <form method="POST" action="{{ route('donasi.verifikasi', $d) }}">
                        @csrf
                        @method('PATCH')
                        <button class="rounded-lg bg-teal-700 px-4 py-2 text-sm font-bold text-white hover:bg-teal-800">{{ __('Verifikasi') }}</button>
                    </form>
                @endcan
            </li>
        @empty
            <li class="py-10 text-center text-slate-500">{{ __('Semua donasi sudah diverifikasi. Kerja bagus!') }}</li>
        @endforelse
    </ul>
</section>
@endsection
