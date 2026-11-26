<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Modul 6 Soal 3: aturan pengelolaan kampanye dipusatkan di Gate
        Gate::define('kelola-kampanye', function (User $user) {
            return $user->hasAnyRole(['admin', 'petugas']);
        });
    }
}
