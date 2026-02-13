<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KkKelompok extends Model
{
    protected $table = 'kk_kelompok';

    protected $fillable = [
        'nama_kelompok',
        'data_kelas_id',
        'koordinator_id',
    ];

    public function kelas()
    {
        return $this->belongsTo(DataKelas::class, 'data_kelas_id');
    }

    public function koordinator()
    {
        return $this->belongsTo(User::class, 'koordinator_id');
    }

    public function anggota()
    {
        return $this->hasMany(KkKelompokAnggota::class, 'kk_kelompok_id');
    }

    public function kegiatan()
    {
        return $this->belongsToMany(
            KkKegiatan::class,
            'kk_kelompok_kegiatan',
            'kk_kelompok_id',
            'kk_kegiatan_id'
        );
    }

    public function nilai()
    {
        return $this->hasMany(KkNilai::class, 'kk_kelompok_id');
    }
    
    public function kelompokKegiatan()
    {
        return $this->hasMany(KkKelompokKegiatan::class, 'kk_kelompok_id');
    }
}
