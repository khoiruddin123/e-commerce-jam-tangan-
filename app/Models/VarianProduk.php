<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VarianProduk extends Model
{
    protected $table = 'varian_produk';

    protected $primaryKey = 'varian_id';

    public $timestamps = false;

    protected $fillable = [
        'produk_id',
        'nama_varian',
        'kode_sku',
        'warna',
        'bahan_tali',
        'harga_varian',
        'stok',
        'status_varian',
    ];

    public function produk()
    {
        return $this->belongsTo(
            Produk::class,
            'produk_id',
            'produk_id'
        );
    }

    public function detailKeranjang()
    {
        return $this->hasMany(
            DetailKeranjang::class,
            'varian_id',
            'varian_id'
        );
    }

    public function detailPesanan()
    {
        return $this->hasMany(
            DetailPesanan::class,
            'varian_id',
            'varian_id'
        );
    }
}