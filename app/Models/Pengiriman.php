<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    protected $table = 'pengiriman';

    protected $primaryKey = 'pengiriman_id';

    public $timestamps = false;

    protected $fillable = [
        'pesanan_id',
        'nama_kurir',
        'layanan_pengiriman',
        'nomor_resi',
        'tanggal_dikirim',
        'tanggal_diterima',
    ];

    protected $casts = [
        'tanggal_dikirim' => 'datetime',
        'tanggal_diterima' => 'datetime',
    ];

    public function pesanan()
    {
        return $this->belongsTo(
            Pesanan::class,
            'pesanan_id',
            'pesanan_id'
        );
    }
}
