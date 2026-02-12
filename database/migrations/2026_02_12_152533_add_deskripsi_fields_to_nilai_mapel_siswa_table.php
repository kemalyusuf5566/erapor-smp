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
        Schema::table('nilai_mapel_siswa', function (Blueprint $table) {

            $table->text('deskripsi_tinggi')->nullable()->after('deskripsi');
            $table->text('deskripsi_rendah')->nullable()->after('deskripsi_tinggi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilai_mapel_siswa', function (Blueprint $table) {

            $table->dropColumn(['deskripsi_tinggi', 'deskripsi_rendah']);
        });
    }
};
