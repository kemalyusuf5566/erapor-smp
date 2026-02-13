<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ekskul_anggota', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('data_ekstrakurikuler_id');
            $table->unsignedBigInteger('data_siswa_id');

            $table->enum('predikat', ['kurang', 'cukup', 'baik', 'sangat baik'])->nullable();
            $table->text('deskripsi')->nullable();

            $table->timestamps();

            $table->unique(['data_ekstrakurikuler_id', 'data_siswa_id'], 'ekskul_anggota_unique');

            $table->foreign('data_ekstrakurikuler_id')
                ->references('id')->on('data_ekstrakurikuler')
                ->onDelete('cascade');

            $table->foreign('data_siswa_id')
                ->references('id')->on('data_siswa')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ekskul_anggota');
    }
};
