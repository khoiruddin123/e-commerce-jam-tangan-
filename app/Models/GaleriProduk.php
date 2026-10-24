<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaleriProduk extends Model
{
    protected $table = 'galeri_produk';

    protected $primaryKey = 'galeri_id';

    public $timestamps = false;

    protected $fillable = [
        'produk_id',
        'foto',
        'keterangan',
        'foto_utama',
        'urutan',
    ];

    public function produk()
    {
        return $this->belongsTo(
            Produk::class,
            'produk_id',
            'produk_id'
        );
    }
}