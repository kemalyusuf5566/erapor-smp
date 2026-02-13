<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Tambah semester jika belum ada
        Schema::table('catatan_wali_kelas', function (Blueprint $table) {
            if (!Schema::hasColumn('catatan_wali_kelas', 'semester')) {
                $table->enum('semester', ['Ganjil', 'Genap'])
                    ->default('Ganjil')
                    ->after('data_tahun_pelajaran_id');
            }
        });

        // 2) Drop SEMUA FK yang menempel pada kolom-kolom ini (apapun nama constraint-nya)
        $this->dropForeignKeysByColumn('catatan_wali_kelas', 'data_siswa_id');
        $this->dropForeignKeysByColumn('catatan_wali_kelas', 'data_tahun_pelajaran_id');

        // 3) Drop unique lama (yang sekarang bikin error)
        $this->dropIndexIfExists('catatan_wali_kelas', 'catatan_wali_kelas_data_siswa_id_data_tahun_pelajaran_id_unique');

        // 4) Buat unique baru (unik per siswa+tahun+semester)
        $this->dropIndexIfExists('catatan_wali_kelas', 'cw_unique_siswa_tahun_semester');
        DB::statement("
            ALTER TABLE catatan_wali_kelas
            ADD UNIQUE KEY cw_unique_siswa_tahun_semester (data_siswa_id, data_tahun_pelajaran_id, semester)
        ");

        // 5) Pasang lagi FK (biar rapi)
        Schema::table('catatan_wali_kelas', function (Blueprint $table) {
            // pastikan belum ada FK sebelum bikin, tapi umumnya sudah aman karena kita drop semua tadi
            $table->foreign('data_siswa_id')
                ->references('id')->on('data_siswa')
                ->onDelete('cascade');

            $table->foreign('data_tahun_pelajaran_id')
                ->references('id')->on('data_tahun_pelajaran')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Drop FK dinamis
        $this->dropForeignKeysByColumn('catatan_wali_kelas', 'data_siswa_id');
        $this->dropForeignKeysByColumn('catatan_wali_kelas', 'data_tahun_pelajaran_id');

        // Drop unique baru
        $this->dropIndexIfExists('catatan_wali_kelas', 'cw_unique_siswa_tahun_semester');

        // Drop semester
        Schema::table('catatan_wali_kelas', function (Blueprint $table) {
            if (Schema::hasColumn('catatan_wali_kelas', 'semester')) {
                $table->dropColumn('semester');
            }
        });

        // Balikkan unique lama (opsional)
        $this->dropIndexIfExists('catatan_wali_kelas', 'catatan_wali_kelas_data_siswa_id_data_tahun_pelajaran_id_unique');
        DB::statement("
            ALTER TABLE catatan_wali_kelas
            ADD UNIQUE KEY catatan_wali_kelas_data_siswa_id_data_tahun_pelajaran_id_unique (data_siswa_id, data_tahun_pelajaran_id)
        ");

        // Balikkan FK
        Schema::table('catatan_wali_kelas', function (Blueprint $table) {
            $table->foreign('data_siswa_id')
                ->references('id')->on('data_siswa')
                ->onDelete('cascade');

            $table->foreign('data_tahun_pelajaran_id')
                ->references('id')->on('data_tahun_pelajaran')
                ->onDelete('cascade');
        });
    }

    private function dropIndexIfExists(string $table, string $indexName): void
    {
        $exists = DB::selectOne("
            SELECT COUNT(1) AS cnt
            FROM information_schema.statistics
            WHERE table_schema = DATABASE()
              AND table_name = ?
              AND index_name = ?
        ", [$table, $indexName]);

        if ($exists && (int) $exists->cnt > 0) {
            DB::statement("ALTER TABLE {$table} DROP INDEX {$indexName}");
        }
    }

    private function dropForeignKeysByColumn(string $table, string $column): void
    {
        // Ambil semua constraint FK yang memakai kolom ini
        $fks = DB::select("
            SELECT DISTINCT kcu.CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE kcu
            WHERE kcu.TABLE_SCHEMA = DATABASE()
              AND kcu.TABLE_NAME = ?
              AND kcu.COLUMN_NAME = ?
              AND kcu.REFERENCED_TABLE_NAME IS NOT NULL
        ", [$table, $column]);

        foreach ($fks as $fk) {
            $name = $fk->CONSTRAINT_NAME;
            // Drop FK-nya
            DB::statement("ALTER TABLE {$table} DROP FOREIGN KEY {$name}");
        }
    }
};
