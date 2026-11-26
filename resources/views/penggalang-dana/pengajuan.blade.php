@extends('layouts.galangkita')

@section('title', __('Pengajuan Penggalang Dana'))

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        <div class="mb-6">
            <span class="text-sm font-semibold text-teal-700">GalangKita</span>
            <h1 class="text-2xl font-bold text-gray-900 mt-2">{{ __('Jadilah Penggalang Dana') }}</h1>
            <p class="text-gray-600 mt-2">{{ __('Lengkapi data diri untuk mengajukan diri sebagai Penggalang Dana di GalangKita.') }}</p>
        </div>

        @if (session('success'))
            <div class="mb-5 rounded-lg bg-green-50 border border-green-200 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-5 rounded-lg bg-red-50 border border-red-200 p-4 text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if ($sudahMenjadiPenggalang)
            <div class="rounded-xl bg-green-50 border border-green-200 p-5">
                <h2 class="font-semibold text-green-800">{{ __('Kamu sudah menjadi Penggalang Dana') }}</h2>
                <p class="text-sm text-green-700 mt-2">{{ __('Sekarang kamu dapat mengajukan kampanye penggalangan dana.') }}</p>
            </div>

        @elseif ($pengajuanTerakhir && $pengajuanTerakhir->status === 'menunggu')
            <div class="rounded-xl bg-yellow-50 border border-yellow-200 p-5">
                <h2 class="font-semibold text-yellow-800">{{ __('Pengajuan sedang diperiksa') }}</h2>
                <p class="text-sm text-yellow-700 mt-2">{{ __('Data identitas dan pengajuanmu sudah diterima. Silakan tunggu pemeriksaan Admin.') }}</p>
                <p class="text-sm text-gray-600 mt-3">
                    Tanggal pengajuan:
                    {{ $pengajuanTerakhir->created_at->format('d M Y, H:i') }}
                </p>
            </div>

        @else
            @if ($pengajuanTerakhir && $pengajuanTerakhir->status === 'ditolak')
                <div class="rounded-xl bg-red-50 border border-red-200 p-5 mb-6">
                    <h2 class="font-semibold text-red-800">{{ __('Pengajuan sebelumnya ditolak') }}</h2>
                    <p class="text-sm text-red-700 mt-2">
                        Catatan Admin:
                        {{ $pengajuanTerakhir->catatan_admin ?: 'Tidak ada catatan.' }}
                    </p>
                    <p class="text-sm text-gray-600 mt-2">{{ __('Silakan perbaiki data dan ajukan kembali.') }}</p>
                </div>
            @endif

            <form action="{{ route('pengajuan-penggalang-dana.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-5">
                    <h2 class="text-lg font-bold text-gray-900 mb-1">{{ __('Informasi Identitas') }}</h2>
                    <p class="text-sm text-gray-500">{{ __('Isi data sesuai identitas resmi yang kamu miliki.') }}</p>
                </div>

                <div class="mb-5">
                    <label for="nama_lengkap" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Nama Lengkap Sesuai KTP') }}</label>
                    <input
                        type="text"
                        id="nama_lengkap"
                        name="nama_lengkap"
                        value="{{ old('nama_lengkap') }}"
                        required
                        minlength="3"
                        maxlength="150"
                        placeholder="{{ __('Masukkan nama lengkap sesuai KTP') }}"
                        class="w-full rounded-xl border border-gray-300 p-3 text-gray-700 focus:border-teal-600 focus:ring-teal-600"
                    >
                    @error('nama_lengkap')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="nik" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Nomor Induk Kependudukan (NIK)') }}</label>
                    <input
                        type="text"
                        id="nik"
                        name="nik"
                        value="{{ old('nik') }}"
                        required
                        inputmode="numeric"
                        pattern="[0-9]{16}"
                        minlength="16"
                        maxlength="16"
                        placeholder="{{ __('Masukkan 16 digit NIK') }}"
                        class="w-full rounded-xl border border-gray-300 p-3 text-gray-700 focus:border-teal-600 focus:ring-teal-600"
                    >
                    @error('nik')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-2">{{ __('NIK terdiri dari 16 angka.') }}</p>
                </div>

                <div class="mb-5">
                    <label for="foto_ktp" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Foto KTP') }}</label>
                    <input
                        type="file"
                        id="foto_ktp"
                        name="foto_ktp"
                        accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                        required
                        class="w-full rounded-xl border border-gray-300 p-3 text-sm text-gray-700 file:mr-4 file:rounded-lg file:border-0 file:bg-teal-50 file:px-4 file:py-2 file:font-semibold file:text-teal-700 hover:file:bg-teal-100"
                    >
                    @error('foto_ktp')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-2">{{ __('Format JPG, JPEG, atau PNG. Ukuran maksimal 3 MB.') }}</p>
                </div>

                <div class="mb-5">
                    <label for="no_whatsapp" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Nomor WhatsApp Aktif') }}</label>
                    <input
                        type="tel"
                        id="no_whatsapp"
                        name="no_whatsapp"
                        value="{{ old('no_whatsapp') }}"
                        required
                        inputmode="numeric"
                        pattern="[0-9]{10,15}"
                        maxlength="15"
                        placeholder="{{ __('Contoh: 081234567890') }}"
                        class="w-full rounded-xl border border-gray-300 p-3 text-gray-700 focus:border-teal-600 focus:ring-teal-600"
                    >
                    @error('no_whatsapp')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Alamat Lengkap') }}</label>
                    <textarea
                        id="alamat"
                        name="alamat"
                        rows="3"
                        required
                        minlength="10"
                        maxlength="1000"
                        placeholder="{{ __('Masukkan alamat sesuai domisili saat ini') }}"
                        class="w-full rounded-xl border border-gray-300 p-3 text-gray-700 focus:border-teal-600 focus:ring-teal-600"
                    >{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="border-t border-gray-200 my-7"></div>

                <div class="mb-5">
                    <h2 class="text-lg font-bold text-gray-900 mb-1">{{ __('Informasi Pengajuan') }}</h2>
                    <p class="text-sm text-gray-500">{{ __('Ceritakan alasan kamu ingin menjadi Penggalang Dana.') }}</p>
                </div>

                <div class="mb-5">
                    <label for="alasan" class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Alasan Ingin Menjadi Penggalang Dana') }}</label>
                    <textarea
                        id="alasan"
                        name="alasan"
                        rows="6"
                        required
                        minlength="30"
                        maxlength="2000"
                        placeholder="{{ __('Ceritakan alasan dan tujuan kamu ingin menjadi Penggalang Dana...') }}"
                        class="w-full rounded-xl border border-gray-300 p-4 text-gray-700 focus:border-teal-600 focus:ring-teal-600"
                    >{{ old('alasan') }}</textarea>
                    @error('alasan')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-2">{{ __('Minimal 30 karakter dan maksimal 2.000 karakter.') }}</p>
                </div>

                <div class="mb-6 rounded-xl border border-teal-100 bg-teal-50 p-4">
                    <p class="text-sm text-teal-800">{{ __('Data identitas dan foto KTP hanya digunakan untuk keperluan verifikasi oleh Admin GalangKita. Data tersebut tidak ditampilkan kepada pengunjung website.') }}</p>
                </div>

                <button
                    type="submit"
                    class="w-full rounded-xl bg-teal-700 px-5 py-3 font-semibold text-white hover:bg-teal-800 transition"
                >{{ __('Kirim Pengajuan') }}</button>
            </form>
        @endif
    </div>
</div>
@endsection
