<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obatalkes_m', function (Blueprint $table) {
            $table->id('obatalkes_id');
            $table->string('obatalkes_kode', 100)->nullable();
            $table->string('obatalkes_nama', 250)->nullable();
            $table->decimal('stok', 15, 2)->nullable();
            $table->text('additional_data')->nullable();
            $table->datetime('created_date')->default(now());
            $table->integer('created_by')->nullable();
            $table->integer('modified_count')->nullable();
            $table->datetime('last_modified_date')->nullable();
            $table->integer('last_modified_by')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->boolean('is_active')->default(true);
            $table->datetime('deleted_date')->nullable();
            $table->integer('deleted_by')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obatalkes_m');
    }
};
