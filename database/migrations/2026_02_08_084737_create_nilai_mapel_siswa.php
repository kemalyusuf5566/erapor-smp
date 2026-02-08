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
        Schema::create('nilai_mapel_siswa', function (Blueprint $table) {
            $table->id();

            $table->foreignId('data_siswa_id')
                ->constrained('data_siswa')
                ->cascadeOnDelete();

            $table->foreignId('data_mapel_id')
                ->constrained('data_mapel')
                ->cascadeOnDelete();

            $table->foreignId('data_kelas_id')
                ->constrained('data_kelas')
                ->cascadeOnDelete();

            $table->foreignId('data_tahun_pelajaran_id')
                ->constrained('data_tahun_pelajaran')
                ->cascadeOnDelete();

            $table->enum('semester', ['Ganjil', 'Genap']);

            $table->integer('nilai_angka')->nullable();
            $table->string('predikat', 5)->nullable();
            $table->text('deskripsi')->nullable();

            $table->timestamps();

            $table->unique([
                'data_siswa_id',
                'data_mapel_id',
                'semester',
                'data_tahun_pelajaran_id'
            ], 'nilai_unik_siswa_mapel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_mapel_siswa');
    }
};
