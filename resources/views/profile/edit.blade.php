@extends('layouts.galangkita')
@section('title', 'Profil Saya')

@section('content')
@php
    $buka = session('buka');
    $fotoUrl = $user->foto ? \Illuminate\Support\Facades\Storage::disk('public')->url($user->foto) : null;
    $kartu = 'rounded-2xl border border-slate-200 bg-white p-6 shadow-sm';
    $btn = 'rounded-xl gk-btn-gold px-5 py-2.5 text-sm font-bold';
@endphp

<script>
    function fotoProfil(awal) {
        return {
            preview: awal, kamera: false, stream: null, galat: '',
            pilih(e) { const f = e.target.files[0]; if (f) { this.preview = URL.createObjectURL(f); this.$refs.hapus.checked = false; } },
            async bukaKamera() {
                this.galat = '';
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) { this.galat = @js(__('Kamera tidak didukung di browser ini.')); return; }
                try {
                    this.stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' }, audio: false });
                    this.kamera = true;
                    this.$nextTick(() => { this.$refs.video.srcObject = this.stream; });
                } catch (e) {
                    this.galat = @js(__('Kamera tidak dapat diakses. Izinkan akses kamera di browser, atau pilih foto dari galeri.'));
                }
            },
            ambil() {
                const v = this.$refs.video, sisi = Math.min(v.videoWidth, v.videoHeight);
                if (!sisi) return;
                const c = document.createElement('canvas'); c.width = c.height = 512;
                c.getContext('2d').drawImage(v, (v.videoWidth - sisi) / 2, (v.videoHeight - sisi) / 2, sisi, sisi, 0, 0, 512, 512);
                c.toBlob((b) => {
                    const file = new File([b], 'kamera.jpg', { type: 'image/jpeg' });
                    const dt = new DataTransfer(); dt.items.add(file);
                    this.$refs.input.files = dt.files;
                    this.preview = URL.createObjectURL(file);
                    this.$refs.hapus.checked = false;
                    this.tutup();
                }, 'image/jpeg', 0.9);
            },
            tutup() { if (this.stream) this.stream.getTracks().forEach((t) => t.stop()); this.stream = null; this.kamera = false; },
        };
    }
</script>

<h1 class="text-3xl font-extrabold">{{ __('Profil Saya') }}</h1>
<p class="mt-1 text-slate-600">{{ __('Kelola foto, nama, email, dan kata sandi Anda.') }}</p>

