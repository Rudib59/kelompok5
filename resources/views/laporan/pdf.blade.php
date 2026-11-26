<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Laporan Penggalangan Dana') }} - GalangKita</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1e293b; margin: 24px; }
        .header { border-bottom: 2px solid #0f766e; padding-bottom: 12px; margin-bottom: 20px; }
        .brand { font-size: 18px; font-weight: bold; color: #0f766e; }
        .title { font-size: 16px; font-weight: bold; margin-top: 4px; }
        .meta { font-size: 10px; color: #64748b; margin-top: 4px; }
        .summary { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .summary td { width: 50%; padding: 10px 12px; border: 1px solid #cbd5e1; background: #f8fafc; }
        .summary .label { font-size: 10px; color: #64748b; }
        .summary .value { font-size: 15px; font-weight: bold; color: #0f172a; margin-top: 4px; }
        table.data { width: 100%; border-collapse: collapse; }
        table.data th, table.data td { border: 1px solid #cbd5e1; padding: 8px 10px; text-align: left; }
        table.data th { background: #0f766e; color: #ffffff; font-size: 11px; }
        table.data td.num, table.data th.num { text-align: right; }
        table.data tr:nth-child(even) td { background: #f8fafc; }
        .footer { margin-top: 24px; font-size: 10px; color: #64748b; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <div class="brand">GalangKita</div>
        <div class="title">{{ __('Laporan Penggalangan Dana') }}</div>
        <div class="meta">{{ __('Dihitung dari donasi yang sudah terverifikasi.') }} &middot; {{ __('Dicetak pada') }}: {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <table class="summary">
        <tr>
            <td>
                <div class="label">{{ __('Total dana terverifikasi') }}</div>
                <div class="value">Rp {{ number_format($rekap->sum('total'), 0, ',', '.') }}</div>
            </td>
            <td>
                <div class="label">{{ __('Jumlah donasi terverifikasi') }}</div>
                <div class="value">{{ $rekap->sum('jumlah') }}</div>
            </td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 36px;">No</th>
                <th>{{ __('Kampanye') }}</th>
                <th class="num" style="width: 110px;">{{ __('Jumlah Donasi') }}</th>
                <th class="num" style="width: 150px;">{{ __('Total Dana') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rekap as $i => $r)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ app()->getLocale() === 'en' && $r->judul_en ? $r->judul_en : $r->judul }}</td>
                    <td class="num">{{ $r->jumlah }}</td>
                    <td class="num">Rp {{ number_format($r->total, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #64748b;">{{ __('Belum ada donasi terverifikasi.') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">GalangKita &middot; {{ __('Portal penggalangan dana sosial') }}</div>
</body>
</html>
