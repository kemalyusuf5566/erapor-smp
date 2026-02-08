<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataSekolah extends Model
{
   protected $table = 'data_sekolah';

    protected $fillable = [
        'nama_sekolah',
        'npsn',
        'alamat',
        'kepala_sekolah',
        'nip_kepala_sekolah',
    ];

    public function kelas()
    {
        return $this->hasMany(DataKelas::class, 'data_sekolah_id');
    }
}
