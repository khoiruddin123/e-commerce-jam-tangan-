<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';

    protected $primaryKey = 'keranjang_id';

    protected $fillable = [
        'user_id',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'user_id'
        );
    }


    public function detail()
    {
        return $this->hasMany(
            DetailKeranjang::class,
            'keranjang_id',
            'keranjang_id'
        );
    }


    public function getTotalHargaAttribute(): float
    {
        return (float) $this->detail->sum(function ($item) {
            return $item->subtotal;
        });
    }

 
    public function getTotalItemAttribute(): int
    {
        return (int) $this->detail->sum('jumlah');
    }
}
