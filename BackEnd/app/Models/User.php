<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // <-- Import untuk token

class User extends Authenticatable
{
    // Tambahkan HasApiTokens agar method createToken() aktif
    use HasApiTokens, HasFactory, Notifiable;

    // Beritahu Laravel bahwa primary key kita bukan 'id', tapi 'user_id'
    protected $primaryKey = 'user_id';

    /**
     * Atribut yang dapat diisi (mass assignable).
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'no_telepon',
    ];

    /**
     * Atribut yang harus disembunyikan.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang harus di-cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}