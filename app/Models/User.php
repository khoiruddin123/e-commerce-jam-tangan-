<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    // Matikan remember token karena tabel SQL tidak memiliki kolom remember_token
    protected $rememberTokenName = null;

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'role',
        'no_telepon',
        'alamat',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'user_id', 'user_id');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'user_id', 'user_id');
    }
}