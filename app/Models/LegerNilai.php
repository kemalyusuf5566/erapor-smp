<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegerNilai extends Model
{
    protected $table = 'leger_nilai';
        protected $fillable = [
            'data_pembelajaran_id',
            'data_siswa_id',
            'nilai_akhir',
            'predikat',
            'deskripsi',
        ];
    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'data_siswa_id');
    }

    public function pembelajaran()
    {
        return $this->belongsTo(DataPembelajaran::class, 'data_pembelajaran_id');
    }
}
