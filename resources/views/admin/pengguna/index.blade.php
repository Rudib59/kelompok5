@extends('layouts.galangkita')
@section('title', 'Kelola Pengguna')

@section('content')
<h1 class="text-3xl font-extrabold">{{ __('Pengguna & Role') }}</h1>
<p class="mt-1 text-slate-600">{{ __('Hanya admin yang dapat mengubah role. Role tidak bisa dipilih saat registrasi.') }}</p>

<div class="mt-6 overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
    <table class="w-full min-w-[560px] text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
            <tr><th class="p-3">{{ __('Pengguna') }}</th><th class="p-3">{{ __('Role') }}</th><th class="p-3">{{ __('Ubah role') }}</th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
        @foreach ($users as $u)
            <tr class="hover:bg-slate-50">
                <td class="p-3">
                    <div class="flex items-center gap-3">
                        <span class="grid h-10 w-10 place-items-center rounded-full bg-teal-700 font-bold text-white">{{ strtoupper(mb_substr($u->name, 0, 1)) }}</span>
                        <div><p class="font-semibold">{{ $u->name }} @if ($u->id === auth()->id()) <span class="text-xs font-normal text-slate-400">{{ __('(kamu)') }}</span> @endif</p><p class="text-xs text-slate-500">{{ $u->email }}</p></div>
                    </div>
                </td>
                <td class="p-3">
                    @foreach ($u->roles as $r)
                        <span class="rounded-full px-2.5 py-1 text-xs font-bold capitalize {{ $r->name === 'admin' ? 'bg-violet-50 text-violet-700' : ($r->name === 'petugas' ? 'bg-sky-50 text-sky-700' : 'bg-teal-50 text-teal-700') }}">{{ $r->name }}</span>
                    @endforeach
                </td>
                <td class="p-3">
                    @can('kelola-role')
                        @if ($u->id === auth()->id())
                            <span class="text-xs text-slate-400">{{ __('Tidak dapat mengubah akun sendiri') }}</span>
                        @else
                            <form method="POST" action="{{ route('admin.pengguna.role', $u) }}">
                                @csrf
                                @method('PATCH')
                                <select name="role" onchange="this.form.submit()" class="rounded-lg border border-slate-200 py-2 pl-3 pr-9 text-sm font-semibold focus:border-teal-500 focus:ring-teal-200">
                                    @foreach ($roles as $r)
                                        <option value="{{ $r }}" @selected($u->hasRole($r))>{{ __($r) }}</option>
                                    @endforeach
                                </select>
                            </form>
                        @endif
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $users->links() }}</div>
@endsection
