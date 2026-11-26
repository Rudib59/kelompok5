@extends('layouts.galangkita')
@section('title', __('Tentang'))
@section('flush', '1')

@section('content')
@php $foto = file_exists(public_path('images/about.jpg')) ? asset('images/about.jpg') : null; @endphp
<section class="gk-hero text-white" @if($foto) style="background-image: linear-gradient(150deg, rgba(4,47,46,.9), rgba(15,118,110,.75)), url('{{ $foto }}'); background-size: cover; background-position: center;" @endif>
    <div class="mx-auto max-w-4xl px-4 py-20 sm:px-6">
        <p class="gk-reveal text-sm font-semibold uppercase tracking-widest text-orange-200">{{ __('Tentang GalangKita') }}</p>
        <h1 class="gk-reveal mt-3 text-4xl leading-tight sm:text-5xl" style="--d: 80ms">{{ __('Membuat berbagi terasa mudah, jelas, dan bisa dipercaya.') }}</h1>
        <p class="gk-reveal mt-5 max-w-2xl text-lg text-stone-300" style="--d: 160ms">{{ __('GalangKita adalah portal penggalangan dana sosial yang mempertemukan orang yang ingin membantu dengan kebutuhan nyata di sekitar kita, mulai dari bencana alam hingga pendidikan dan kesehatan.') }}</p>
    </div>
</section>

