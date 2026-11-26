@extends('layouts.galangkita')
@section('title', 'Detail Donasi')

@section('content')
<div class="mx-auto max-w-xl">
    <a href="javascript:history.back()" class="text-sm font-semibold text-slate-500 hover:text-teal-700">&larr; {{ __('Kembali') }}</a>
    <div class="mt-4 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="bg-teal-700 p-6 text-white">
            <p class="text-sm font-semibold text-teal-100">{{ __('Bukti donasi') }}</p>
            <p class="mt-1 text-3xl font-extrabold">Rp {{ number_format($donasi->nominal, 0, ',', '.') }}</p>
            <p class="mt-1 text-sm text-teal-100">{{ __('Donasi') }} #{{ str_pad($donasi->id, 5, '0', STR_PAD_LEFT) }}</p>
        </div>
        <dl class="divide-y divide-slate-100 px-6">
            <div class="flex justify-between gap-4 py-3"><dt class="text-slate-500">{{ __('Donatur') }}</dt><dd class="text-right font-semibold">{{ $donasi->donatur->nama }}<br><span class="text-xs font-normal text-slate-500">{{ $donasi->donatur->email }}</span></dd></div>
            <div class="flex justify-between gap-4 py-3"><dt class="text-slate-500">{{ __('Kampanye') }}</dt><dd class="text-right font-semibold">{{ $donasi->kampanye->judul_tampil }}</dd></div>
            <div class="flex justify-between gap-4 py-3"><dt class="text-slate-500">{{ __('Tanggal donasi') }}</dt><dd class="font-semibold">{{ $donasi->tanggal_donasi }}</dd></div>
            <div class="flex items-center justify-between gap-4 py-3"><dt class="text-slate-500">{{ __('Status') }}</dt><dd><x-status-badge :terverifikasi="(bool) $donasi->tanggal_verifikasi" /></dd></div>
            @if ($donasi->tanggal_verifikasi)
                <div class="flex justify-between gap-4 py-3"><dt class="text-slate-500">{{ __('Diverifikasi') }}</dt><dd class="font-semibold">{{ $donasi->tanggal_verifikasi }}</dd></div>
            @endif
        </dl>
    </div>
</div>
@endsection
