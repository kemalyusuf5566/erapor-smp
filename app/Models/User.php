<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna';

    protected $fillable = [
        'peran_id',
        'nama',
        'email',
        'username',
        'password',
        'foto',
        'status_aktif',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * ===============================
     * ROLE LAMA (SATU ROLE)
     * ===============================
     */
    public function peran()
    {
        return $this->belongsTo(Peran::class, 'peran_id');
    }

    /**
     * ===============================
     * ROLE BARU (MULTI ROLE)
     * ===============================
     */
    public function roles()
    {
        return $this->belongsToMany(
            Peran::class,
            'pengguna_peran',   // pivot table
            'pengguna_id',
            'peran_id'
        );
    }
}
