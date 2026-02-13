<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_ketidakhadiran', function (Blueprint $table) {
            // 1) tambah kolom semester kalau belum ada
            if (!Schema::hasColumn('data_ketidakhadiran', 'semester')) {
                $table->enum('semester', ['Ganjil', 'Genap'])
                    ->default('Ganjil')
                    ->after('data_tahun_pelajaran_id');
            }
        });

        // 2) drop unique lama (kalau ada) lalu buat unique baru (siswa+tahun+semester)
        // NOTE: drop index unique harus by name
        $this->dropIndexIfExists('data_ketidakhadiran', 'data_ketidakhadiran_data_siswa_id_data_tahun_pelajaran_id_unique');
        $this->dropIndexIfExists('data_ketidakhadiran', 'dk_unique_siswa_tahun_semester');

        DB::statement("
            ALTER TABLE data_ketidakhadiran
            ADD UNIQUE KEY dk_unique_siswa_tahun_semester (data_siswa_id, data_tahun_pelajaran_id, semester)
        ");

        // 3) index biasa (opsional). Ini yang error kamu: index sudah ada.
        // Jadi drop dulu kalau sudah ada, atau jangan bikin sama sekali.
        $this->dropIndexIfExists('data_ketidakhadiran', 'dk_data_siswa_id_index');
        DB::statement("ALTER TABLE data_ketidakhadiran ADD INDEX dk_data_siswa_id_index (data_siswa_id)");

        $this->dropIndexIfExists('data_ketidakhadiran', 'dk_tahun_index');
        DB::statement("ALTER TABLE data_ketidakhadiran ADD INDEX dk_tahun_index (data_tahun_pelajaran_id)");
    }

    public function down(): void
    {
        // rollback unique baru
        $this->dropIndexIfExists('data_ketidakhadiran', 'dk_unique_siswa_tahun_semester');

        // rollback index opsional
        $this->dropIndexIfExists('data_ketidakhadiran', 'dk_data_siswa_id_index');
        $this->dropIndexIfExists('data_ketidakhadiran', 'dk_tahun_index');

        // hapus kolom semester kalau ada
        Schema::table('data_ketidakhadiran', function (Blueprint $table) {
            if (Schema::hasColumn('data_ketidakhadiran', 'semester')) {
                $table->dropColumn('semester');
            }
        });

        // balikin unique lama (kalau kamu memang mau)
        // (opsional) kalau dulu unique lama wajib ada:
        // DB::statement("
        //   ALTER TABLE data_ketidakhadiran
        //   ADD UNIQUE KEY data_ketidakhadiran_data_siswa_id_data_tahun_pelajaran_id_unique (data_siswa_id, data_tahun_pelajaran_id)
        // ");
    }

    private function dropIndexIfExists(string $table, string $indexName): void
    {
        // MySQL: DROP INDEX harus pakai statement
        $exists = DB::selectOne("
            SELECT COUNT(1) AS cnt
            FROM information_schema.statistics
            WHERE table_schema = DATABASE()
              AND table_name = ?
              AND index_name = ?
        ", [$table, $indexName]);

        if ($exists && (int)$exists->cnt > 0) {
            DB::statement("ALTER TABLE {$table} DROP INDEX {$indexName}");
        }
    }
};
