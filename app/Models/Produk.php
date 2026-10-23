<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $primaryKey = 'produk_id';

    protected $fillable = [
        'kategori_id',
        'merek_id',
        'nama_produk',
        'kode_produk',
        'deskripsi',
        'spesifikasi',
        'status_produk',
    ];

    public function kategori()
    {
        return $this->belongsTo(
            Kategori::class,
            'kategori_id',
            'kategori_id'
        );
    }

    public function merek()
    {
        return $this->belongsTo(
            Merek::class,
            'merek_id',
            'merek_id'
        );
    }

    public function varian()
    {
        return $this->hasMany(
            VarianProduk::class,
            'produk_id',
            'produk_id'
        );
    }
    public function ulasan()
    {
        return $this->hasMany(
            Ulasan::class,
            'produk_id',
            'produk_id'
        )->orderByDesc('tanggal_ulasan');
    }

    public function galeri()
    {
        return $this->hasMany(
            GaleriProduk::class,
            'produk_id',
            'produk_id'
        );
    }
}