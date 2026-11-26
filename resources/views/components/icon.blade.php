@props(['name', 'class' => 'h-5 w-5'])
@php
    $ikon = [
        'users'     => '<circle cx="9" cy="8" r="3.2"/><path d="M3 20c0-3.300 2.700-6 6-6s6 2.700 6 6"/><circle cx="17.500" cy="9" r="2.500"/><path d="M17 14.200c2.400.3 4 2.300 4 4.800"/>',
        'megaphone' => '<path d="M4 10v4h3l7 4V6L7 10H4z"/><path d="M17.500 9.500c1.300 1.400 1.300 3.600 0 5"/>',
        'wallet'    => '<rect x="3" y="6" width="18" height="13" rx="2.500"/><path d="M3 10h18"/><circle cx="16.500" cy="14.500" r="1.200"/>',
        'clock'     => '<circle cx="12" cy="12" r="8.500"/><path d="M12 7.500V12l3 2"/>',
        'check'     => '<circle cx="12" cy="12" r="8.500"/><path d="m8.500 12.300 2.300 2.400 4.700-5"/>',
        'receipt'   => '<path d="M6 3h12v18l-3-2-3 2-3-2-3 2V3z"/><path d="M9 8h6M9 12h6"/>',
        'heart'     => '<path d="M12 20s-7-4.400-9-9c-1.400-3.200.2-6 3.200-6 1.900 0 3.200 1 3.800 2.200.6-1.200 1.900-2.200 3.800-2.200 3 0 4.600 2.800 3.200 6-2 4.600-9 9-9 9z"/>',
        'search'    => '<circle cx="11" cy="11" r="7"/><path d="m20 20-3.500-3.500"/>',
        'drop'      => '<path d="M12 3.500s6 6.200 6 10.500a6 6 0 0 1-12 0c0-4.300 6-10.500 6-10.500z"/>',
        'leaf'      => '<path d="M5 19c0-8 5-13 14-14 0 9-5 14-13 14"/><path d="M5 19c3-4 6-6.500 9-8"/>',
        'health'    => '<rect x="4" y="4" width="16" height="16" rx="3.500"/><path d="M12 8v8M8 12h8"/>',
        'book'      => '<path d="M4 5.500C6.500 4.500 9.500 4.500 12 6c2.500-1.500 5.500-1.500 8-.5v13c-2.500-1-5.500-1-8 .5-2.500-1.500-5.500-1.500-8-.5z"/><path d="M12 6v13.500"/>',
        'shield'    => '<path d="M12 3l7 3v5c0 4.500-3 8-7 10-4-2-7-5.500-7-10V6l7-3z"/><path d="m9 12 2 2 4-4"/>',
        'globe'     => '<circle cx="12" cy="12" r="8.500"/><path d="M3.500 12h17M12 3.500c2.500 2.500 3.500 5.500 3.500 8.500S14.500 18 12 20.500C9.500 18 8.500 15 8.500 12S9.500 6 12 3.500z"/>',
        'camera'    => '<path d="M4 8h3l1.500-2h7L17 8h3v11H4V8z"/><circle cx="12" cy="13" r="3.500"/>',
        'image'     => '<rect x="3.500" y="5" width="17" height="14" rx="2"/><circle cx="9" cy="10" r="1.500"/><path d="m4 18 5-5 4 4 3-3 4 4"/>',
        'x'         => '<path d="M6 6l12 12M18 6 6 18"/>',
        'mail'      => '<rect x="3" y="5.500" width="18" height="13" rx="2"/><path d="m4 7.500 8 6 8-6"/>',
        'lock'      => '<rect x="5" y="10.500" width="14" height="9.500" rx="2"/><path d="M8 10.500V8a4 4 0 0 1 8 0v2.500"/>',
        'trash'     => '<path d="M6 7h12M9 7V4h6v3m-8 0 1 13h8l1-13"/>',
        'alert'     => '<path d="M12 4 2.500 20h19L12 4z"/><path d="M12 10v4.500M12 17.500v.1"/>',
        'arrow'     => '<path d="M5 12h14m-5-5 5 5-5 5"/>',
        'menu'      => '<path d="M4 7h16M4 12h16M4 17h16"/>',
        'user'      => '<circle cx="12" cy="8" r="3.500"/><path d="M5 20c0-3.900 3.100-7 7-7s7 3.100 7 7"/>',
        'link'      => '<path d="M10 14a4 4 0 0 0 5.700 0l3-3a4 4 0 0 0-5.700-5.700l-1 1"/><path d="M14 10a4 4 0 0 0-5.700 0l-3 3a4 4 0 0 0 5.700 5.700l1-1"/>',
        'grid'      => '<rect x="4" y="4" width="6.500" height="6.500" rx="1.500"/><rect x="13.500" y="4" width="6.500" height="6.500" rx="1.500"/><rect x="4" y="13.500" width="6.500" height="6.500" rx="1.500"/><rect x="13.500" y="13.500" width="6.500" height="6.500" rx="1.500"/>',
        'clipboard' => '<rect x="5" y="4.500" width="14" height="16" rx="2"/><path d="M9 4.500V3h6v1.500M8.500 10h7M8.500 14h7"/>',
        'clipcheck' => '<rect x="5" y="4.500" width="14" height="16" rx="2"/><path d="M9 4.500V3h6v1.500M8.800 13.200l2.200 2.200 4.200-4.400"/>',
        'flag'      => '<path d="M6 21V4"/><path d="M6 5h11l-2 3.500 2 3.500H6"/>',
        'chart'     => '<path d="M4 20h16M7 16v-5M12 16V7M17 16v-8"/>',
        'plus'      => '<circle cx="12" cy="12" r="8.500"/><path d="M12 8.500v7M8.500 12h7"/>',
        'logout'    => '<path d="M10 4H6.500A1.500 1.500 0 0 0 5 5.500v13A1.500 1.500 0 0 0 6.500 20H10"/><path d="m15 8 4 4-4 4M19 12H9.500"/>',
    ];
    $dalam = $ikon[$name] ?? $ikon['heart'];
    $isi = $name === 'heart' ? 'fill="currentColor" stroke="none"' : 'fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"';
@endphp
<svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 24 24" {!! $isi !!} aria-hidden="true">{!! $dalam !!}</svg>
