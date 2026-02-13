<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataEkstrakurikuler extends Model
{
    protected $table = 'data_ekstrakurikuler';

    protected $fillable = [
        'nama_ekskul',
        'pembina_id',
        'status_aktif',
    ];

    public function pembina()
    {
        return $this->belongsTo(DataGuru::class, 'pembina_id');
    }

    public function anggota()
    {
        return $this->hasMany(EkskulAnggota::class, 'data_ekstrakurikuler_id');
    }
}
