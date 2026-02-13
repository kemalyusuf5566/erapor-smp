<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KkKelompokKegiatan extends Model
{
    protected $table = 'kk_kelompok_kegiatan';

    protected $fillable = [
        'kk_kelompok_id',
        'kk_kegiatan_id',
    ];

    public function kelompok()
    {
        return $this->belongsTo(KkKelompok::class, 'kk_kelompok_id');
    }

    public function kegiatan()
    {
        return $this->belongsTo(KkKegiatan::class, 'kk_kegiatan_id');
    }

    // ini untuk langkah 3: capaian akhir
    public function capaianAkhir()
    {
        return $this->hasMany(KkCapaianAkhir::class, 'kk_kelompok_kegiatan_id');
    }
}
