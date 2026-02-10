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
        Schema::create('kk_kelompok', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelompok');
            $table->foreignId('data_kelas_id')->constrained('data_kelas')->cascadeOnDelete();
            $table->foreignId('koordinator_id')->constrained('pengguna')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kk_kelompok');
    }
};
