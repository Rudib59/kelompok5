<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuan_penggalang_danas', function (Blueprint $table) {
            $table->string('nama_lengkap', 150)->nullable()->after('user_id');
            $table->text('nik')->nullable()->after('nama_lengkap');
            $table->string('foto_ktp')->nullable()->after('nik');
            $table->string('no_whatsapp', 20)->nullable()->after('foto_ktp');
            $table->text('alamat')->nullable()->after('no_whatsapp');
        });
    }

    public function down(): void
    {
        Schema::table('pengajuan_penggalang_danas', function (Blueprint $table) {
            $table->dropColumn([
                'nama_lengkap',
                'nik',
                'foto_ktp',
                'no_whatsapp',
                'alamat',
            ]);
        });
    }
};
