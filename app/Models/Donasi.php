<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    use HasFactory;

    protected $table = 'donasis';
    protected $fillable = ['donatur_id', 'kampanye_id', 'tanggal_donasi', 'tanggal_verifikasi', 'nominal'];

    public function donatur() { return $this->belongsTo(Donatur::class); }
    public function kampanye() { return $this->belongsTo(Kampanye::class); }
}
