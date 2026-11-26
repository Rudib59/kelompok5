@extends('layouts.galangkita')
@section('title', $kampanye->exists ? 'Ubah Kampanye' : 'Tambah Kampanye')

@section('content')
@php
    $input = fn ($n) => 'mt-1 w-full rounded-xl border p-3 text-sm focus:outline-none focus:ring-2 ' . ($errors->has($n) ? 'border-red-400 focus:ring-red-200' : 'border-slate-200 focus:border-teal-500 focus:ring-teal-200');
    $galat = fn ($n) => $errors->has($n) ? '<span role="alert" class="mt-1 block text-xs font-semibold text-red-600">' . e($errors->first($n)) . '</span>' : '';
@endphp
<div class="mx-auto max-w-3xl">
    <a href="{{ route('admin.kampanye.index') }}" class="text-sm font-semibold text-slate-500 hover:text-teal-700">&larr; {{ __('Kembali') }}</a>
    <h1 class="mt-2 text-3xl font-extrabold">{{ $kampanye->exists ? __('Ubah Kampanye') : __('Tambah Kampanye') }}</h1>

    <form method="POST" enctype="multipart/form-data" novalidate
          x-data="{ target: {{ (int) old('target_dana', $kampanye->target_dana) }}, preview: @js($kampanye->gambar_url) }"
          action="{{ $kampanye->exists ? route('admin.kampanye.update', $kampanye) : route('admin.kampanye.store') }}"
          class="mt-6 grid gap-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        @if ($kampanye->exists) @method('PUT') @endif

        <label class="text-sm font-semibold">{{ __('Kategori') }}
            <select name="kategori_id" class="{{ $input('kategori_id') }}">
                @foreach ($kategoris as $kat)
                    <option value="{{ $kat->id }}" @selected(old('kategori_id', $kampanye->kategori_id) == $kat->id)>{{ $kat->nama_tampil }}</option>
                @endforeach
            </select>
            {!! $galat('kategori_id') !!}
        </label>

        <div class="grid gap-5 sm:grid-cols-2">
            <label class="text-sm font-semibold">{{ __('Judul (Indonesia)') }}
                <input name="judul" value="{{ old('judul', $kampanye->judul) }}" class="{{ $input('judul') }}">
                {!! $galat('judul') !!}
            </label>
            <label class="text-sm font-semibold">{{ __('Judul (Inggris)') }}
                <input name="judul_en" value="{{ old('judul_en', $kampanye->judul_en) }}" class="{{ $input('judul_en') }}">
                {!! $galat('judul_en') !!}
            </label>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <label class="text-sm font-semibold">{{ __('Penggalang') }}
                <input name="penggalang" value="{{ old('penggalang', $kampanye->penggalang ?: 'Tim GalangKita') }}" class="{{ $input('penggalang') }}">
                {!! $galat('penggalang') !!}
            </label>
            <label class="text-sm font-semibold">{{ __('Lokasi') }}
                <input name="lokasi" value="{{ old('lokasi', $kampanye->lokasi) }}" class="{{ $input('lokasi') }}" placeholder="{{ __('Kabupaten, Provinsi') }}">
                {!! $galat('lokasi') !!}
            </label>
        </div>

        <label class="text-sm font-semibold">{{ __('Deskripsi (Indonesia)') }}
            <textarea name="deskripsi" rows="4" class="{{ $input('deskripsi') }}">{{ old('deskripsi', $kampanye->deskripsi) }}</textarea>
            {!! $galat('deskripsi') !!}
        </label>
        <label class="text-sm font-semibold">{{ __('Deskripsi (Inggris)') }}
            <textarea name="deskripsi_en" rows="4" class="{{ $input('deskripsi_en') }}">{{ old('deskripsi_en', $kampanye->deskripsi_en) }}</textarea>
            {!! $galat('deskripsi_en') !!}
        </label>

        <fieldset class="grid gap-5 rounded-xl bg-slate-50 p-4 sm:grid-cols-3">
            <legend class="px-1 text-sm font-extrabold">{{ __('Sumber informasi') }}</legend>
            <label class="text-sm font-semibold">{{ __('Nama sumber') }}
                <input name="sumber_nama" value="{{ old('sumber_nama', $kampanye->sumber_nama) }}" class="{{ $input('sumber_nama') }}" placeholder="BNPB">
                {!! $galat('sumber_nama') !!}
            </label>
            <label class="text-sm font-semibold">{{ __('Tanggal laporan') }}
                <input type="date" name="sumber_tanggal" value="{{ old('sumber_tanggal', $kampanye->sumber_tanggal?->format('Y-m-d')) }}" class="{{ $input('sumber_tanggal') }}">
                {!! $galat('sumber_tanggal') !!}
            </label>
            <label class="text-sm font-semibold">{{ __('Tautan sumber') }}
                <input name="sumber_url" value="{{ old('sumber_url', $kampanye->sumber_url) }}" class="{{ $input('sumber_url') }}" placeholder="https://...">
                {!! $galat('sumber_url') !!}
            </label>
        </fieldset>

        <div class="grid gap-5 sm:grid-cols-2">
            <label class="text-sm font-semibold">{{ __('Tahun mulai') }}
                <input type="number" name="tahun_mulai" value="{{ old('tahun_mulai', $kampanye->tahun_mulai ?: date('Y')) }}" class="{{ $input('tahun_mulai') }}">
                {!! $galat('tahun_mulai') !!}
            </label>
            <label class="text-sm font-semibold">{{ __('Target dana (Rp)') }}
                <input type="number" name="target_dana" x-model.number="target" class="{{ $input('target_dana') }}">
                <span class="text-xs font-normal text-slate-500" x-text="'= Rp ' + Number(target || 0).toLocaleString('{{ app()->getLocale() === 'en' ? 'en-US' : 'id-ID' }}')"></span>
                {!! $galat('target_dana') !!}
            </label>
        </div>

        <div>
            <p class="text-sm font-semibold">{{ __('Foto kampanye') }}</p>
            <div class="mt-2 flex flex-wrap items-center gap-4">
                <div class="grid h-24 w-40 place-items-center overflow-hidden rounded-xl border border-dashed border-slate-300 bg-slate-50 text-slate-400">
                    <template x-if="preview"><img :src="preview" alt="" class="h-full w-full object-cover"></template>
                    <template x-if="!preview"><x-icon name="image" class="h-8 w-8" /></template>
                </div>
                <div class="space-y-2">
                    <input type="file" name="gambar" accept="image/png,image/jpeg,image/webp"
                           x-on:change="const f = $event.target.files[0]; if (f) preview = URL.createObjectURL(f)"
                           class="block text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-teal-50 file:px-4 file:py-2 file:text-sm file:font-bold file:text-teal-700 hover:file:bg-teal-100">
                    <p class="text-xs text-slate-500">{{ __('JPG, PNG, atau WEBP. Maksimal 3 MB. Pakai foto yang Anda punya hak pakainya.') }}</p>
                    @if ($kampanye->gambar)
                        <label class="flex items-center gap-2 text-xs text-slate-600"><input type="checkbox" name="hapus_gambar" value="1" x-on:change="if ($event.target.checked) preview = null" class="rounded border-slate-300 text-red-600"> {{ __('Hapus foto saat ini') }}</label>
                    @endif
                </div>
            </div>
            {!! $galat('gambar') !!}
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.kampanye.index') }}" class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold hover:bg-slate-50">{{ __('Batal') }}</a>
            <button class="rounded-xl bg-teal-700 px-6 py-2.5 text-sm font-bold text-white hover:bg-teal-800">{{ __('Simpan') }}</button>
        </div>
    </form>
</div>
@endsection
