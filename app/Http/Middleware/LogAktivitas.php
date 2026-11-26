<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogAktivitas
{
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('Akses', ['url' => $request->fullUrl(), 'ip' => $request->ip()]);

        return $next($request);
    }
}
