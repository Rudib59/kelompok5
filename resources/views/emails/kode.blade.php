<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<body style="margin:0;background:#fbf7f0;font-family:Arial,Helvetica,sans-serif;color:#292524;">
<div style="max-width:480px;margin:0 auto;padding:32px 20px;">
    <p style="font-size:20px;font-weight:800;color:#115e59;margin:0 0 24px;">GalangKita</p>
    <div style="background:#ffffff;border:1px solid #e7e5e4;border-radius:16px;padding:28px;">
        <p style="margin:0 0 12px;">{{ __('Halo') }} {{ $nama }},</p>
        <p style="margin:0 0 20px;line-height:1.5;">
            {{ $tujuan === 'ganti_email' ? __('Gunakan kode berikut untuk mengonfirmasi alamat email baru Anda.') : __('Gunakan kode berikut untuk mengonfirmasi penggantian kata sandi Anda.') }}
        </p>
        <p style="margin:0 0 20px;text-align:center;font-size:34px;font-weight:800;letter-spacing:8px;color:#0f766e;">{{ $kode }}</p>
        <p style="margin:0;font-size:13px;color:#78716c;line-height:1.5;">
            {{ __('Kode berlaku :menit menit. Jangan bagikan kode ini kepada siapa pun. Jika Anda tidak memintanya, abaikan email ini.', ['menit' => $menit]) }}
        </p>
    </div>
</div>
</body>
</html>
