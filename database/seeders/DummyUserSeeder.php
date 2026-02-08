<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DummyUserSeeder extends Seeder
{
    public function run(): void
    {
        $roleGuru = DB::table('peran')->where('nama_peran', 'guru_mapel')->value('id');
        $roleWali = DB::table('peran')->where('nama_peran', 'wali_kelas')->value('id');

        // Dummy Guru
        DB::table('pengguna')->updateOrInsert(
            ['email' => 'guru@erapor.test'],
            [
                'peran_id' => $roleGuru,
                'nama' => 'Guru Matematika',
                'password' => Hash::make('password'),
                'status_aktif' => true,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        // Dummy Wali Kelas
        DB::table('pengguna')->updateOrInsert(
            ['email' => 'wali@erapor.test'],
            [
                'peran_id' => $roleWali,
                'nama' => 'Wali Kelas VII A',
                'password' => Hash::make('password'),
                'status_aktif' => true,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}
