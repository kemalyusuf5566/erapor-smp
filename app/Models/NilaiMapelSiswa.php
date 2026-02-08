<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiMapelSiswa extends Model
{
    protected $table = 'nilai_mapel_siswa';

    protected $fillable = [
        'data_siswa_id',
        'data_mapel_id',
        'data_kelas_id',
        'data_tahun_pelajaran_id',
        'semester',
        'nilai_angka',
        'predikat',
        'deskripsi',
    ];

    public function siswa()
    {
        return $this->belongsTo(DataSiswa::class, 'data_siswa_id');
    }

    public function mapel()
    {
        return $this->belongsTo(DataMapel::class, 'data_mapel_id');
    }

    public function kelas()
    {
        return $this->belongsTo(DataKelas::class, 'data_kelas_id');
    }

    public function tahun()
    {
        return $this->belongsTo(DataTahunPelajaran::class, 'data_tahun_pelajaran_id');
    }
}
