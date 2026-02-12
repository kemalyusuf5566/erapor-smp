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
        Schema::create('nilai_mapel_siswa_tujuan', function (Blueprint $table) {
            $table->id();

            // Relasi ke nilai_mapel_siswa
            $table->foreignId('nilai_mapel_siswa_id')
                ->constrained('nilai_mapel_siswa')
                ->cascadeOnDelete();

            // Relasi ke tujuan_pembelajaran
            $table->foreignId('tujuan_pembelajaran_id')
                ->constrained('tujuan_pembelajaran')
                ->cascadeOnDelete();

            // Kategori checklist
            $table->enum('kategori', ['optimal', 'perlu']);

            $table->timestamps();

            // Supaya 1 TP hanya bisa dicatat sekali per siswa
            $table->unique([
                'nilai_mapel_siswa_id',
                'tujuan_pembelajaran_id'
            ], 'unique_nilai_tp_per_siswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_mapel_siswa_tujuan');
    }
};
