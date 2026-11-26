<x-shell title="Dashboard Penggalang">
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-extrabold text-teal-900">{{ __('Dashboard Penggalang Dana') }}</h1>
            <p class="mt-1 text-sm text-stone-600">
                {{ __('Selamat datang,') }} {{ auth()->user()->name }}!
                {{ __('Kelola kampanye penggalangan dana milikmu di sini.') }}
            </p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-stone-500">Total {{ __('Kampanye') }}</p>
                <p class="mt-2 text-3xl font-extrabold text-teal-800">
                    {{ $jumlahKampanye }}
                </p>
            </div>

            <div class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-stone-500">{{ __('Menunggu') }} Persetujuan</p>
                <p class="mt-2 text-3xl font-extrabold text-amber-600">
                    {{ $menunggu }}
                </p>
            </div>

            <div class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-stone-500">{{ __('Disetujui') }}</p>
                <p class="mt-2 text-3xl font-extrabold text-green-600">
                    {{ $disetujui }}
                </p>
            </div>

            <div class="rounded-2xl border border-stone-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-stone-500">{{ __('Ditolak') }}</p>
                <p class="mt-2 text-3xl font-extrabold text-red-600">
                    {{ $ditolak }}
                </p>
            </div>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-bold text-stone-800">{{ __('Kampanye') }} Terbaru</h2>
                <p class="text-sm text-stone-500">{{ __('Daftar kampanye yang sudah kamu ajukan.') }}</p>
            </div>

            <a href="{{ route('penggalang.kampanye.create') }}"
               class="rounded-xl bg-teal-700 px-4 py-2.5 text-sm font-bold text-white hover:bg-teal-800">{{ __('+ Buat Kampanye') }}</a>
        </div>

        <div class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            @forelse ($kampanyesTerbaru as $kampanye)
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-stone-100 p-5 last:border-0">
                    <div>
                        <h3 class="font-bold text-stone-800">
                            {{ $kampanye->judul }}
                        </h3>
                        <p class="mt-1 text-sm text-stone-500">
                            {{ $kampanye->kategori->nama ?? 'Tanpa kategori' }}
                        </p>
                    </div>

                    <span class="rounded-full px-3 py-1 text-xs font-bold
                        {{ $kampanye->status === 'disetujui' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $kampanye->status === 'menunggu' ? 'bg-amber-100 text-amber-700' : '' }}
                        {{ $kampanye->status === 'ditolak' ? 'bg-red-100 text-red-700' : '' }}">
                        {{ __($kampanye->status) }}
                    </span>
                </div>
            @empty
                <div class="p-8 text-center">
                    <p class="font-semibold text-stone-700">{{ __('Belum ada kampanye.') }}</p>
                    <p class="mt-1 text-sm text-stone-500">{{ __('Mulai buat kampanye pertamamu untuk menggalang dana.') }}</p>
                </div>
            @endforelse
        </div>

        <div>
            <a href="{{ route('penggalang.kampanye.index') }}"
               class="text-sm font-bold text-teal-700 hover:text-teal-900">{{ __('Lihat Semua Kampanye →') }}</a>
        </div>
    </div>
</x-shell>
