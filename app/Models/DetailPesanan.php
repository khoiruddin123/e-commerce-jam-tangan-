<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanan';

    protected $primaryKey = 'detail_pesanan_id';

    public $timestamps = false;

    protected $fillable = [
        'pesanan_id',
        'varian_id',
        'nama_produk',
        'nama_varian',
        'kode_sku',
        'harga_satuan',
        'jumlah',
        'subtotal',
    ];

    public function pesanan()
    {
        return $this->belongsTo(
            Pesanan::class,
            'pesanan_id',
            'pesanan_id'
        );
    }

    public function varian()
    {
        return $this->belongsTo(
            VarianProduk::class,
            'varian_id',
            'varian_id'
        );
    }

    public function ulasan()
    {
        return $this->hasOne(
            Ulasan::class,
            'detail_pesanan_id',
            'detail_pesanan_id'
        );
    }
}