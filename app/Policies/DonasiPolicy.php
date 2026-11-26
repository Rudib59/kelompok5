<?php

namespace App\Policies;

use App\Models\Donasi;
use App\Models\User;

class DonasiPolicy
{
    public function view(User $user, Donasi $donasi): bool
    {
        if ($user->hasAnyRole(['admin', 'petugas'])) {
            return true;   // staf boleh melihat semua
        }

        return $donasi->donatur?->user_id === $user->id;   // donatur: hanya miliknya
    }
}
