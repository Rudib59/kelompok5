@extends('layouts.galangkita')
@section('title', 'Daftar Donasi')

@section('content')
<h1 class="text-3xl font-extrabold">{{ __('Daftar Donasi') }}</h1>

<div class="mt-4 flex flex-wrap gap-2">
    @php
        $tabs = [[null, __('Semua'), $jumlahSemua], ['menunggu', __('Menunggu'), $jumlahMenunggu], ['terverifikasi', __('Terverifikasi'), $jumlahSemua - $jumlahMenunggu]];
    @endphp
    @foreach ($tabs as [$val, $label, $jml])
        <a href="{{ route('donasi.index', array_filter(['status' => $val])) }}"
           class="rounded-full px-4 py-1.5 text-sm font-semibold {{ $status === $val ? 'bg-teal-700 text-white' : 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50' }}">
            {{ $label }} <span class="opacity-70">{{ $jml }}</span>
        </a>
    @endforeach
</div>

<div class="mt-4 overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
    <table class="w-full min-w-[720px] text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
            <tr><th class="p-3">{{ __('Donatur') }}</th><th class="p-3">{{ __('Kampanye') }}</th><th class="p-3">{{ __('Nominal') }}</th><th class="p-3">{{ __('Tanggal') }}</th><th class="p-3">{{ __('Status') }}</th><th class="p-3 text-right">{{ __('Aksi') }}</th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
        @forelse ($donasis as $d)
            <tr class="hover:bg-slate-50">
                <td class="p-3 font-semibold">{{ $d->donatur->nama }}</td>
                <td class="max-w-[16rem] truncate p-3 text-slate-600">{{ $d->kampanye->judul_tampil }}</td>
                <td class="p-3 font-extrabold">Rp {{ number_format($d->nominal, 0, ',', '.') }}</td>
                <td class="p-3 text-slate-500">{{ $d->tanggal_donasi }}</td>
                <td class="p-3"><x-status-badge :terverifikasi="(bool) $d->tanggal_verifikasi" /></td>
                <td class="whitespace-nowrap p-3 text-right">
                    <a href="{{ route('donasi.show', $d->id) }}" class="rounded-lg px-3 py-1.5 text-sm font-semibold text-slate-600 hover:bg-slate-100">{{ __('Detail') }}</a>
                    @can('mencatat-verifikasi-pembayaran')
                        @unless ($d->tanggal_verifikasi)
                            <form method="POST" action="{{ route('donasi.verifikasi', $d) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button class="rounded-lg bg-teal-700 px-3 py-1.5 text-sm font-bold text-white hover:bg-teal-800">{{ __('Verifikasi') }}</button>
                            </form>
                        @endunless
                    @endcan
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="p-10 text-center text-slate-500">{{ __('Tidak ada donasi pada filter ini.') }}</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $donasis->links() }}</div>
@endsection