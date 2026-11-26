<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donatur extends Model
{
    use HasFactory;

    protected $table = 'donaturs';
    protected $fillable = ['user_id', 'nama', 'email', 'no_telepon'];

    public function user() { return $this->belongsTo(User::class); }
    public function donasis() { return $this->hasMany(Donasi::class); }
}
