<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resep_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resep_id')->constrained('resep');
            $table->foreignId('obatalkes_id')->constrained('obatalkes_m', 'obatalkes_id');
            $table->foreignId('signa_id')->constrained('signa_m', 'signa_id');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resep_detail');
    }
};
