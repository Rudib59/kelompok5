@props(['label', 'nilai', 'ikon' => 'receipt', 'warna' => 'bg-teal-50 text-teal-700'])
<div class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
    <span class="grid h-12 w-12 shrink-0 place-items-center rounded-xl {{ $warna }}"><x-icon :name="$ikon" class="h-6 w-6" /></span>
    <div class="min-w-0">
        <p class="truncate text-sm font-semibold text-slate-500">{{ __($label) }}</p>
        <p class="truncate text-2xl font-extrabold">{{ $nilai }}</p>
    </div>
</div>
