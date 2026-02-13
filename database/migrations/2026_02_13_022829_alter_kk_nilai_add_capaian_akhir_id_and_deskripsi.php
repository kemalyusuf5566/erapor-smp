<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kk_nilai', function (Blueprint $table) {
            // kolom capaian akhir
            if (!Schema::hasColumn('kk_nilai', 'kk_capaian_akhir_id')) {
                $table->unsignedBigInteger('kk_capaian_akhir_id')->nullable()->after('data_siswa_id');
            }

            // kolom deskripsi
            if (!Schema::hasColumn('kk_nilai', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('predikat');
            }

            // ❗JANGAN buat foreign key di sini
            // karena di DB kamu ternyata sudah ada:
            // kk_nilai_kk_capaian_akhir_id_foreign
        });
    }

    public function down(): void
    {
        Schema::table('kk_nilai', function (Blueprint $table) {
            // jangan drop FK karena kita tidak menambah FK di migration ini

            if (Schema::hasColumn('kk_nilai', 'kk_capaian_akhir_id')) {
                $table->dropColumn('kk_capaian_akhir_id');
            }

            if (Schema::hasColumn('kk_nilai', 'deskripsi')) {
                $table->dropColumn('deskripsi');
            }
        });
    }
};
