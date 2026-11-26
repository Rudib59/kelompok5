<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kode_verifikasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('tujuan', 30);            // ganti_email | ganti_password
            $table->string('kode_hash');             // kode 6 digit disimpan ter-hash
            $table->text('payload')->nullable();     // data yang menunggu konfirmasi (email baru / hash password baru)
            $table->unsignedTinyInteger('percobaan')->default(0);
            $table->timestamp('kedaluwarsa_pada');
            $table->timestamps();

            $table->index(['user_id', 'tujuan']);
        });
    }

    public function down(): void { Schema::dropIfExists('kode_verifikasis'); }
};
