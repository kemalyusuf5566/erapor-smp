<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengguna_peran', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pengguna_id')
                ->constrained('pengguna')
                ->cascadeOnDelete();

            $table->foreignId('peran_id')
                ->constrained('peran')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['pengguna_id', 'peran_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengguna_peran');
    }
};
