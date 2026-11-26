@props(['user', 'ukuran' => 'h-8 w-8 text-sm'])
@if ($user->foto)
    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($user->foto) }}" alt="{{ $user->name }}"
         {{ $attributes->merge(['class' => "shrink-0 rounded-full object-cover $ukuran"]) }}>
@else
    <span {{ $attributes->merge(['class' => "grid shrink-0 place-items-center rounded-full gk-btn-gold font-bold $ukuran"]) }}>{{ strtoupper(mb_substr($user->name, 0, 1)) }}</span>
@endif
