<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KkNilai extends Model
{
    protected $table = 'kk_nilai';

    protected $fillable = [
        'kk_kelompok_id',
        'kk_kegiatan_id',
        'data_siswa_id',
        'capaian',
        'predikat',
    ];

    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'data_siswa_id');
    }

    public function kegiatan()
    {
        return $this->belongsTo(KkKegiatan::class, 'kk_kegiatan_id');
    }

    public function kelompok()
    {
        return $this->belongsTo(KkKelompok::class, 'kk_kelompok_id');
    }
}
