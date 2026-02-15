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
        Schema::table('ekskul_anggota', function (Blueprint $table) {
            // simpan teks lengkap, misal: "Sangat Baik"
            $table->string('predikat', 30)->nullable()->change();
        });
    }

    public function down(): void
    {
        // kalau sebelumnya kamu pakai 1/2 char, sesuaikan.
        Schema::table('ekskul_anggota', function (Blueprint $table) {
            $table->string('predikat', 2)->nullable()->change();
        });
    }
};
