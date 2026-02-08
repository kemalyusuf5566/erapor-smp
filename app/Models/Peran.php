<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peran extends Model
{
    protected $table = 'peran';

    protected $fillable = ['nama_peran'];

    /**
     * RELASI: role dimiliki banyak user
     */
    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'pengguna_peran',
            'peran_id',
            'pengguna_id'
        );
    }
}
