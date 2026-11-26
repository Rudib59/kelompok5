@extends('layouts.galangkita')
@section('title', __('Kelola Kampanye'))

@section('content')
<div class="flex flex-wrap items-end justify-between gap-3">
    <div>
        <h1 class="text-3xl font-extrabold">{{ __('Kelola Kampanye') }}</h1>
        <p class="mt-1 text-slate-600">{{ __('Periksa dan kelola kampanye penggalangan dana.') }}</p>
    </div>

    @can('kelola-kampanye')
        <a href="{{ route('admin.kampanye.create') }}"
           class="rounded-xl bg-teal-700 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-teal-800">{{ __('+ Tambah kampanye') }}</a>
    @endcan
</div>

@if (session('success'))
    <div class="mt-4 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mt-4 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
        {{ session('error') }}
    </div>
@endif

<div class="mt-6 overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
    <table class="w-full min-w-[900px] text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
            <tr>
                <th class="p-4">{{ __('Kampanye') }}</th>
                <th class="p-4">{{ __('Kategori') }}</th>
                <th class="p-4">{{ __('Target') }}</th>
                <th class="p-4">{{ __('Status') }}</th>
                <th class="p-4 text-right">{{ __('Aksi') }}</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-slate-100">
            @forelse ($kampanyes as $k)
                <tr class="hover:bg-slate-50">
                    <td class="p-4">
                        <p class="font-semibold text-slate-800">
                            {{ $k->judul_tampil }}
                        </p>
                        <p class="mt-1 text-xs text-slate-500">
                            {{ __('Oleh') }} {{ $k->penggalang }}
                        </p>
                        @if ($k->user)
                            <p class="text-xs text-slate-400">
                                {{ __('Akun:') }} {{ $k->user->name }}
                            </p>
                        @endif

                        @if ($k->status === 'ditolak' && $k->catatan_admin)
                            <div class="mt-2 max-w-xs rounded-lg bg-red-50 p-2 text-xs text-red-600">
                                <span class="font-bold">{{ __('Alasan penolakan:') }}</span>
                                {{ $k->catatan_admin }}
                            </div>
                        @endif
                    </td>

                    <td class="p-4">
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                            {{ $k->kategori->nama_tampil }}
                        </span>
                    </td>

                    <td class="whitespace-nowrap p-4 font-semibold text-slate-700">
                        Rp {{ number_format($k->target_dana, 0, ',', '.') }}
                    </td>

                    <td class="p-4">
                        @if ($k->status === 'menunggu')
                            <span class="rounded-full bg-amber-100 px-3 py-1.5 text-xs font-bold text-amber-700">{{ __('Menunggu') }}</span>
                        @elseif ($k->status === 'disetujui')
                            <span class="rounded-full bg-green-100 px-3 py-1.5 text-xs font-bold text-green-700">{{ __('Disetujui') }}</span>
                        @elseif ($k->status === 'ditolak')
                            <span class="rounded-full bg-red-100 px-3 py-1.5 text-xs font-bold text-red-700">{{ __('Ditolak') }}</span>
                        @else
                            <span class="rounded-full bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-600">
                                {{ ucfirst($k->status ?? 'Tidak diketahui') }}
                            </span>
                        @endif
                    </td>

                    <td class="p-4">
                        <div class="flex flex-col items-end gap-3">
                            @if ($k->status === 'menunggu')
                                <div class="flex items-center justify-end gap-2">
                                    <form method="POST"
                                          action="{{ route('admin.kampanye.setujui', $k) }}"
                                          onsubmit="return confirm(@js(__('Yakin ingin menyetujui kampanye ini?')))">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                                class="rounded-lg bg-green-600 px-4 py-2 text-xs font-bold text-white transition hover:bg-green-700">{{ __('Setujui') }}</button>
                                    </form>

                                    <details class="relative">
                                        <summary class="cursor-pointer list-none rounded-lg bg-red-600 px-4 py-2 text-center text-xs font-bold text-white transition hover:bg-red-700">{{ __('Tolak') }}</summary>

                                        <form method="POST"
                                              action="{{ route('admin.kampanye.tolak', $k) }}"
                                              class="mt-2 w-64 rounded-xl border border-slate-200 bg-white p-3 shadow-lg">
                                            @csrf
                                            @method('PATCH')

                                            <label class="mb-2 block text-xs font-bold text-slate-700">{{ __('Alasan Penolakan') }}</label>

                                            <textarea name="catatan_admin"
                                                      rows="3"
                                                      required
                                                      minlength="5"
                                                      maxlength="1000"
                                                      placeholder="Jelaskan alasan kampanye ditolak..."
                                                      class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"></textarea>

                                            @error('catatan_admin')
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                            @enderror

                                            <button type="submit"
                                                    onclick="return confirm(@js(__('Yakin ingin menolak kampanye ini?')))"
                                                    class="mt-2 w-full rounded-lg bg-red-600 px-3 py-2 text-xs font-bold text-white hover:bg-red-700">{{ __('Kirim Penolakan') }}</button>
                                        </form>
                                    </details>
                                </div>
                            @endif

                            @can('kelola-kampanye')
                                <div class="flex items-center gap-3 border-t border-slate-100 pt-2">
                                    <a href="{{ route('admin.kampanye.edit', $k) }}"
                                       class="text-xs font-semibold text-blue-600 hover:text-blue-800">{{ __('Ubah') }}</a>

                                    <button type="button"
                                            x-data
                                            x-on:click="$dispatch('konfirmasi', { action: '{{ route('admin.kampanye.destroy', $k) }}', nama: @js($k->judul_tampil) })"
                                            class="text-xs font-semibold text-red-600 hover:text-red-800">{{ __('Hapus') }}</button>
                                </div>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-slate-500">{{ __('Belum ada kampanye.') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $kampanyes->links() }}
</div>
@endsection
