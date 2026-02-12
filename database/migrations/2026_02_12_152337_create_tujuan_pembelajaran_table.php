<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tujuan_pembelajaran', function (Blueprint $table) {
            $table->id();

            // Relasi ke data_pembelajaran
            $table->foreignId('data_pembelajaran_id')
                ->constrained('data_pembelajaran')
                ->cascadeOnDelete();

            // Isi tujuan (max 150 karakter)
            $table->string('tujuan', 150);

            // Urutan tampil (opsional)
            $table->integer('urutan')->nullable();

            $table->timestamps();

            // Index tambahan untuk performa
            $table->index('data_pembelajaran_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tujuan_pembelajaran');
    }
};
