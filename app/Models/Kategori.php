<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';
    protected $fillable = ['nama', 'nama_en'];

    public function kampanyes() { return $this->hasMany(Kampanye::class); }

    // Nama sesuai bahasa aktif (id/en). Bahasa Inggris jatuh ke bahasa Indonesia bila kosong.
    public function getNamaTampilAttribute(): string
    {
        return app()->getLocale() === 'en' && filled($this->nama_en) ? $this->nama_en : $this->nama;
    }
}