<div class="mt-6 grid gap-6 lg:grid-cols-3">

    {{-- Foto dan nama --}}
    <section class="{{ $kartu }} lg:col-span-3" x-data="fotoProfil(@js($fotoUrl))" x-on:keydown.escape.window="tutup()">
        <h2 class="text-lg font-extrabold">{{ __('Foto dan nama') }}</h2>
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" novalidate class="mt-5 flex flex-col gap-6 sm:flex-row">
            @csrf
            @method('PATCH')

            <div class="flex flex-col items-center gap-3 sm:w-48">
                <div class="grid h-32 w-32 place-items-center overflow-hidden rounded-full bg-gradient-to-br from-orange-300 to-orange-500 text-4xl font-extrabold text-white ring-4 ring-teal-50">
                    <template x-if="preview"><img :src="preview" alt="" class="h-full w-full object-cover"></template>
                    <template x-if="!preview"><span>{{ strtoupper(mb_substr($user->name, 0, 1)) }}</span></template>
                </div>
                <input x-ref="input" type="file" name="foto" accept="image/png,image/jpeg,image/webp" class="hidden" x-on:change="pilih($event)">
                <div class="flex flex-wrap justify-center gap-2">
                    <button type="button" x-on:click="$refs.input.click()" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-bold hover:bg-slate-50">
                        <x-icon name="image" class="h-4 w-4" /> {{ __('Galeri') }}
                    </button>
                    <button type="button" x-on:click="bukaKamera()" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-bold hover:bg-slate-50">
                        <x-icon name="camera" class="h-4 w-4" /> {{ __('Kamera') }}
                    </button>
                </div>
                @if ($user->foto)
                    <label class="flex items-center gap-2 text-xs text-slate-500">
                        <input x-ref="hapus" type="checkbox" name="hapus_foto" value="1" x-on:change="if ($event.target.checked) preview = null" class="rounded border-slate-300 text-red-600"> {{ __('Hapus foto') }}
                    </label>
                @else
                    <input x-ref="hapus" type="checkbox" class="hidden">
                @endif
                <p x-show="galat" x-cloak class="text-center text-xs font-semibold text-red-600" x-text="galat"></p>
                @error('foto')<p role="alert" class="text-center text-xs font-semibold text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex-1 space-y-4">
                <x-field name="name" :label="__('Nama lengkap')" :value="old('name', $user->name)" autocomplete="name" />
                <div>
                    <p class="text-sm font-semibold text-stone-700">{{ __('Role') }}</p>
                    <p class="mt-1 inline-block rounded-full bg-teal-50 px-3 py-1 text-xs font-bold capitalize text-teal-700">{{ __($user->getRoleNames()->first() ?? 'tanpa role') }}</p>
                </div>
                <button class="{{ $btn }}">{{ __('Simpan perubahan') }}</button>
            </div>
        </form>

        {{-- Kamera --}}
        <div x-show="kamera" x-cloak x-transition.opacity class="fixed inset-0 z-50 grid place-items-center bg-slate-900/70 p-4">
            <div class="relative w-full max-w-sm rounded-2xl bg-white p-5 shadow-2xl">
                <button type="button" x-on:click="tutup()" aria-label="{{ __('Tutup') }}" class="absolute right-3 top-3 grid h-9 w-9 place-items-center rounded-full text-slate-500 hover:bg-slate-100"><x-icon name="x" class="h-5 w-5" /></button>
                <h3 class="pr-10 font-extrabold">{{ __('Ambil foto') }}</h3>
                <video x-ref="video" autoplay playsinline muted class="mt-3 aspect-square w-full rounded-xl bg-slate-900 object-cover [transform:scaleX(-1)]"></video>
                <button type="button" x-on:click="ambil()" class="mt-4 w-full {{ $btn }}">{{ __('Ambil foto') }}</button>
            </div>
        </div>
    </section>

    {{-- Ganti email --}}
    <section class="{{ $kartu }} lg:col-span-1" x-data="{ kode: {{ $menungguEmail || $buka === 'email' ? 'true' : 'false' }} }">
        <h2 class="flex items-center gap-2 text-lg font-extrabold"><x-icon name="mail" class="h-5 w-5 text-teal-700" /> {{ __('Ganti email') }}</h2>
        <p class="mt-1 text-sm text-slate-500">{{ __('Email saat ini') }}: <span class="font-semibold text-slate-700">{{ $user->email }}</span></p>

        <form method="POST" action="{{ route('profile.email.kode') }}" novalidate class="mt-4 space-y-3">
            @csrf
            <x-field name="email_baru" type="email" :label="__('Email baru')" placeholder="nama@gmail.com" />
            <button class="{{ $btn }}">{{ __('Kirim kode ke email baru') }}</button>
        </form>

        <form x-show="kode" x-cloak method="POST" action="{{ route('profile.email.konfirmasi') }}" novalidate class="mt-5 space-y-3 border-t border-slate-100 pt-5">
            @csrf
            <x-field name="kode_email" :label="__('Kode verifikasi')" inputmode="numeric" maxlength="6" autocomplete="one-time-code" placeholder="123456" :hint="__('Masukkan 6 angka dari email.')" />
            <button class="rounded-xl bg-teal-700 px-5 py-2.5 text-sm font-bold text-white hover:bg-teal-800">{{ __('Konfirmasi email') }}</button>
        </form>
    </section>

    {{-- Ganti kata sandi --}}
    <section class="{{ $kartu }} lg:col-span-2" x-data="{ kode: {{ $menungguSandi || $buka === 'sandi' ? 'true' : 'false' }} }">
        <h2 class="flex items-center gap-2 text-lg font-extrabold"><x-icon name="lock" class="h-5 w-5 text-teal-700" /> {{ __('Ganti kata sandi') }}</h2>
        <p class="mt-1 text-sm text-slate-500">{{ __('Kode konfirmasi akan dikirim ke email Anda saat ini.') }}</p>

        <div class="mt-4 grid gap-6 md:grid-cols-2">
            <form method="POST" action="{{ route('profile.sandi.kode') }}" novalidate class="space-y-3">
                @csrf
                <x-field name="current_password" type="password" :label="__('Kata sandi saat ini')" autocomplete="current-password" />
                <x-field name="password" type="password" :label="__('Kata sandi baru')" autocomplete="new-password" :hint="__('Minimal 8 karakter.')" />
                <x-field name="password_confirmation" type="password" :label="__('Ulangi kata sandi baru')" autocomplete="new-password" />
                <button class="{{ $btn }}">{{ __('Kirim kode konfirmasi') }}</button>
            </form>

            <form x-show="kode" x-cloak method="POST" action="{{ route('profile.sandi.konfirmasi') }}" novalidate class="space-y-3 md:border-l md:border-slate-100 md:pl-6">
                @csrf
                <x-field name="kode_sandi" :label="__('Kode verifikasi')" inputmode="numeric" maxlength="6" autocomplete="one-time-code" placeholder="123456" :hint="__('Masukkan 6 angka dari email.')" />
                <button class="rounded-xl bg-teal-700 px-5 py-2.5 text-sm font-bold text-white hover:bg-teal-800">{{ __('Konfirmasi kata sandi') }}</button>
            </form>
        </div>
    </section>

    {{-- Hapus akun --}}
    <section class="{{ $kartu }} lg:col-span-3" x-data="{ buka: {{ $errors->has('password_hapus') ? 'true' : 'false' }} }">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-extrabold text-red-700">{{ __('Hapus akun') }}</h2>
                <p class="mt-1 text-sm text-slate-500">{{ __('Akun dan fotomu dihapus permanen. Tindakan ini tidak dapat dibatalkan.') }}</p>
            </div>
            <button type="button" x-on:click="buka = !buka" class="rounded-xl border border-red-200 px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-50">{{ __('Hapus akun') }}</button>
        </div>
        <form x-show="buka" x-cloak method="POST" action="{{ route('profile.destroy') }}" novalidate class="mt-4 max-w-sm space-y-3">
            @csrf
            @method('DELETE')
            <x-field name="password_hapus" type="password" :label="__('Kata sandi untuk konfirmasi')" autocomplete="current-password" />
            <button class="rounded-xl bg-red-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-red-700">{{ __('Ya, hapus akun saya') }}</button>
        </form>
    </section>
</div>
@endsection
