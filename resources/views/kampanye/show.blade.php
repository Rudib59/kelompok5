@extends('layouts.galangkita')
@section('title', $kampanye->judul_tampil)

@section('content')
@php
    $bisaDonasi = auth()->user()?->donatur;
    $sisa = max(0, $kampanye->target_dana - (int) $kampanye->terkumpul);
@endphp
<a href="{{ route('kampanye.index') }}" class="text-sm font-semibold text-slate-500 hover:text-teal-700">&larr; {{ __('Semua kampanye') }}</a>

<div class="mt-4 grid gap-6 lg:grid-cols-3"
     x-data="{ buka: {{ $errors->has('nominal') || $errors->has('kampanye_id') ? 'true' : 'false' }}, nominal: {{ (int) old('nominal', 50000) }} }"
     x-effect="document.body.classList.toggle('overflow-hidden', buka)"
     x-on:keydown.escape.window="buka = false">
    <div class="lg:col-span-2">
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            @if ($kampanye->gambar_url)
                <img src="{{ $kampanye->gambar_url }}" alt="" class="h-56 w-full object-cover sm:h-72">
            @else
                <div class="grid h-32 place-items-center bg-gradient-to-br from-teal-700 to-teal-900 text-white/90 sm:h-40">
                    <x-icon :name="match($kampanye->kategori->nama) { 'Pendidikan' => 'book', 'Kesehatan' => 'health', 'Lingkungan' => 'leaf', 'Kemanusiaan' => 'heart', default => 'drop' }" class="h-14 w-14 opacity-80" />
                </div>
            @endif
            <div class="p-6">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="rounded-full bg-teal-50 px-3 py-1 text-xs font-bold uppercase tracking-wide text-teal-700">{{ $kampanye->kategori->nama_tampil }}</span>
                    @if ($kampanye->lokasi)
                        <span class="text-sm text-slate-500">{{ $kampanye->lokasi }}</span>
                    @endif
                </div>
                <h1 class="mt-3 text-2xl font-extrabold leading-snug sm:text-3xl">{{ $kampanye->judul_tampil }}</h1>
                <p class="mt-1 text-slate-500">{{ __('Digalang oleh') }} <span class="font-semibold text-slate-700">{{ $kampanye->penggalang }}</span> &middot; {{ __('sejak') }} {{ $kampanye->tahun_mulai }}</p>

                <x-progress :terkumpul="(int) $kampanye->terkumpul" :target="$kampanye->target_dana" class="mt-8" />

                <div class="mt-6 grid grid-cols-3 divide-x divide-slate-100 rounded-xl bg-slate-50 py-4 text-center">
                    <div><p class="text-xl font-extrabold">{{ $kampanye->jumlah_donatur }}</p><p class="text-xs text-slate-500">{{ __('Donasi terverifikasi') }}</p></div>
                    <div><p class="text-xl font-extrabold">Rp {{ number_format($kampanye->target_dana, 0, ',', '.') }}</p><p class="text-xs text-slate-500">{{ __('Target dana') }}</p></div>
                    <div><p class="text-xl font-extrabold">Rp {{ number_format($sisa, 0, ',', '.') }}</p><p class="text-xs text-slate-500">{{ __('Masih dibutuhkan') }}</p></div>
                </div>
            </div>
        </div>

        @if ($kampanye->deskripsi_tampil)
            <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-extrabold">{{ __('Cerita kampanye') }}</h2>
                <p class="mt-3 leading-relaxed text-slate-700">{{ $kampanye->deskripsi_tampil }}</p>

                @if ($kampanye->sumber_nama)
                    <div class="mt-5 flex items-start gap-3 rounded-xl bg-slate-50 p-4 text-sm">
                        <x-icon name="link" class="mt-0.5 h-5 w-5 shrink-0 text-teal-700" />
                        <div>
                            <p class="font-bold">{{ __('Sumber informasi') }}</p>
                            <p class="text-slate-600">
                                {{ $kampanye->sumber_nama }}@if($kampanye->sumber_tanggal), {{ $kampanye->sumber_tanggal->translatedFormat('j F Y') }}@endif
                            </p>
                            @if ($kampanye->sumber_url)
                                <a href="{{ $kampanye->sumber_url }}" target="_blank" rel="noopener noreferrer" class="mt-1 inline-block break-all font-semibold text-teal-700 hover:underline">{{ __('Buka laporan asli') }} &rarr;</a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-extrabold">{{ __('Donatur terbaru') }}</h2>
            <ul class="mt-4 divide-y divide-slate-100">
                @forelse ($kampanye->donasis as $d)
                    <li class="flex items-center gap-3 py-3">
                        <span class="grid h-10 w-10 place-items-center rounded-full bg-teal-100 font-bold text-teal-700">{{ strtoupper(mb_substr($d->donatur->nama, 0, 1)) }}</span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate font-semibold">{{ mb_substr($d->donatur->nama, 0, 1) }}{{ str_repeat('*', max(2, min(8, mb_strlen($d->donatur->nama) - 1))) }}</p>
                            <p class="text-xs text-slate-500">{{ \Illuminate\Support\Carbon::parse($d->tanggal_donasi)->diffForHumans() }}</p>
                        </div>
                        <p class="font-extrabold text-teal-700">Rp {{ number_format($d->nominal, 0, ',', '.') }}</p>
                    </li>
                @empty
                    <li class="py-6 text-center text-slate-500">{{ __('Belum ada donasi terverifikasi. Jadilah yang pertama!') }}</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- Ringkasan dan tombol donasi (form ada di modal) --}}
    <aside class="lg:sticky lg:top-24 lg:self-start">
        <div class="rounded-2xl border border-teal-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold text-slate-500">{{ __('Terkumpul') }}</p>
            <p class="gk-serif text-3xl text-teal-800">Rp {{ number_format((int) $kampanye->terkumpul, 0, ',', '.') }}</p>
            <p class="mt-1 text-sm text-slate-500">{{ __('dari target') }} Rp {{ number_format($kampanye->target_dana, 0, ',', '.') }}</p>

            @if ($bisaDonasi)
                <button type="button" x-on:click="buka = true" class="mt-5 w-full rounded-xl gk-btn-gold py-3 font-extrabold shadow-sm">{{ __('Donasi sekarang') }}</button>
            @else
                <p class="mt-5 rounded-xl bg-slate-50 p-3 text-sm text-slate-600">{{ __('Akun :role tidak dapat berdonasi. Gunakan akun donatur untuk berdonasi.', ['role' => __(auth()->user()->getRoleNames()->first() ?? 'tanpa role')]) }}</p>
            @endif
        </div>

        @can('kelola-kampanye')
            <a href="{{ route('admin.kampanye.edit', $kampanye) }}" class="mt-4 block rounded-xl border border-slate-200 bg-white py-3 text-center text-sm font-bold hover:bg-slate-50">{{ __('Ubah kampanye ini') }}</a>
        @endcan
    </aside>

    {{-- Modal donasi: tidak bisa digulir, ditutup dengan tombol X, Esc, atau klik di luar --}}
    @if ($bisaDonasi)
    <div x-show="buka" x-cloak x-transition.opacity class="fixed inset-0 z-50 grid place-items-center bg-slate-900/55 p-4 backdrop-blur-sm" role="dialog" aria-modal="true" aria-labelledby="judul-donasi">
        <form method="POST" action="{{ route('donasi.store') }}" x-on:click.outside="buka = false" x-transition
              class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
            @csrf
            <input type="hidden" name="kampanye_id" value="{{ $kampanye->id }}">

            <button type="button" x-on:click="buka = false" aria-label="{{ __('Tutup') }}"
                    class="absolute right-3 top-3 grid h-9 w-9 place-items-center rounded-full text-slate-500 hover:bg-slate-100 hover:text-slate-800">
                <x-icon name="x" class="h-5 w-5" />
            </button>

            <h2 id="judul-donasi" class="pr-10 text-lg font-extrabold">{{ __('Berdonasi sekarang') }}</h2>
            <p class="mt-1 line-clamp-2 text-sm text-slate-500">{{ $kampanye->judul_tampil }}</p>

            <div class="mt-4 grid grid-cols-3 gap-2">
                @foreach ([25000, 50000, 100000, 250000, 500000, 1000000] as $n)
                    <button type="button" x-on:click="nominal = {{ $n }}"
                            :class="nominal === {{ $n }} ? 'border-teal-700 bg-teal-50 text-teal-700' : 'border-slate-200 hover:bg-slate-50'"
                            class="rounded-xl border px-2 py-2 text-sm font-bold">{{ $n >= 1000000 ? '1 ' . __('jt') : number_format($n / 1000, 0) . 'rb' }}</button>
                @endforeach
            </div>

            <label class="mt-4 block text-sm font-semibold">{{ __('Nominal lainnya (Rp)') }}
                <input type="number" name="nominal" min="10000" step="1000" x-model.number="nominal" required inputmode="numeric"
                       class="mt-1 w-full rounded-xl border p-3 text-lg font-extrabold focus:outline-none focus:ring-2 {{ $errors->has('nominal') ? 'border-red-400 focus:ring-red-200' : 'border-slate-200 focus:border-teal-500 focus:ring-teal-200' }}">
            </label>
            @error('nominal')
                <p role="alert" class="mt-1.5 flex items-start gap-1.5 text-xs font-semibold text-red-600"><x-icon name="alert" class="mt-px h-4 w-4 shrink-0" />{{ $message }}</p>
            @else
                <p class="mt-1 text-xs text-slate-500">{{ __('Minimal Rp 10.000') }}</p>
            @enderror

            <p class="mt-3 rounded-lg bg-slate-50 p-3 text-xs text-slate-600">{{ __('Donasimu akan diverifikasi petugas sebelum tercatat.') }}</p>

            <button class="mt-4 w-full rounded-xl gk-btn-gold py-3 font-extrabold shadow-sm">
                {{ __('Donasi') }} <span x-text="'Rp ' + Number(nominal || 0).toLocaleString('{{ app()->getLocale() === 'en' ? 'en-US' : 'id-ID' }}')"></span>
            </button>
        </form>
    </div>
    @endif
</div>
@endsection
