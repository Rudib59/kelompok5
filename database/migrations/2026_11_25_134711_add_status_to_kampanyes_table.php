<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kampanyes', function (Blueprint $table) {
            $table->string('status')->default('disetujui');
            $table->text('catatan_admin')->nullable();
            $table->foreignId('diproses_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamp('diproses_pada')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('kampanyes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('diproses_oleh');
            $table->dropColumn([
                'status',
                'catatan_admin',
                'diproses_pada',
            ]);
        });
    }
};
