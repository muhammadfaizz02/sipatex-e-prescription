<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek apakah kolom 'nama_racikan' belum ada, baru tambahkan
        if (!Schema::hasColumn('resep', 'nama_racikan')) {
            Schema::table('resep', function (Blueprint $table) {
                $table->string('nama_racikan', 255)->nullable()->after('jenis');
            });
        }
    }

    public function down(): void
    {
        // Cek apakah kolom 'nama_racikan' ada, baru drop
        if (Schema::hasColumn('resep', 'nama_racikan')) {
            Schema::table('resep', function (Blueprint $table) {
                $table->dropColumn('nama_racikan');
            });
        }
    }
};
