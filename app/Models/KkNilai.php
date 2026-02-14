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
        'kk_capaian_akhir_id', // baru
        'predikat',
        'deskripsi',           // baru
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
    public function kkCapaianAkhir()
    {
        return $this->belongsTo(KkCapaianAkhir::class, 'kk_capaian_akhir_id');
    }
}
