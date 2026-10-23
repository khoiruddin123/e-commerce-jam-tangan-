<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    protected $table = 'users';

    protected $primaryKey = 'user_id';

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

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'user_id', 'user_id');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'user_id', 'user_id');
    }
}