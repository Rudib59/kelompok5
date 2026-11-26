<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanPenggalangDana extends Model
{
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nik',
        'foto_ktp',
        'no_whatsapp',
        'alamat',
        'alasan',
        'status',
        'catatan_admin',
        'diproses_oleh',
        'diproses_pada',
    ];

    protected $hidden = [
        'nik',
        'foto_ktp',
    ];

    protected function casts(): array
    {
        return [
            'nik' => 'encrypted',
            'diproses_pada' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }
}
