<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KkKegiatan extends Model
{
    protected $table = 'kk_kegiatan';

    protected $fillable = [
        'tema',
        'nama_kegiatan',
        'deskripsi',
    ];

    public function kelompok()
    {
        return $this->belongsToMany(
            KkKelompok::class,
            'kk_kelompok_kegiatan',
            'kk_kegiatan_id',
            'kk_kelompok_id'
        );
    }
}
