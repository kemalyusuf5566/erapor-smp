<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TujuanPembelajaran extends Model
{
    protected $table = 'tujuan_pembelajaran';

    protected $fillable = [
        'data_pembelajaran_id',
        'tujuan',
        'urutan',
    ];

    public function pembelajaran()
    {
        return $this->belongsTo(DataPembelajaran::class, 'data_pembelajaran_id');
    }
}
