@props(['title' => 'GalangKita', 'flush' => false])
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __($title) }} | {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('partials.gk-base')
    <style>
        .gk-hero {
            background: radial-gradient(700px 380px at 90% -10%, rgba(255,138,101,.45) 0%, transparent 60%),
                        radial-gradient(600px 320px at 0% 110%, rgba(45,212,191,.28) 0%, transparent 60%),
                        linear-gradient(150deg, #042f2e 0%, #0f5d57 60%, #0f766e 100%);
        }

        /* Sidebar: transisi halaman tidak ikut bergeser, item aktif "menyatu" dengan konten */
        .gk-sidebar { view-transition-name: gk-sidebar; scrollbar-width: none; }
        .gk-sidebar::-webkit-scrollbar { display: none; }
        .gk-topbar { view-transition-name: gk-topbar; }
        .gk-side-active { background: #fbf7f0; color: #115e59; }
        .gk-side-active::before, .gk-side-active::after { content: ''; position: absolute; right: 0; width: 1.25rem; height: 1.25rem; pointer-events: none; }
        .gk-side-active::before { top: -1.25rem; border-bottom-right-radius: 1.25rem; box-shadow: .5rem .5rem 0 .5rem #fbf7f0; }
        .gk-side-active::after { bottom: -1.25rem; border-top-right-radius: 1.25rem; box-shadow: .5rem -.5rem 0 .5rem #fbf7f0; }
    </style>
</head>
<body class="flex min-h-screen flex-col bg-[#fbf7f0] text-stone-800 antialiased">

@php
    // [label, rute, izin, pola rute aktif, ikon]
    $menu = [
        ['Kampanye', 'kampanye.index', 'lihat-daftar-kampanye', 'kampanye.*', 'megaphone'],
        ['Dashboard', 'admin.dashboard', 'akses-dashboard-admin', 'admin.dashboard', 'grid'],
        ['Dashboard', 'petugas.dashboard', 'akses-dashboard-petugas', 'petugas.dashboard', 'grid'],
        ['Dashboard Penggalang', 'penggalang.dashboard', 'akses-dashboard-penggalang-dana', 'penggalang.dashboard', 'grid'],
        ['Kelola Kampanye', 'admin.kampanye.index', 'kelola-kampanye', 'admin.kampanye.*', 'clipboard'],
        ['Kampanye Saya', 'penggalang.kampanye.index', 'kelola-kampanye-sendiri', 'penggalang.kampanye.*', 'flag'],
        ['Donasi', 'donasi.index', 'kelola-donasi', 'donasi.index', 'wallet'],
        ['Laporan', 'laporan.index', 'lihat-laporan', 'laporan.*', 'chart'],
        ['Pengguna', 'admin.pengguna.index', 'kelola-pengguna', 'admin.pengguna.*', 'users'],
        ['Pengajuan Penggalang Dana', 'admin.pengajuan-penggalang-dana.index', 'kelola-pengajuan-penggalang-dana', 'admin.pengajuan-penggalang-dana.*', 'clipcheck'],
        ['Ajukan Jadi Penggalang', 'pengajuan-penggalang-dana.create', 'mengajukan-permohonan-penggalang-dana', 'pengajuan-penggalang-dana.*', 'plus'],
    ];
@endphp

@auth
@php
    $u = auth()->user();
    $itemMenu = collect($menu)->filter(fn ($m) => $u->can($m[2]) && ($m[1] !== 'pengajuan-penggalang-dana.create' || ! $u->hasRole('penggalang_dana')));
@endphp
<div class="flex min-h-screen w-full" x-data="{ drawer: false }" x-on:keydown.escape.window="drawer = false">

    {{-- Latar gelap saat menu seluler terbuka --}}
    <div x-show="drawer" x-cloak x-transition.opacity x-on:click="drawer = false" class="fixed inset-0 z-40 bg-stone-900/50 lg:hidden"></div>

    {{-- SIDEBAR: rel ikon (kiri) + panel label (kanan) --}}
    <aside class="gk-sidebar fixed inset-y-0 left-0 z-50 flex overflow-y-auto transition-transform duration-300 lg:sticky lg:top-0 lg:z-30 lg:h-screen lg:translate-x-0"
           :class="drawer ? '' : '-translate-x-full'" aria-label="{{ __('Menu utama') }}">

        {{-- Rel ikon --}}
        <div class="flex min-h-full w-[72px] shrink-0 flex-col items-center bg-teal-600 pt-[112px]">
            <nav class="flex flex-col items-center gap-1 pb-6">
                @foreach ($itemMenu as [$label, $rute, $izin, $pola, $ikon])
                    @php $aktif = request()->routeIs($pola); @endphp
                    <a href="{{ route($rute) }}" title="{{ __($label) }}" aria-label="{{ __($label) }}" @if($aktif) aria-current="page" @endif
                       class="relative grid h-11 w-11 place-items-center rounded-xl transition {{ $aktif ? 'bg-white/20 text-white before:absolute before:-left-[14px] before:top-2 before:h-7 before:w-1 before:rounded-r-full before:bg-[#fbf7f0]' : 'text-teal-50/75 hover:bg-white/15 hover:text-white' }}">
                        <x-icon :name="$ikon" class="h-5 w-5" />
                    </a>
                @endforeach
            </nav>
            <div class="mt-auto flex h-[76px] items-center justify-center">
                <button type="submit" form="gk-logout" title="{{ __('Keluar') }}" aria-label="{{ __('Keluar') }}"
                        class="grid h-11 w-11 place-items-center rounded-xl text-teal-50/75 hover:bg-white/15 hover:text-white">
                    <x-icon name="logout" class="h-5 w-5" />
                </button>
            </div>
        </div>

        {{-- Panel label --}}
        <div class="flex min-h-full w-60 shrink-0 flex-col bg-teal-800 text-teal-50">
            <div class="flex h-[72px] items-center gap-2 rounded-br-[2rem] bg-teal-700 pl-5 pr-3">
                <a href="{{ route('beranda') }}" class="flex flex-1 items-center gap-2 text-lg font-extrabold tracking-tight text-white">
                    <span class="grid h-9 w-9 place-items-center rounded-xl gk-btn-gold">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21s-7.5-4.6-9.6-9.2C.9 8.4 2.6 5 6 5c2 0 3.3 1 4 2.2C10.700 6 12 5 14 5c3.400 0 5.100 3.400 3.600 6.800C19.500 16.400 12 21 12 21z"/></svg>
                    </span>
                    GalangKita
                </a>
                <button type="button" x-on:click="drawer = false" class="grid h-9 w-9 place-items-center rounded-lg text-teal-100 hover:bg-white/10 lg:hidden" aria-label="{{ __('Tutup menu') }}">
                    <x-icon name="x" class="h-5 w-5" />
                </button>
            </div>

            <nav class="mt-4 flex flex-col gap-1 py-6 pl-4">
                @foreach ($itemMenu as [$label, $rute, $izin, $pola, $ikon])
                    @php $aktif = request()->routeIs($pola); @endphp
                    <a href="{{ route($rute) }}" @if($aktif) aria-current="page" @endif
                       class="relative flex h-11 items-center rounded-l-2xl pl-4 pr-3 text-sm font-semibold transition {{ $aktif ? 'gk-side-active' : 'text-teal-100/90 hover:bg-white/10 hover:text-white' }}">
                        <span class="truncate">{{ __($label) }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="mt-auto flex h-[76px] items-center rounded-tr-[2rem] bg-teal-700/60 px-4">
                <form id="gk-logout" method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="flex h-11 w-full items-center gap-3 rounded-xl px-3 text-sm font-semibold text-teal-50 hover:bg-white/10">
                        <x-icon name="logout" class="h-5 w-5" />
                        {{ __('Keluar') }}
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div class="flex min-w-0 flex-1 flex-col">

        {{-- TOP BAR: cari, bahasa, akun --}}
        <header class="gk-topbar sticky top-0 z-20 flex h-16 items-center gap-3 border-b border-teal-900/5 bg-[#fbf7f0]/90 px-4 backdrop-blur sm:px-6">
            <button type="button" x-on:click="drawer = true" class="grid h-10 w-10 shrink-0 place-items-center rounded-lg text-stone-700 hover:bg-white lg:hidden" aria-label="{{ __('Menu utama') }}">
                <x-icon name="menu" class="h-6 w-6" />
            </button>

            @can('lihat-daftar-kampanye')
                <form action="{{ route('kampanye.index') }}" method="GET" role="search" class="relative min-w-0 max-w-sm flex-1">
                    <x-icon name="search" class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-stone-400" />
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="{{ __('Cari kampanye...') }}"
                           class="w-full rounded-full border border-stone-200 bg-white py-2 pl-10 pr-4 text-sm shadow-sm placeholder:text-stone-400 focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-200">
                </form>
            @endcan

            <div class="ml-auto flex items-center gap-2">
                <x-lang-switch />
                <div class="relative" x-data="{ open: false }" x-on:click.outside="open = false" x-on:keydown.escape.window="open = false">
                    <button type="button" x-on:click="open = !open" class="flex items-center gap-2 rounded-full py-1 pl-1 pr-2 hover:bg-white">
                        <x-avatar :user="$u" />
                        <span class="hidden max-w-[9rem] truncate text-sm font-semibold sm:block">{{ $u->name }}</span>
                        <svg class="h-4 w-4 text-stone-500" viewBox="0 0 20 20" fill="currentColor"><path d="M5.2 7.5 10 12.300l4.800-4.800 1.200 1.200-6 6-6-6z"/></svg>
                    </button>
                    <div x-show="open" x-cloak x-transition class="absolute right-0 mt-2 w-60 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg">
                        <div class="border-b border-slate-100 px-4 py-3">
                            <p class="truncate text-sm font-bold">{{ $u->name }}</p>
                            <p class="truncate text-xs text-slate-500">{{ $u->email }}</p>
                            <span class="mt-2 inline-block rounded-full bg-teal-50 px-2 py-0.5 text-xs font-bold capitalize text-teal-700">{{ __($u->getRoleNames()->first() ?? 'tanpa role') }}</span>
                        </div>
                        @can('lihat-riwayat-donasi-sendiri')
                            <a href="{{ route('donasi.riwayat') }}" class="block px-4 py-2.5 text-sm hover:bg-slate-50">{{ __('Riwayat donasi saya') }}</a>
                        @endcan
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm hover:bg-slate-50">{{ __('Profil saya') }}</a>
                        <button type="submit" form="gk-logout" class="w-full border-t border-slate-100 px-4 py-2.5 text-left text-sm font-semibold text-red-600 hover:bg-red-50">{{ __('Keluar') }}</button>
                    </div>
                </div>
            </div>
        </header>
@else
{{-- Pengunjung (belum login): tetap memakai navbar atas --}}
<header class="gk-header sticky top-0 z-40 border-b border-teal-100 bg-white/90 text-stone-800 backdrop-blur" x-data="{ menu: false }">
    <div class="mx-auto flex h-16 max-w-6xl items-center gap-4 px-4 sm:px-6">
        <a href="{{ route('beranda') }}" class="gk-serif flex items-center gap-2 text-xl tracking-tight text-teal-800">
            <span class="grid h-9 w-9 place-items-center rounded-xl gk-btn-gold">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21s-7.5-4.6-9.6-9.2C.9 8.4 2.6 5 6 5c2 0 3.3 1 4 2.2C10.700 6 12 5 14 5c3.400 0 5.100 3.400 3.600 6.800C19.500 16.400 12 21 12 21z"/></svg>
            </span>
            GalangKita
        </a>

        <nav class="ml-4 hidden items-center gap-1 md:flex">
            <a href="{{ route('beranda') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-stone-600 hover:bg-teal-50 hover:text-teal-800">{{ __('Beranda') }}</a>
            <a href="{{ route('kampanye.index') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-stone-600 hover:bg-teal-50 hover:text-teal-800">{{ __('Kampanye') }}</a>
            <a href="{{ route('tentang') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-stone-600 hover:bg-teal-50 hover:text-teal-800">{{ __('Tentang') }}</a>
        </nav>

        <div class="ml-auto flex items-center gap-2">
            <x-lang-switch />
            <a href="{{ route('login') }}" class="hidden rounded-lg px-3 py-2 text-sm font-semibold text-stone-700 hover:bg-teal-50 sm:block">{{ __('Masuk') }}</a>
            <a href="{{ route('register') }}" class="rounded-lg gk-btn-gold px-4 py-2 text-sm font-bold shadow-sm">{{ __('Daftar') }}</a>
            <button type="button" class="grid h-10 w-10 place-items-center rounded-lg text-stone-700 hover:bg-teal-50 md:hidden" x-on:click="menu = !menu" aria-label="{{ __('Menu utama') }}">
                <x-icon name="menu" class="h-6 w-6" />
            </button>
        </div>
    </div>

    <div x-show="menu" x-cloak x-transition class="border-t border-teal-100 bg-white px-4 py-3 md:hidden">
        <div class="flex flex-col gap-1">
            <a href="{{ route('beranda') }}" class="rounded-lg px-3 py-2.5 text-sm font-semibold text-stone-700">{{ __('Beranda') }}</a>
            <a href="{{ route('kampanye.index') }}" class="rounded-lg px-3 py-2.5 text-sm font-semibold text-stone-700">{{ __('Kampanye') }}</a>
            <a href="{{ route('tentang') }}" class="rounded-lg px-3 py-2.5 text-sm font-semibold text-stone-700">{{ __('Tentang') }}</a>
            <a href="{{ route('login') }}" class="rounded-lg px-3 py-2.5 text-sm font-semibold text-stone-700">{{ __('Masuk') }}</a>
        </div>
    </div>
</header>
@endauth

<main class="flex-1">
    @if ($flush)
        {{ $slot }}
    @else
        <div class="mx-auto w-full max-w-6xl px-4 py-8 sm:px-6">{{ $slot }}</div>
    @endif
</main>

<footer class="mt-12 bg-teal-950 text-teal-100/70">
    <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-3 px-4 py-8 text-sm sm:flex-row sm:px-6">
        <p><span class="gk-serif text-lg text-orange-300">GalangKita</span> &middot; {{ __('Portal penggalangan dana sosial') }}</p>
        <p>&copy; {{ date('Y') }} GalangKita &middot; <a href="{{ route('tentang') }}" class="hover:text-white hover:underline">{{ __('Tentang') }}</a></p>
    </div>
</footer>

@auth
    </div>{{-- /kolom konten --}}
</div>{{-- /layout sidebar --}}
@endauth

<div x-data="{ items: [], add(d) { const id = Date.now() + Math.random(); this.items.push({ id, m: d.m, t: d.t || 'success' }); setTimeout(() => this.items = this.items.filter(i => i.id !== id), 4500); } }"
     x-on:toast.window="add($event.detail)"
     x-init="@if (session('success')) add({ m: @js(session('success')), t: 'success' }); @endif @if (session('error')) add({ m: @js(session('error')), t: 'error' }); @endif @foreach ($errors->all() as $e) add({ m: @js($e), t: 'error' }); @endforeach"
     class="pointer-events-none fixed inset-x-0 bottom-4 z-50 flex flex-col items-center gap-2 px-4 sm:items-end sm:pr-6">
    <template x-for="i in items" :key="i.id">
        <div x-transition class="pointer-events-auto flex w-full max-w-sm items-start gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-white shadow-lg"
             :class="i.t === 'error' ? 'bg-red-600' : 'bg-teal-700'">
            <span class="grid h-5 w-5 shrink-0 place-items-center rounded-full bg-white/25 text-xs font-extrabold" x-text="i.t === 'error' ? '!' : 'OK'"></span>
            <span x-text="i.m" class="flex-1"></span>
            <button type="button" x-on:click="items = items.filter(x => x.id !== i.id)" class="opacity-70 hover:opacity-100">&times;</button>
        </div>
    </template>
</div>

<div x-data="{ open: false, action: '', nama: '', cb: null,
               buka(d) { this.open = true; this.action = d.action || ''; this.nama = d.nama || ''; this.cb = d.cb || null; },
               ya() { if (this.cb) { this.cb(); this.open = false; } else { this.$refs.f.submit(); } } }"
     x-on:konfirmasi.window="buka($event.detail)" x-on:keydown.escape.window="open = false"
     x-show="open" x-cloak class="fixed inset-0 z-50 grid place-items-center bg-slate-900/50 p-4" x-transition.opacity>
    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl" x-on:click.outside="open = false">
        <div class="mb-4 grid h-12 w-12 place-items-center rounded-full bg-red-100 text-red-600">
            <x-icon name="trash" class="h-6 w-6" />
        </div>
        <h3 class="text-lg font-extrabold">{{ __('Hapus kampanye ini?') }}</h3>
        <p class="mt-1 text-sm text-slate-600">&ldquo;<span x-text="nama" class="font-semibold"></span>&rdquo; {{ __('akan dihapus permanen beserta donasi di dalamnya.') }}</p>
        <form x-ref="f" method="POST" :action="action" class="mt-6 flex justify-end gap-2">
            @csrf
            @method('DELETE')
            <button type="button" x-on:click="open = false" class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold hover:bg-slate-50">{{ __('Batal') }}</button>
            <button type="button" x-on:click="ya()" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-bold text-white hover:bg-red-700">{{ __('Ya, hapus') }}</button>
        </form>
    </div>
</div>

<script>
    window.toast = (m, t = 'success') => window.dispatchEvent(new CustomEvent('toast', { detail: { m, t } }));
</script>
</body>
</html>
