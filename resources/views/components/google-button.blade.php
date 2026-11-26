@if (config('galangkita.google.client_id') && class_exists(\Laravel\Socialite\Two\GoogleProvider::class))
    <div class="my-5 flex items-center gap-3 text-xs font-semibold uppercase tracking-wide text-slate-400">
        <span class="h-px flex-1 bg-slate-200"></span>{{ __('atau') }}<span class="h-px flex-1 bg-slate-200"></span>
    </div>
    <a href="{{ route('google.redirect') }}" class="flex w-full items-center justify-center gap-3 rounded-xl border border-slate-200 bg-white py-3 text-sm font-bold text-slate-700 hover:bg-slate-50">
        <span class="grid h-6 w-6 place-items-center rounded-full border border-slate-300 text-xs font-extrabold">G</span>
        {{ __('Lanjutkan dengan Google') }}
    </a>
@endif
