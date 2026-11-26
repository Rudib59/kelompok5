<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public const BAHASA = ['id', 'en'];

    public function handle(Request $request, Closure $next): Response
    {
        // Web: dari sesi. API (tanpa sesi): dari header X-Locale yang dikirim Fetch.
        $locale = $request->hasSession() ? $request->session()->get('locale') : null;
        $locale ??= $request->header('X-Locale');

        if (! in_array($locale, self::BAHASA, true)) {
            $locale = config('app.locale', 'id');
        }

        app()->setLocale($locale);
        Carbon::setLocale($locale);

        return $next($request);
    }
}
