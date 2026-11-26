<x-guest-layout>
    <h1 class="text-2xl font-extrabold">{{ __('Lupa kata sandi') }}</h1>
    <p class="mt-1 text-sm text-slate-500">{{ __('Masukkan email Anda. Kami akan mengirim tautan untuk membuat kata sandi baru.') }}</p>

    @if (session('status'))
        <p class="mt-4 rounded-xl bg-emerald-50 p-3 text-sm font-semibold text-emerald-700">{{ session('status') }}</p>
    @endif

    <form method="POST" action="{{ route('password.email') }}" novalidate class="mt-6 space-y-4">
        @csrf
        <x-field name="email" type="email" :label="__('Email')" autofocus placeholder="nama@gmail.com" />
        <button class="w-full rounded-xl gk-btn-gold py-3 font-extrabold">{{ __('Kirim tautan reset') }}</button>
    </form>

    <p class="mt-6 text-center text-sm"><a href="{{ route('login') }}" class="font-bold text-teal-700 hover:underline">{{ __('Kembali ke halaman masuk') }}</a></p>
</x-guest-layout>
