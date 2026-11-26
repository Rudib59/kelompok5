<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use Illuminate\Http\Request;

class BahasaController extends Controller
{
    public function __invoke(Request $request, string $locale)
    {
        abort_unless(in_array($locale, SetLocale::BAHASA, true), 404);

        $request->session()->put('locale', $locale);

        return redirect()->back(fallback: route('beranda'));
    }
}
