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

    /**
     * Accessor URL Foto: otomatis menangani string Base64 dari database maupun path file lama.
     */
    public function getUrlAttribute()
    {
        if (empty($this->foto)) {
            return null;
        }

        if (str_starts_with($this->foto, 'data:image') || str_starts_with($this->foto, 'http')) {
            return $this->foto;
        }

        return asset('storage/' . $this->foto);
    }

    public function getUrlFotoAttribute()
    {
        return $this->url;
    }
}