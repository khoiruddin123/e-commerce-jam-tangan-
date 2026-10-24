<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $table = 'ulasan';

    protected $primaryKey = 'ulasan_id';

    // Karena kolomnya tanggal_ulasan (bukan created_at & updated_at)
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'produk_id',
        'detail_pesanan_id',
        'rating',
        'komentar',
        'tanggal_ulasan',
    ];

    protected $casts = [
        'rating' => 'integer',
        'tanggal_ulasan' => 'datetime',
    ];

    /**
     * Relasi ke Pelanggan yang memberikan ulasan
     */
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'user_id'
        );
    }

    /**
     * Relasi ke Produk yang diulas
     */
    public function produk()
    {
        return $this->belongsTo(
            Produk::class,
            'produk_id',
            'produk_id'
        );
    }

    /**
     * Relasi ke Item Detail Pesanan pembelian
     */
    public function detailPesanan()
    {
        return $this->belongsTo(
            DetailPesanan::class,
            'detail_pesanan_id',
            'detail_pesanan_id'
        );
    }
}
