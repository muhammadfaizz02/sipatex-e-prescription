<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resep', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis', ['racikan', 'non_racikan']);
            $table->date('tanggal')->default(now());
            $table->timestamps();
            $table->string('nama_racikan', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resep');
    }
};
