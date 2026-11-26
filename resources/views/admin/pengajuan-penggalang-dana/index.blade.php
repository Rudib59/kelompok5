@extends('layouts.galangkita')

@section('title', __('Pengajuan Penggalang Dana'))

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">{{ __('Pengajuan Penggalang Dana') }}</h1>
        <p class="text-gray-600 mt-2">{{ __('Periksa data identitas dan kelola permohonan pengguna yang ingin menjadi Penggalang Dana.') }}</p>
    </div>

    @if (session('success'))
        <div class="mb-5 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-6 py-4 font-semibold">{{ __('Pengguna') }}</th>
                        <th class="px-6 py-4 font-semibold">{{ __('Alasan Pengajuan') }}</th>
                        <th class="px-6 py-4 font-semibold">{{ __('Tanggal') }}</th>
                        <th class="px-6 py-4 font-semibold">{{ __('Status') }}</th>
                        <th class="px-6 py-4 font-semibold">{{ __('Tindakan') }}</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($pengajuans as $pengajuan)
                        <tr class="align-top">
                            <td class="px-6 py-5">
                                <p class="font-semibold text-gray-900">
                                    {{ $pengajuan->user->name ?? 'Pengguna tidak tersedia' }}
                                </p>
                                <p class="mt-1 text-gray-500">
                                    {{ $pengajuan->user->email ?? '-' }}
                                </p>
                                <p class="mt-1 text-xs text-gray-500">
                                    {{ $pengajuan->nama_lengkap ?: 'Identitas belum dilengkapi' }}
                                </p>
                            </td>

                            <td class="px-6 py-5">
                                <p class="max-w-md whitespace-pre-line text-gray-700">
                                    {{ \Illuminate\Support\Str::limit($pengajuan->alasan, 180) }}
                                </p>

                                @if ($pengajuan->catatan_admin)
                                    <p class="mt-3 text-xs text-red-600">
                                        {{ __('Catatan Admin:') }} {{ $pengajuan->catatan_admin }}
                                    </p>
                                @endif
                            </td>

                            <td class="px-6 py-5 text-gray-600">
                                {{ $pengajuan->created_at->format('d M Y, H:i') }}
                            </td>

                            <td class="px-6 py-5">
                                @if ($pengajuan->status === 'menunggu')
                                    <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">{{ __('Menunggu') }}</span>
                                @elseif ($pengajuan->status === 'disetujui')
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">{{ __('Disetujui') }}</span>
                                @else
                                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">{{ __('Ditolak') }}</span>
                                @endif
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex min-w-32 flex-col gap-2">
                                    <a
                                        href="{{ route('admin.pengajuan-penggalang-dana.show', $pengajuan) }}"
                                        class="rounded-lg bg-teal-700 px-3 py-2 text-center text-xs font-semibold text-white hover:bg-teal-800"
                                    >{{ __('Periksa Identitas') }}</a>

                                    @if ($pengajuan->status !== 'menunggu')
                                        <div class="text-xs text-gray-500">
                                            {{ __('Diproses oleh:') }}
                                            {{ $pengajuan->admin->name ?? '-' }}
                                            <br>
                                            {{ $pengajuan->diproses_pada?->format('d M Y, H:i') ?? '-' }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">{{ __('Belum ada pengajuan Penggalang Dana.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-gray-100 px-6 py-4">
            {{ $pengajuans->links() }}
        </div>
    </div>
</div>
@endsection
