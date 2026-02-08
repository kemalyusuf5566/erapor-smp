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
        Schema::create('data_pembelajaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_kelas_id')->constrained('data_kelas');
            $table->foreignId('data_mapel_id')->constrained('data_mapel');
            $table->foreignId('guru_id')->constrained('pengguna');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pembelajaran');
    }
};
