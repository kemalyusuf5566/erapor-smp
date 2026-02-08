<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengguna')->updateOrInsert(
            // kondisi pencarian
            ['email' => 'admin@erapor.test'],

            // data yang diisi / diupdate
            [
                'peran_id' => DB::table('peran')->where('nama_peran', 'admin')->value('id'),
                'nama' => 'Administrator',
                'password' => Hash::make('password'),
                'status_aktif' => true,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}
