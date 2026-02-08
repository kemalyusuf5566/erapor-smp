<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('data_ekstrakurikuler', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ekskul');
            $table->unsignedBigInteger('pembina_id')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();

            // relasi ke pengguna (pembina ekskul)
            $table->foreign('pembina_id')
                  ->references('id')
                  ->on('pengguna')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_ekstrakurikuler');
    }
};
