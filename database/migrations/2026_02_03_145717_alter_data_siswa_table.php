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
        Schema::table('data_siswa', function (Blueprint $table) {
            $table->string('status_dalam_keluarga')->nullable();
            $table->integer('anak_ke')->nullable();
            $table->string('telepon')->nullable();

            $table->string('sekolah_asal')->nullable();
            $table->string('diterima_di_kelas')->nullable();
            $table->date('tanggal_diterima')->nullable();

            $table->string('nama_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->text('alamat_orang_tua')->nullable();
            $table->string('telepon_orang_tua')->nullable();

            $table->string('nama_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->text('alamat_wali')->nullable();
            $table->string('telepon_wali')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_siswa', function (Blueprint $table) {
            //
        });
    }
};
