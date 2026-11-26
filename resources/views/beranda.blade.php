@extends('layouts.galangkita')
@section('title', __('Beranda'))
@section('flush', '1')

@section('content')
@php $foto = file_exists(public_path('images/hero.jpg')) ? asset('images/hero.jpg') : null; @endphp
{{-- HERO --}}
<section class="gk-hero text-white" @if($foto) style="background-image: linear-gradient(150deg, rgba(4,47,46,.9) 0%, rgba(15,93,87,.8) 60%, rgba(15,118,110,.7) 100%), url('{{ $foto }}'); background-size: cover; background-position: center;" @endif>
    <div class="mx-auto grid max-w-6xl items-center gap-12 px-4 py-20 sm:px-6 lg:grid-cols-2 lg:py-28">
        <div class="gk-reveal">
            <span class="inline-flex items-center gap-2 rounded-full bg-white/5 px-4 py-1.5 text-xs font-semibold uppercase tracking-widest text-orange-200 ring-1 ring-orange-200/30">
                {{ __('Donasi transparan') }} &middot; {{ __('diverifikasi petugas') }}
            </span>
            <h1 class="mt-6 text-4xl leading-[1.1] sm:text-6xl">
                {{ __('Satu donasi kecil,') }} <span class="gk-gold">{{ __('senyum besar') }}</span> {{ __('untuk mereka.') }}
            </h1>
            <p class="mt-6 max-w-lg text-lg leading-relaxed text-stone-300">
                {{ __('GalangKita menghubungkan donatur dengan kampanye sosial pilihan di bidang pendidikan, kesehatan, bencana alam, dan lingkungan. Mulai dari Rp 10.000.') }}
            </p>
            <div class="mt-10 flex flex-wrap gap-3">
                @auth
                    <a href="{{ route('kampanye.index') }}" class="gk-btn-gold rounded-xl px-7 py-3.5 font-bold shadow-lg">{{ __('Lihat semua kampanye') }}</a>
                    <a href="{{ route('dashboard') }}" class="rounded-xl border border-white/20 px-7 py-3.5 font-bold text-white hover:bg-white/5">{{ __('Ke dashboard') }}</a>
                @else
                    <a href="{{ route('register') }}" class="gk-btn-gold rounded-xl px-7 py-3.5 font-bold shadow-lg">{{ __('Mulai berdonasi') }}</a>
                @endauth
            </div>
        </div>

        <div class="gk-reveal grid grid-cols-2 gap-4" style="--d: 150ms">
            <div class="col-span-2 rounded-2xl bg-white/5 p-6 ring-1 ring-white/10 backdrop-blur">
                <p class="text-sm font-semibold uppercase tracking-widest text-stone-400">{{ __('Dana terkumpul') }}</p>
                <p class="gk-serif gk-gold mt-2 text-4xl font-bold sm:text-5xl">Rp {{ number_format($totalTerkumpul, 0, ',', '.') }}</p>
            </div>
            @php
                $angka = [[__('Kampanye aktif'), $jumlahKampanye], [__('Donatur'), $jumlahDonatur], [__('Donasi tercatat'), $jumlahDonasi]];
            @endphp
            @foreach ($angka as [$l, $n])
                <div class="rounded-2xl bg-white/5 p-5 ring-1 ring-white/10 {{ $loop->last ? 'col-span-2' : '' }}">
                    <p class="text-xs font-semibold uppercase tracking-widest text-stone-400">{{ $l }}</p>
                    <p class="gk-serif mt-1 text-3xl font-bold text-white">{{ $n }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- KATEGORI --}}
<section class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
    <h2 class="gk-reveal text-2xl font-extrabold">{{ __('Pilih sesuai kepedulianmu') }}</h2>
    <div class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5">
        @foreach ($kategoris as $kat)
            <a href="{{ route('kampanye.index', ['kategori' => $kat->id]) }}" style="--d: {{ $loop->index * 70 }}ms"
               class="gk-reveal flex flex-col items-center gap-2 rounded-2xl border border-slate-200 bg-white p-5 text-center shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <x-kategori-ikon :nama="$kat->nama" />
                <span class="font-bold">{{ $kat->nama_tampil }}</span>
                <span class="text-xs text-slate-500">{{ $kat->kampanyes_count }} {{ __('kampanye') }}</span>
            </a>
        @endforeach
    </div>
</section>

{{-- KAMPANYE TERBARU --}}
<section class="mx-auto max-w-6xl px-4 pb-12 sm:px-6">
    <div class="gk-reveal flex items-end justify-between">
        <h2 class="text-2xl font-extrabold">{{ __('Kampanye terbaru') }}</h2>
        <a href="{{ route('kampanye.index') }}" class="text-sm font-bold text-teal-700 hover:underline">{{ __('Lihat semua') }} &rarr;</a>
    </div>
    <div class="mt-5 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($unggulan as $k)
            <div class="gk-reveal" style="--d: {{ ($loop->index % 3) * 90 }}ms"><x-kampanye-card :kampanye="$k" /></div>
        @endforeach
    </div>
</section>

{{-- CARA KERJA --}}
<section class="border-y border-slate-200 bg-white">
    <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
        <h2 class="gk-reveal text-center text-2xl font-extrabold">{{ __('Cara berdonasi') }}</h2>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
            @foreach ([['1', 'Pilih kampanye', 'Telusuri kampanye dan baca ceritanya, lalu pilih yang paling menyentuh hatimu.'],
                       ['2', 'Tentukan nominal', 'Mulai dari Rp 10.000. Pilih nominal cepat atau isi sendiri.'],
                       ['3', 'Diverifikasi petugas', 'Petugas memverifikasi donasimu, lalu dana tercatat di kampanye dan riwayatmu.']] as [$no, $judul, $isi])
                <div class="gk-reveal rounded-2xl bg-slate-50 p-6" style="--d: {{ $loop->index * 100 }}ms">
                    <span class="grid h-10 w-10 place-items-center rounded-full gk-btn-gold font-extrabold">{{ $no }}</span>
                    <h3 class="mt-4 text-lg font-extrabold">{{ __($judul) }}</h3>
                    <p class="mt-1 text-slate-600">{{ __($isi) }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- SUMBER --}}
<section class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
    <div class="gk-reveal flex flex-col items-start gap-4 rounded-2xl border border-teal-100 bg-teal-50/60 p-6 sm:flex-row sm:items-center">
        <span class="grid h-12 w-12 shrink-0 place-items-center rounded-xl bg-teal-700 text-white"><x-icon name="shield" class="h-6 w-6" /></span>
        <div>
            <h2 class="text-lg font-extrabold">{{ __('Setiap kampanye menyertakan sumbernya') }}</h2>
            <p class="mt-1 text-sm text-slate-600">{{ __('Fakta kejadian pada kampanye dirujuk dari laporan BNPB, Kemenkes, dan Kemendikdasmen beserta tanggal dan tautannya, sehingga Anda bisa memeriksanya sendiri.') }}</p>
        </div>
        <a href="{{ route('tentang') }}" class="shrink-0 rounded-xl border border-teal-200 bg-white px-5 py-2.5 text-sm font-bold text-teal-800 hover:bg-teal-50 sm:ml-auto">{{ __('Pelajari lebih lanjut') }}</a>
    </div>
</section>
@endsection