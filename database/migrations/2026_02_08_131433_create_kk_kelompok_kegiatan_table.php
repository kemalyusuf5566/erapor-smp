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
        Schema::create('kk_kelompok_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kk_kelompok_id')->constrained('kk_kelompok')->cascadeOnDelete();
            $table->foreignId('kk_kegiatan_id')->constrained('kk_kegiatan')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['kk_kelompok_id', 'kk_kegiatan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kk_kelompok_kegiatan');
    }
};
