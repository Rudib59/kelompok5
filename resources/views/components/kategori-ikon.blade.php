@props(['nama' => '', 'ukuran' => 'h-12 w-12'])
@php
    $peta = [
        'Pendidikan'   => ['book',   'bg-sky-100 text-sky-700'],
        'Kesehatan'    => ['health', 'bg-rose-100 text-rose-700'],
        'Bencana Alam' => ['drop',   'bg-amber-100 text-amber-700'],
        'Lingkungan'   => ['leaf',   'bg-emerald-100 text-emerald-700'],
        'Kemanusiaan'  => ['heart',  'bg-orange-100 text-orange-700'],
    ];
    [$ikon, $warna] = $peta[$nama] ?? ['heart', 'bg-slate-100 text-slate-700'];
@endphp
<span {{ $attributes->merge(['class' => "grid shrink-0 place-items-center rounded-2xl $ukuran $warna"]) }}>
    <x-icon :name="$ikon" class="h-1/2 w-1/2" />
</span>
