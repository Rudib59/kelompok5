<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.gk-base')
    <style>
        .gk-brand { background: radial-gradient(600px 360px at 100% 0%, rgba(255,138,101,.45) 0%, transparent 60%),
                                linear-gradient(160deg, #042f2e 0%, #0f766e 100%); }
        @if (file_exists(public_path('images/hero.jpg')))
        .gk-brand { background: linear-gradient(160deg, rgba(4,47,46,.86) 0%, rgba(15,118,110,.72) 100%), url('{{ asset('images/hero.jpg') }}') center / cover; }
        @endif
    </style>
</head>
<body class="min-h-screen bg-[#fbf7f0] text-stone-800 antialiased">
<div class="grid min-h-screen lg:grid-cols-2">
    <aside class="gk-brand hidden flex-col justify-between p-12 text-white lg:flex">
        <a href="{{ route('beranda') }}" class="flex items-center gap-2 text-xl font-extrabold">
            <span class="grid h-10 w-10 place-items-center rounded-xl gk-btn-gold"><x-icon name="heart" class="h-5 w-5" /></span>
            <span class="gk-serif text-white">GalangKita</span>
        </a>
        <div class="gk-reveal">
            <h2 class="text-5xl font-bold leading-tight">{{ __('Kebaikan kecil,') }}<br><span class="text-orange-300">{{ __('dampak besar.') }}</span></h2>
            <p class="mt-4 max-w-md text-teal-100">{{ __('Bantu pendidikan, kesehatan, dan korban bencana di seluruh Indonesia lewat kampanye yang bersumber dari laporan resmi.') }}</p>
        </div>
        <p class="text-sm text-teal-200">{{ __('Setiap donasi diverifikasi petugas sebelum tercatat.') }}</p>
    </aside>

    <section class="flex flex-col p-6 sm:p-10">
        <div class="flex items-center justify-between">
            <a href="{{ route('beranda') }}" class="flex items-center gap-2 text-lg font-extrabold text-teal-800 lg:invisible">
                <span class="grid h-9 w-9 place-items-center rounded-xl gk-btn-gold"><x-icon name="heart" class="h-4 w-4" /></span> GalangKita
            </a>
            <x-lang-switch />
        </div>
        <div class="flex flex-1 items-center justify-center py-8">
            <div class="w-full max-w-md">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    {{ $slot }}
                </div>
                <p class="mt-6 text-center text-sm text-slate-500"><a href="{{ route('beranda') }}" class="font-semibold text-teal-700 hover:underline">&larr; {{ __('Kembali ke beranda') }}</a></p>
            </div>
        </div>
    </section>
</div>
</body>
</html>
