<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kk_capaian_akhir', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kk_kelompok_kegiatan_id');
            $table->unsignedBigInteger('kk_dimensi_id');
            $table->text('capaian');
            $table->timestamps();

            $table->foreign('kk_kelompok_kegiatan_id')
                ->references('id')
                ->on('kk_kelompok_kegiatan')
                ->onDelete('cascade');

            $table->foreign('kk_dimensi_id')
                ->references('id')
                ->on('kk_dimensi')
                ->onDelete('cascade');

            // optional: biar tidak dobel dimensi + capaian sama
            // $table->unique(['kk_kelompok_kegiatan_id','kk_dimensi_id','capaian'], 'kk_capaian_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kk_capaian_akhir');
    }
};
