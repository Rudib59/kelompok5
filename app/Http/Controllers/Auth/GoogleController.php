<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Donatur;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Two\GoogleProvider;

class GoogleController extends Controller
{
    private function provider(): GoogleProvider
    {
        abort_unless(class_exists(GoogleProvider::class) && config('galangkita.google.client_id'), 404);

        $c = config('galangkita.google');

        return \Laravel\Socialite\Facades\Socialite::buildProvider(GoogleProvider::class, [
            'client_id'     => $c['client_id'],
            'client_secret' => $c['client_secret'],
            'redirect'      => $c['redirect'] ?: url('/auth/google/callback'),
        ]);
    }

    public function redirect()
    {
        return $this->provider()->redirect();
    }

    public function callback()
    {
        try {
            $g = $this->provider()->user();
        } catch (\Throwable $e) {
            return redirect()->route('login')->withErrors([
                'email' => __('Masuk dengan Google dibatalkan atau gagal. Silakan coba lagi.'),
            ]);
        }

        $email = Str::lower((string) $g->getEmail());
        if ($email === '') {
            return redirect()->route('login')->withErrors(['email' => __('Akun Google tidak menyediakan alamat email.')]);
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            $user = User::create([
                'name'     => $g->getName() ?: Str::before($email, '@'),
                'email'    => $email,
                'password' => Hash::make(Str::random(40)),   // akun Google tidak memakai kata sandi
            ]);
            $user->assignRole('donatur');
            Donatur::create(['user_id' => $user->id, 'nama' => $user->name, 'email' => $user->email, 'no_telepon' => '-']);
        }

        Auth::login($user, true);

        return redirect()->route('dashboard')->with('success', __('Berhasil masuk dengan Google.'));
    }
}
