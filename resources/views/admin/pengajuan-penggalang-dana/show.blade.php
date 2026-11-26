@extends('layouts.galangkita')

@section('title', __('Periksa Identitas Penggalang Dana'))

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="mb-6">
        <a
            href="{{ route('admin.pengajuan-penggalang-dana.index') }}"
            class="text-sm font-semibold text-teal-700 hover:text-teal-800"
        >
            &larr; Kembali ke Daftar Pengajuan
        </a>

        <h1 class="mt-4 text-2xl font-bold text-gray-900">{{ __('Pemeriksaan Identitas') }}</h1>
        <p class="mt-2 text-gray-600">{{ __('Periksa kesesuaian data identitas sebelum menyetujui atau menolak pengajuan.') }}</p>
    </div>

    @if (session('success'))
        <div class="mb-5 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-gray-900">{{ __('Status') }} Pengajuan</h2>
                <p class="mt-1 text-sm text-gray-500">
                    Diajukan pada {{ $pengajuan->created_at->format('d M Y, H:i') }}
                </p>
            </div>

            @if ($pengajuan->status === 'menunggu')
                <span class="rounded-full bg-yellow-100 px-4 py-2 text-sm font-semibold text-yellow-700">{{ __('Menunggu') }}</span>
            @elseif ($pengajuan->status === 'disetujui')
                <span class="rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700">{{ __('Disetujui') }}</span>
            @else
                <span class="rounded-full bg-red-100 px-4 py-2 text-sm font-semibold text-red-700">{{ __('Ditolak') }}</span>
            @endif
        </div>

        @if ($pengajuan->status !== 'menunggu')
            <div class="mt-4 border-t border-gray-100 pt-4 text-sm text-gray-600">
                {{ __('Diproses oleh:') }} {{ $pengajuan->admin->name ?? '-' }}
                <br>
                Tanggal diproses: {{ $pengajuan->diproses_pada?->format('d M Y, H:i') ?? '-' }}
            </div>
        @endif

        @if ($pengajuan->catatan_admin)
            <div class="mt-4 rounded-xl bg-red-50 p-4 text-sm text-red-700">
                <strong>{{ __('Catatan Admin:') }}</strong>
                <p class="mt-1">{{ $pengajuan->catatan_admin }}</p>
            </div>
        @endif
    </div>

    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="mb-5 text-lg font-bold text-gray-900">{{ __('Informasi Akun') }}</h2>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <p class="text-sm text-gray-500">{{ __('Nama Akun') }}</p>
                <p class="mt-1 font-semibold text-gray-900">
                    {{ $pengajuan->user->name ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">{{ __('Email') }}</p>
                <p class="mt-1 font-semibold text-gray-900">
                    {{ $pengajuan->user->email ?? '-' }}
                </p>
            </div>
        </div>
    </div>

    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="mb-5 text-lg font-bold text-gray-900">{{ __('Data Identitas Pemohon') }}</h2>

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <p class="text-sm text-gray-500">{{ __('Nama Lengkap Sesuai KTP') }}</p>
                <p class="mt-1 font-semibold text-gray-900">
                    {{ $pengajuan->nama_lengkap ?: '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">NIK</p>
                <p class="mt-1 font-semibold text-gray-900">
                    {{ $pengajuan->nik ?: '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">{{ __('Nomor WhatsApp') }}</p>
                <p class="mt-1 font-semibold text-gray-900">
                    {{ $pengajuan->no_whatsapp ?: '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">{{ __('Alamat Lengkap') }}</p>
                <p class="mt-1 whitespace-pre-line font-semibold text-gray-900">
                    {{ $pengajuan->alamat ?: '-' }}
                </p>
            </div>
        </div>

        <div class="mt-6 border-t border-gray-100 pt-5">
            <h3 class="mb-3 font-semibold text-gray-900">{{ __('Foto KTP') }}</h3>

            @if ($pengajuan->foto_ktp)
                <div class="overflow-hidden rounded-xl border border-gray-200 bg-gray-50 p-2">
                    <img
                        src="{{ route('admin.pengajuan-penggalang-dana.foto-ktp', $pengajuan) }}"
                        alt="Foto KTP pemohon"
                        class="mx-auto max-h-[500px] w-full object-contain"
                    >
                </div>
            @else
                <div class="rounded-xl bg-gray-50 p-5 text-sm text-gray-500">{{ __('Foto KTP belum tersedia.') }}</div>
            @endif
        </div>
    </div>

    <div class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="mb-3 text-lg font-bold text-gray-900">{{ __('Alasan Pengajuan') }}</h2>
        <p class="whitespace-pre-line leading-relaxed text-gray-700">
            {{ $pengajuan->alasan }}
        </p>
    </div>

    @if ($pengajuan->status === 'menunggu')
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="mb-2 text-lg font-bold text-gray-900">{{ __('Keputusan Admin') }}</h2>
            <p class="mb-5 text-sm text-gray-600">{{ __('Pastikan data identitas sudah diperiksa sebelum mengambil keputusan.') }}</p>

            <div class="grid gap-5 md:grid-cols-2">
                <form
                    action="{{ route('admin.pengajuan-penggalang-dana.setujui', $pengajuan) }}"
                    method="POST"
                    onsubmit="return confirm('Apakah kamu yakin ingin menyetujui pengajuan ini?')"
                >
                    @csrf
                    @method('PATCH')

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-green-600 px-5 py-3 font-semibold text-white transition hover:bg-green-700"
                    >{{ __('Setujui Pengajuan') }}</button>
                </form>

                <form
                    action="{{ route('admin.pengajuan-penggalang-dana.tolak', $pengajuan) }}"
                    method="POST"
                    onsubmit="return confirm('Apakah kamu yakin ingin menolak pengajuan ini?')"
                >
                    @csrf
                    @method('PATCH')

                    <label for="catatan_admin" class="mb-2 block text-sm font-semibold text-gray-700">{{ __('Alasan Penolakan') }}</label>

                    <textarea
                        name="catatan_admin"
                        id="catatan_admin"
                        rows="3"
                        required
                        minlength="5"
                        maxlength="1000"
                        placeholder="{{ __('Tuliskan alasan penolakan...') }}"
                        class="w-full rounded-xl border border-gray-300 p-3 text-sm focus:border-teal-600 focus:ring-teal-600"
                    >{{ old('catatan_admin') }}</textarea>

                    @error('catatan_admin')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <button
                        type="submit"
                        class="mt-3 w-full rounded-xl bg-red-600 px-5 py-3 font-semibold text-white transition hover:bg-red-700"
                    >{{ __('Tolak Pengajuan') }}</button>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection
