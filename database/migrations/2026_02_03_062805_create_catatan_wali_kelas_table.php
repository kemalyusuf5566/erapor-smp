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
        Schema::create('catatan_wali_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_siswa_id')->constrained('data_siswa');
            $table->foreignId('data_tahun_pelajaran_id')->constrained('data_tahun_pelajaran');
            $table->text('catatan')->nullable();
            $table->string('status_kenaikan_kelas')->nullable(); // Naik / Tidak
            $table->timestamps();

            $table->unique(['data_siswa_id', 'data_tahun_pelajaran_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_wali_kelas');
    }
};
