<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kampanyes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategoris')->cascadeOnDelete();
            $table->string('judul', 150);
            $table->string('judul_en', 150)->nullable();
            $table->string('penggalang', 100);
            $table->string('lokasi', 120)->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('deskripsi_en')->nullable();
            $table->string('sumber_nama', 150)->nullable();     // contoh: BNPB
            $table->string('sumber_url', 500)->nullable();
            $table->date('sumber_tanggal')->nullable();
            $table->string('gambar')->nullable();               // path di disk "public"
            $table->unsignedSmallInteger('tahun_mulai');
            $table->unsignedBigInteger('target_dana');
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('kampanyes'); }
};
