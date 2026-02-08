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
        Schema::create('data_guru', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pengguna_id')
                ->constrained('pengguna')
                ->cascadeOnDelete();

            $table->string('nip')->nullable();
            $table->string('nuptk')->nullable();

            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();

            $table->enum('jenis_kelamin', ['L', 'P']);

            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_guru');
    }
};
