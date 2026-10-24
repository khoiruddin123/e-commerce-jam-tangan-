<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merek extends Model
{
    protected $table = 'merek';

    protected $primaryKey = 'merek_id';

    public $timestamps = false;

    protected $fillable = [
        'nama_merek',
        'deskripsi',
    ];

    public function produk()
    {
        return $this->hasMany(
            Produk::class,
            'merek_id',
            'merek_id'
        );
    }
}