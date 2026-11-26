<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\KodeVerifikasiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(private KodeVerifikasiService $kode) {}

    public function edit(Request $request): View
    {
        $u = $request->user();

        return view('profile.edit', [
            'user'          => $u,
            'menungguEmail' => $this->kode->adaKodeAktif($u, KodeVerifikasiService::GANTI_EMAIL),
            'menungguSandi' => $this->kode->adaKodeAktif($u, KodeVerifikasiService::GANTI_PASSWORD),
        ]);
    }

    /** Nama dan foto profil: tidak butuh kode email. */
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ], [
            'name.required' => __('Nama lengkap wajib diisi.'),
            'name.min'      => __('Nama minimal :min karakter.', ['min' => 3]),
            'foto.image'    => __('File harus berupa gambar.'),
            'foto.mimes'    => __('Format foto harus JPG, PNG, atau WEBP.'),
            'foto.max'      => __('Ukuran foto maksimal 3 MB.'),
        ]);

        $user = $request->user();
        $user->name = $data['name'];

        if ($request->boolean('hapus_foto') && $user->foto) {
            Storage::disk('public')->delete($user->foto);
            $user->foto = null;
        }
        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $user->foto = $request->file('foto')->store('profil', 'public');
        }
        $user->save();

        if ($user->donatur) {
            $user->donatur->update(['nama' => $user->name]);
        }

        return back()->with('success', __('Profil diperbarui.'));
    }

    // ---------- Ganti email: kode dikirim ke EMAIL BARU ----------
    public function mintaKodeEmail(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email_baru' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class, 'email')],
        ], [
            'email_baru.required'  => __('Email baru wajib diisi.'),
            'email_baru.email'     => __('Format email tidak valid. Contoh: nama@gmail.com'),
            'email_baru.lowercase' => __('Email harus ditulis dengan huruf kecil.'),
            'email_baru.unique'    => __('Email ini sudah dipakai akun lain.'),
        ]);

        $this->kode->kirim($request->user(), KodeVerifikasiService::GANTI_EMAIL, $data['email_baru'], ['email' => $data['email_baru']]);

        return back()->with('success', __('Kode verifikasi dikirim ke :email. Masukkan kode untuk menyelesaikan.', ['email' => $data['email_baru']]))
            ->with('buka', 'email');
    }

    public function konfirmasiEmail(Request $request): RedirectResponse
    {
        $request->validate(['kode_email' => ['required', 'digits:' . config('galangkita.kode.panjang')]], [
            'kode_email.required' => __('Kode verifikasi wajib diisi.'),
            'kode_email.digits'   => __('Kode terdiri dari :n angka.', ['n' => config('galangkita.kode.panjang')]),
        ]);

        [$ok, $galat, $payload] = $this->kode->cek($request->user(), KodeVerifikasiService::GANTI_EMAIL, $request->kode_email);

        if (! $ok) {
            return back()->withErrors(['kode_email' => $this->pesanKode($galat)])->with('buka', 'email');
        }

        $user = $request->user();
        $user->email = $payload['email'];
        $user->save();
        $user->donatur?->update(['email' => $user->email]);

        return back()->with('success', __('Email berhasil diganti.'));
    }

    // ---------- Ganti kata sandi: kode dikirim ke email saat ini ----------
    public function mintaKodeSandi(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8), 'different:current_password'],
        ], [
            'current_password.required'         => __('Kata sandi saat ini wajib diisi.'),
            'current_password.current_password' => __('Kata sandi saat ini salah.'),
            'password.required'                 => __('Kata sandi baru wajib diisi.'),
            'password.confirmed'                => __('Konfirmasi kata sandi tidak cocok dengan kata sandi baru.'),
            'password.min'                      => __('Kata sandi minimal :min karakter.', ['min' => 8]),
            'password.different'                => __('Kata sandi baru harus berbeda dari yang lama.'),
        ]);

        $user = $request->user();
        $this->kode->kirim($user, KodeVerifikasiService::GANTI_PASSWORD, $user->email, ['hash' => Hash::make($request->password)]);

        return back()->with('success', __('Kode verifikasi dikirim ke :email. Masukkan kode untuk menyelesaikan.', ['email' => $user->email]))
            ->with('buka', 'sandi');
    }

    public function konfirmasiSandi(Request $request): RedirectResponse
    {
        $request->validate(['kode_sandi' => ['required', 'digits:' . config('galangkita.kode.panjang')]], [
            'kode_sandi.required' => __('Kode verifikasi wajib diisi.'),
            'kode_sandi.digits'   => __('Kode terdiri dari :n angka.', ['n' => config('galangkita.kode.panjang')]),
        ]);

        [$ok, $galat, $payload] = $this->kode->cek($request->user(), KodeVerifikasiService::GANTI_PASSWORD, $request->kode_sandi);

        if (! $ok) {
            return back()->withErrors(['kode_sandi' => $this->pesanKode($galat)])->with('buka', 'sandi');
        }

        $request->user()->forceFill(['password' => $payload['hash']])->save();

        return back()->with('success', __('Kata sandi berhasil diganti.'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validate(['password_hapus' => ['required', 'current_password']], [
            'password_hapus.required'         => __('Kata sandi wajib diisi untuk menghapus akun.'),
            'password_hapus.current_password' => __('Kata sandi salah.'),
        ]);

        $user = $request->user();

        Auth::logout();
        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
        }
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function pesanKode(?string $kode): string
    {
        return match ($kode) {
            'kode_kedaluwarsa'    => __('Kode sudah kedaluwarsa. Minta kode baru.'),
            'kode_terlalu_banyak' => __('Terlalu banyak percobaan salah. Minta kode baru.'),
            'kode_tidak_ada'      => __('Belum ada kode aktif. Minta kode terlebih dahulu.'),
            default               => __('Kode salah. Periksa lagi kode di email Anda.'),
        };
    }
}
