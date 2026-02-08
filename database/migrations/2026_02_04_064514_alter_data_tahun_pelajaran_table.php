<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('data_tahun_pelajaran', function (Blueprint $table) {

            // ubah kolom lama kalau perlu
            if (Schema::hasColumn('data_tahun_pelajaran', 'tahun_pelajaran')) {
                $table->string('tahun_pelajaran')->change();
            }

            // kolom baru sesuai kebutuhan UI
            if (!Schema::hasColumn('data_tahun_pelajaran', 'tempat_pembagian_rapor')) {
                $table->string('tempat_pembagian_rapor')->nullable();
            }

            if (!Schema::hasColumn('data_tahun_pelajaran', 'tanggal_pembagian_rapor')) {
                $table->date('tanggal_pembagian_rapor')->nullable();
            }

            // pastikan status_aktif ada
            if (!Schema::hasColumn('data_tahun_pelajaran', 'status_aktif')) {
                $table->boolean('status_aktif')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('data_tahun_pelajaran', function (Blueprint $table) {
            $table->dropColumn([
                'tempat_pembagian_rapor',
                'tanggal_pembagian_rapor',
            ]);
        });
    }
};