<div class="mx-auto max-w-4xl space-y-16 px-4 py-14 sm:px-6">

    <section class="gk-reveal">
        <h2 class="text-2xl font-extrabold">{{ __('Mengapa GalangKita ada') }}</h2>
        <div class="mt-4 space-y-4 text-lg leading-relaxed text-slate-600">
            <p>{{ __('Saat bencana terjadi, banyak orang ingin membantu tetapi bingung ke mana harus menyalurkan dan apakah kabarnya benar. Di sisi lain, informasi resmi tentang kejadian sering tersebar di banyak laporan yang tidak mudah dibaca.') }}</p>
            <p>{{ __('GalangKita merangkum kejadian dari sumber resmi menjadi kampanye yang jelas: apa yang terjadi, di mana, siapa yang terdampak, dan dari mana informasinya. Anda berdonasi dengan konteks yang bisa diperiksa, bukan sekadar cerita.') }}</p>
        </div>
    </section>

    <section class="gk-reveal">
        <h2 class="text-2xl font-extrabold">{{ __('Bagaimana cara kerjanya') }}</h2>
        <ol class="mt-6 grid gap-4 sm:grid-cols-2">
            @foreach ([
                ['Pilih kampanye', 'Telusuri kampanye berdasarkan kategori atau kata kunci, lalu baca ringkasan kejadian dan sumbernya.'],
                ['Ajukan donasi', 'Tentukan nominal, mulai dari Rp 10.000. Donasi Anda tercatat dengan status menunggu verifikasi.'],
                ['Verifikasi petugas', 'Petugas memeriksa dan memverifikasi setiap donasi sebelum dihitung ke total dana kampanye.'],
                ['Pantau riwayat', 'Lihat riwayat dan bukti donasi Anda kapan saja dari akun Anda. Hanya Anda yang dapat melihatnya.'],
            ] as [$j, $d])
                <li class="flex gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full gk-btn-gold font-extrabold">{{ $loop->iteration }}</span>
                    <div><h3 class="font-extrabold">{{ __($j) }}</h3><p class="mt-1 text-sm text-slate-600">{{ __($d) }}</p></div>
                </li>
            @endforeach
        </ol>
    </section>

    <section class="gk-reveal">
        <h2 class="text-2xl font-extrabold">{{ __('Yang kami pegang') }}</h2>
        <div class="mt-6 grid gap-4 sm:grid-cols-3">
            @foreach ([
                ['shield', 'Dapat diperiksa', 'Setiap kampanye mencantumkan nama sumber, tanggal laporan, dan tautan.'],
                ['users', 'Privasi donatur', 'Nama donatur pada daftar publik disamarkan. Role pengguna ditetapkan sistem, bukan input pengguna.'],
                ['check', 'Diverifikasi manusia', 'Donasi baru dihitung setelah petugas memverifikasinya.'],
            ] as [$ik, $j, $d])
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <span class="grid h-10 w-10 place-items-center rounded-xl bg-teal-50 text-teal-700"><x-icon :name="$ik" class="h-5 w-5" /></span>
                    <h3 class="mt-3 font-extrabold">{{ __($j) }}</h3>
                    <p class="mt-1 text-sm text-slate-600">{{ __($d) }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="gk-reveal">
        <h2 class="text-2xl font-extrabold">{{ __('Siapa yang bekerja di dalamnya') }}</h2>
        <div class="mt-6 grid gap-4 sm:grid-cols-3">
            @foreach ([['Donatur', 'Berdonasi, memantau status, dan melihat riwayat donasi sendiri.'], ['Petugas', 'Memverifikasi donasi yang masuk dan mengelola kampanye.'], ['Admin', 'Mengelola kampanye, pengguna, role, dan laporan.']] as [$r, $d])
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h3 class="font-extrabold text-teal-700">{{ __($r) }}</h3>
                    <p class="mt-1 text-sm text-slate-600">{{ __($d) }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="gk-reveal rounded-2xl border border-amber-200 bg-amber-50 p-6">
        <h2 class="flex items-center gap-2 text-lg font-extrabold text-amber-900"><x-icon name="alert" class="h-5 w-5" /> {{ __('Transparansi data') }}</h2>
        <div class="mt-3 space-y-2 text-sm leading-relaxed text-amber-900/90">
            <p>{{ __('Fakta kejadian pada kampanye dirangkum dari laporan publik BNPB, Kemenkes, Kemendikdasmen, dan pemberitaan, lengkap dengan tanggal dan tautannya. Jika sumber tidak mencantumkan suatu angka, kami tidak menuliskannya.') }}</p>
            <p>{{ __('GalangKita saat ini belum menyalurkan dana ke lembaga atau penerima manfaat. Target dana pada kampanye adalah angka rencana awal, bukan angka dari sumber resmi, dan donasi yang dicatat di sini belum melibatkan transaksi uang sungguhan.') }}</p>
        </div>
    </section>

    <section class="gk-reveal" x-data="{ buka: null }">
        <h2 class="text-2xl font-extrabold">{{ __('Pertanyaan umum') }}</h2>
        <div class="mt-5 divide-y divide-slate-200 rounded-2xl border border-slate-200 bg-white">
            @foreach ([
                ['Apakah donasi saya langsung masuk ke total kampanye?', 'Belum. Donasi tercatat dulu dengan status menunggu verifikasi, lalu dihitung setelah petugas memverifikasinya.'],
                ['Berapa nominal minimal donasi?', 'Rp 10.000.'],
                ['Apakah nama saya terlihat publik?', 'Pada daftar donatur terbaru, nama hanya tampil huruf pertamanya dan sisanya disamarkan.'],
                ['Bagaimana jika saya lupa kata sandi?', 'Gunakan "Lupa kata sandi" di halaman masuk. Kami mengirim tautan reset ke email Anda.'],
                ['Bagaimana mengganti email atau kata sandi?', 'Dari halaman profil. Perubahan dikonfirmasi dengan kode 6 angka yang dikirim ke email.'],
            ] as $i => [$q, $a])
                <div>
                    <button type="button" x-on:click="buka = buka === {{ $i }} ? null : {{ $i }}" class="flex w-full items-center justify-between gap-4 p-5 text-left font-bold">
                        <span>{{ __($q) }}</span>
                        <span class="text-teal-700 transition" :class="buka === {{ $i }} ? 'rotate-45' : ''">+</span>
                    </button>
                    <p x-show="buka === {{ $i }}" x-cloak class="px-5 pb-5 text-sm text-slate-600">{{ __($a) }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="gk-reveal rounded-2xl bg-teal-900 p-8 text-white">
        <h2 class="text-2xl font-extrabold">{{ __('Ada pertanyaan atau koreksi data?') }}</h2>
        <p class="mt-2 text-teal-100">{{ __('Jika Anda menemukan informasi yang keliru pada kampanye, beri tahu kami agar segera diperbaiki.') }}</p>
        <a href="mailto:{{ config('galangkita.kontak_email') }}" class="mt-5 inline-flex items-center gap-2 rounded-xl gk-btn-gold px-6 py-3 font-bold"><x-icon name="mail" class="h-5 w-5" /> {{ config('galangkita.kontak_email') }}</a>
    </section>
</div>
@endsection
