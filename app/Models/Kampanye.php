<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Kampanye extends Model
{
    use HasFactory;

    protected $table = 'kampanyes';

    protected $fillable = [
        'user_id',
        'kategori_id',
        'judul',
        'judul_en',
        'penggalang',
        'lokasi',
        'deskripsi',
        'deskripsi_en',
        'sumber_nama',
        'sumber_url',
        'sumber_tanggal',
        'gambar',
        'tahun_mulai',
        'target_dana',
        'status',
        'catatan_admin',
        'diproses_oleh',
        'diproses_pada',
    ];

    protected $casts = [
        'sumber_tanggal' => 'date',
        'diproses_pada' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function adminPemroses()
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function donasis()
    {
        return $this->hasMany(Donasi::class, 'kampanye_id');
    }

    private function inggris(): bool
    {
        return app()->getLocale() === 'en';
    }

    public function getJudulTampilAttribute(): string
    {
        return $this->inggris() && filled($this->judul_en)
            ? $this->judul_en
            : $this->judul;
    }

    public function getDeskripsiTampilAttribute(): ?string
    {
        return $this->inggris() && filled($this->deskripsi_en)
            ? $this->deskripsi_en
            : $this->deskripsi;
    }

    public function getGambarUrlAttribute(): ?string
    {
        return $this->gambar
            ? Storage::disk('public')->url($this->gambar)
            : null;
    }
}
