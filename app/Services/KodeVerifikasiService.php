<?php

namespace App\Services;

use App\Mail\KodeVerifikasiMail;
use App\Models\KodeVerifikasi;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

/**
 * Kode 6 digit dikirim lewat email, disimpan ter-hash, kedaluwarsa, dan dibatasi percobaannya.
 */
class KodeVerifikasiService
{
    public const GANTI_EMAIL = 'ganti_email';
    public const GANTI_PASSWORD = 'ganti_password';

    public function kirim(User $user, string $tujuan, string $kirimKe, array $payload = []): void
    {
        KodeVerifikasi::where('user_id', $user->id)->where('tujuan', $tujuan)->delete();

        $kode = str_pad((string) random_int(0, 999999), config('galangkita.kode.panjang'), '0', STR_PAD_LEFT);
        $menit = (int) config('galangkita.kode.berlaku_menit');

        KodeVerifikasi::create([
            'user_id'          => $user->id,
            'tujuan'           => $tujuan,
            'kode_hash'        => Hash::make($kode),
            'payload'          => $payload,
            'kedaluwarsa_pada' => now()->addMinutes($menit),
        ]);

        Mail::to($kirimKe)->send(new KodeVerifikasiMail($user->name, $kode, $tujuan, $menit));
    }

    /**
     * @return array{0: bool, 1: string|null, 2: array}  [berhasil, kodeGalat, payload]
     */
    public function cek(User $user, string $tujuan, string $kode): array
    {
        $rec = KodeVerifikasi::where('user_id', $user->id)->where('tujuan', $tujuan)->latest()->first();

        if (! $rec) {
            return [false, 'kode_tidak_ada', []];
        }
        if ($rec->kedaluwarsa_pada->isPast()) {
            $rec->delete();

            return [false, 'kode_kedaluwarsa', []];
        }
        if ($rec->percobaan >= (int) config('galangkita.kode.maks_percobaan')) {
            $rec->delete();

            return [false, 'kode_terlalu_banyak', []];
        }
        if (! Hash::check($kode, $rec->kode_hash)) {
            $rec->increment('percobaan');

            return [false, 'kode_salah', []];
        }

        $payload = $rec->payload ?? [];
        $rec->delete();

        return [true, null, $payload];
    }

    public function adaKodeAktif(User $user, string $tujuan): bool
    {
        return KodeVerifikasi::where('user_id', $user->id)->where('tujuan', $tujuan)
            ->where('kedaluwarsa_pada', '>', now())->exists();
    }
}
