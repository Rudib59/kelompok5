@props(['terverifikasi' => false])
<span class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-xs font-bold {{ $terverifikasi ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
    <span class="h-1.5 w-1.5 rounded-full {{ $terverifikasi ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
    {{ $terverifikasi ? __('Terverifikasi') : __('Menunggu verifikasi') }}
</span>
