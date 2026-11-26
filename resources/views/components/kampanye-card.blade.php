@props(['kampanye'])
@php $kat = $kampanye->kategori; @endphp
<a href="{{ route('kampanye.show', $kampanye->id) }}" class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
    @if ($kampanye->gambar_url)
        <img src="{{ $kampanye->gambar_url }}" alt="" loading="lazy" class="h-40 w-full object-cover">
    @else
        <div class="relative grid h-28 place-items-center overflow-hidden bg-gradient-to-br from-teal-700 to-teal-900 text-white/90">
            <x-icon :name="match($kat->nama ?? '') { 'Pendidikan' => 'book', 'Kesehatan' => 'health', 'Lingkungan' => 'leaf', 'Kemanusiaan' => 'heart', default => 'drop' }" class="h-12 w-12 opacity-80" />
        </div>
    @endif
    <div class="flex flex-1 flex-col p-5">
        <span class="text-xs font-bold uppercase tracking-wide text-teal-700">{{ $kat->nama_tampil ?? '-' }}@if($kampanye->lokasi) <span class="font-medium normal-case tracking-normal text-slate-400">&middot; {{ $kampanye->lokasi }}</span>@endif</span>
        <h3 class="mt-1 line-clamp-2 font-extrabold leading-snug group-hover:text-teal-700">{{ $kampanye->judul_tampil }}</h3>
        <x-progress :terkumpul="(int) ($kampanye->terkumpul ?? 0)" :target="$kampanye->target_dana" class="mt-4" />
        <p class="mt-3 text-xs text-slate-500">{{ __('Target') }} Rp {{ number_format($kampanye->target_dana, 0, ',', '.') }}</p>
    </div>
</a>
