@props(['name', 'label', 'type' => 'text', 'value' => null, 'hint' => null])
@php $galat = $errors->first($name); @endphp
<div x-data="{ lihat: false }">
    <label for="{{ $name }}" class="block text-sm font-semibold text-stone-700">{{ $label }}</label>
    <div class="relative mt-1">
        @if ($type === 'password')
            <input id="{{ $name }}" name="{{ $name }}" :type="lihat ? 'text' : 'password'"
                   {{ $attributes->merge(['class' => 'w-full rounded-xl border p-3 pr-16 text-sm focus:outline-none focus:ring-2 ' . ($galat ? 'border-red-400 bg-red-50/40 focus:border-red-500 focus:ring-red-200' : 'border-slate-200 focus:border-teal-500 focus:ring-teal-200')]) }}
                   @if($galat) aria-invalid="true" aria-describedby="{{ $name }}-galat" @endif>
            <button type="button" x-on:click="lihat = !lihat" class="absolute inset-y-0 right-3 my-auto h-8 rounded-lg px-2 text-xs font-bold text-teal-700 hover:bg-teal-50"
                    x-text="lihat ? @js(__('Sembunyikan')) : @js(__('Lihat'))"></button>
        @else
            <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ $value ?? old($name) }}"
                   {{ $attributes->merge(['class' => 'w-full rounded-xl border p-3 text-sm focus:outline-none focus:ring-2 ' . ($galat ? 'border-red-400 bg-red-50/40 focus:border-red-500 focus:ring-red-200' : 'border-slate-200 focus:border-teal-500 focus:ring-teal-200')]) }}
                   @if($galat) aria-invalid="true" aria-describedby="{{ $name }}-galat" @endif>
        @endif
    </div>
    @if ($galat)
        <p id="{{ $name }}-galat" role="alert" class="mt-1.5 flex items-start gap-1.5 text-xs font-semibold text-red-600">
            <x-icon name="alert" class="mt-px h-4 w-4 shrink-0" /><span>{{ $galat }}</span>
        </p>
    @elseif ($hint)
        <p class="mt-1.5 text-xs text-slate-500">{{ $hint }}</p>
    @endif
</div>
