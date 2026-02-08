<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataGuru extends Model
{
    protected $table = 'data_guru';

    protected $fillable = [
        'pengguna_id',
        'nip',
        'nuptk',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'telepon',
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class);
    }
}
