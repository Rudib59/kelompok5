<x-guest-layout>
    <h1 class="text-2xl font-extrabold">{{ __('Masuk ke akun Anda') }}</h1>
    <p class="mt-1 text-sm text-slate-500">{{ __('Selamat datang kembali. Masukkan email dan kata sandi Anda.') }}</p>

    @if (session('status'))
        <p class="mt-4 rounded-xl bg-emerald-50 p-3 text-sm font-semibold text-emerald-700">{{ session('status') }}</p>
    @endif

    <form method="POST" action="{{ route('login') }}" novalidate class="mt-6 space-y-4">
        @csrf
        <x-field name="email" type="email" :label="__('Email')" autocomplete="username" autofocus placeholder="nama@gmail.com" />
        <x-field name="password" type="password" :label="__('Kata sandi')" autocomplete="current-password" />

        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2 text-slate-600">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-teal-700 focus:ring-teal-500"> {{ __('Ingat saya') }}
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="font-semibold text-teal-700 hover:underline">{{ __('Lupa kata sandi?') }}</a>
            @endif
        </div>

        <button class="w-full rounded-xl gk-btn-gold py-3 font-extrabold">{{ __('Masuk') }}</button>
    </form>

    <x-google-button />

    <p class="mt-6 text-center text-sm text-slate-500">{{ __('Belum punya akun?') }}
        <a href="{{ route('register') }}" class="font-bold text-teal-700 hover:underline">{{ __('Daftar') }}</a></p>
</x-guest-layout>
