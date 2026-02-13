<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EkskulAnggota extends Model
{
    protected $table = 'ekskul_anggota';

    protected $fillable = [
        'data_ekstrakurikuler_id',
        'data_siswa_id',
        'predikat',
        'deskripsi',
    ];

    public function ekskul()
    {
        return $this->belongsTo(DataEkstrakurikuler::class, 'data_ekstrakurikuler_id');
    }

    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'data_siswa_id');
    }
}
