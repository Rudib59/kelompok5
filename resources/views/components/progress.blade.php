@props(['terkumpul' => 0, 'target' => 1])
@php $persen = $target > 0 ? min(100, round($terkumpul / $target * 100)) : 0; @endphp
<div {{ $attributes }}>
    <div class="h-2.5 overflow-hidden rounded-full bg-slate-100">
        <div class="gk-grow h-full rounded-full bg-gradient-to-r from-teal-500 to-emerald-400" style="width: {{ $persen }}%"></div>
    </div>
    <div class="mt-2 flex items-end justify-between text-sm">
        <p><span class="font-extrabold text-slate-900">Rp {{ number_format($terkumpul, 0, ',', '.') }}</span>
           <span class="text-slate-500">{{ __('terkumpul') }}</span></p>
        <p class="font-bold text-teal-700">{{ $persen }}%</p>
    </div>
</div>
