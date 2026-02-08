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
        Schema::create('leger_nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_pembelajaran_id')->constrained('data_pembelajaran');
            $table->foreignId('data_siswa_id')->constrained('data_siswa');
            $table->integer('nilai_akhir')->nullable();
            $table->string('predikat')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->unique(['data_pembelajaran_id', 'data_siswa_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leger_nilai');
    }
};
