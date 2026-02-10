<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KkKelompokAnggota extends Model
{
    protected $table = 'kk_kelompok_anggota';

    protected $fillable = [
        'kk_kelompok_id',
        'data_siswa_id',
    ];

    public function kelompok()
    {
        return $this->belongsTo(KkKelompok::class, 'kk_kelompok_id');
    }

    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'data_siswa_id');
    }
}
