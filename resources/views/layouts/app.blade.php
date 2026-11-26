<x-shell title="Akun">
    @isset($header)
        <div class="mb-6 text-2xl font-extrabold">{{ $header }}</div>
    @endisset
    {{ $slot }}
</x-shell>
