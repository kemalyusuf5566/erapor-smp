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
}
