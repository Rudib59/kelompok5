<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KodeVerifikasi extends Model
{
    protected $table = 'kode_verifikasis';
    protected $fillable = ['user_id', 'tujuan', 'kode_hash', 'payload', 'percobaan', 'kedaluwarsa_pada'];
    protected $casts = ['kedaluwarsa_pada' => 'datetime', 'payload' => 'array'];

    public function user() { return $this->belongsTo(User::class); }
}
