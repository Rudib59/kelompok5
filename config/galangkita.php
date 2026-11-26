<?php

return [
    // Login Google (opsional). Tombol hanya tampil bila client id terisi dan paket laravel/socialite terpasang.
    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect'      => env('GOOGLE_REDIRECT_URI'),
    ],

    // Kode verifikasi email untuk ganti email / kata sandi
    'kode' => [
        'panjang'      => 6,
        'berlaku_menit' => 10,
        'maks_percobaan' => 5,
    ],

    'kontak_email' => env('CONTACT_EMAIL', env('MAIL_FROM_ADDRESS', 'halo@galangkita.test')),
];
