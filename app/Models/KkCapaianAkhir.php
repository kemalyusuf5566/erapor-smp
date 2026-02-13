<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KkCapaianAkhir extends Model
{
    protected $table = 'kk_capaian_akhir';
    protected $fillable = ['kk_kelompok_kegiatan_id', 'kk_dimensi_id', 'capaian'];

    public function kelompokKegiatan()
    {
        return $this->belongsTo(KkKelompokKegiatan::class, 'kk_kelompok_kegiatan_id');
    }
    public function dimensi()
    {
        return $this->belongsTo(KkDimensi::class, 'kk_dimensi_id');
    }
}
