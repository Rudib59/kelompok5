<x-guest-layout>
    <h1 class="text-2xl font-extrabold">{{ __('Buat kata sandi baru') }}</h1>

    <form method="POST" action="{{ route('password.store') }}" novalidate class="mt-6 space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <x-field name="email" type="email" :label="__('Email')" :value="old('email', $request->email)" autocomplete="username" />
        <x-field name="password" type="password" :label="__('Kata sandi baru')" autocomplete="new-password" :hint="__('Minimal 8 karakter.')" />
        <x-field name="password_confirmation" type="password" :label="__('Ulangi kata sandi')" autocomplete="new-password" />
        <button class="w-full rounded-xl gk-btn-gold py-3 font-extrabold">{{ __('Simpan kata sandi') }}</button>
    </form>
</x-guest-layout>
