<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('donasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donatur_id')->constrained('donaturs')->cascadeOnDelete();
            $table->foreignId('kampanye_id')->constrained('kampanyes')->cascadeOnDelete();
            $table->date('tanggal_donasi');
            $table->date('tanggal_verifikasi')->nullable();
            $table->unsignedBigInteger('nominal');
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('donasis'); }
};
