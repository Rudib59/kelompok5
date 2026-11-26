@props(['gelap' => false])
@php $aktif = app()->getLocale(); @endphp
<div {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full p-0.5 text-xs font-bold ' . ($gelap ? 'bg-white/10 text-white' : 'bg-stone-100 text-stone-600')]) }} role="group" aria-label="{{ __('Bahasa') }}">
    @foreach (['id' => 'ID', 'en' => 'EN'] as $kode => $label)
        <a href="{{ route('bahasa', $kode) }}" hreflang="{{ $kode }}" @if($aktif === $kode) aria-current="true" @endif
           class="rounded-full px-2.5 py-1 {{ $aktif === $kode ? 'bg-teal-700 text-white shadow-sm' : 'opacity-70 hover:opacity-100' }}">{{ $label }}</a>
    @endforeach
</div>
