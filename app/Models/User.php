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
     * SATU USER = SATU ROLE
     * (admin atau guru)
     */
    public function peran()
    {
        return $this->belongsTo(Peran::class, 'peran_id');
    }
}
