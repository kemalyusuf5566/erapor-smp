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
        Schema::create('kk_capaian_akhir', function (Blueprint $table) {
            $table->id();

            // pivot kelompok-kegiatan
            $table->foreignId('kk_kelompok_kegiatan_id')
                ->constrained('kk_kelompok_kegiatan')
                ->cascadeOnDelete();

            // dimensi profil Pancasila
            $table->foreignId('kk_dimensi_id')
                ->constrained('kk_dimensi')
                ->cascadeOnDelete();

            $table->string('capaian', 255);
            $table->timestamps();

            // biar tidak dobel capaian yang sama dalam 1 pivot untuk 1 dimensi
            $table->unique(['kk_kelompok_kegiatan_id', 'kk_dimensi_id', 'capaian'], 'kk_capaian_akhir_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kk_capaian_akhir');
    }
};
