<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $primaryKey = 'pesanan_id';

    public $timestamps = false;

    protected $fillable = [
        'nomor_pesanan',
        'user_id',
        'nama_penerima',
        'telepon_penerima',
        'alamat_pengiriman',
        'kota',
        'kode_pos',
        'subtotal',
        'ongkir',
        'total_harga',
        'status_pesanan',
        'catatan',
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
            DetailPesanan::class,
            'pesanan_id',
            'pesanan_id'
        );
    }

    public function pembayaran()
    {
        return $this->hasOne(
            Pembayaran::class,
            'pesanan_id',
            'pesanan_id'
        );
    }
}