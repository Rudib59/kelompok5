<x-guest-layout>
    <h1 class="text-2xl font-extrabold">{{ __('Buat akun baru') }}</h1>
    <p class="mt-1 text-sm text-slate-500">{{ __('Daftar sebagai donatur untuk mulai berdonasi.') }}</p>

    <form method="POST" action="{{ route('register') }}" novalidate class="mt-6 space-y-4">
        @csrf
        <x-field name="name" :label="__('Nama lengkap')" autocomplete="name" autofocus />
        <x-field name="email" type="email" :label="__('Email')" autocomplete="username" placeholder="nama@gmail.com" />
        <x-field name="password" type="password" :label="__('Kata sandi')" autocomplete="new-password" :hint="__('Minimal 8 karakter.')" />
        <x-field name="password_confirmation" type="password" :label="__('Ulangi kata sandi')" autocomplete="new-password" />

        <button class="w-full rounded-xl gk-btn-gold py-3 font-extrabold">{{ __('Daftar') }}</button>
    </form>

    <x-google-button />

    <p class="mt-6 text-center text-sm text-slate-500">{{ __('Sudah punya akun?') }}
        <a href="{{ route('login') }}" class="font-bold text-teal-700 hover:underline">{{ __('Masuk') }}</a></p>
</x-guest-layout>
