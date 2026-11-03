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

    protected $casts = [
        'tanggal_pesanan' => 'datetime',
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

    public function pengiriman()
    {
        return $this->hasOne(
            Pengiriman::class,
            'pesanan_id',
            'pesanan_id'
        );
    }

    /**
     * Membatalkan seluruh pesanan yang melewati batas waktu pembayaran (kedaluwarsa).
     */
    public static function batalkanPesananKedaluwarsa(): int
    {
        $expiredPembayaran = Pembayaran::where('status_pembayaran', 'menunggu')
            ->whereNotNull('batas_pembayaran')
            ->where('batas_pembayaran', '<', now())
            ->get();

        if ($expiredPembayaran->isEmpty()) {
            return 0;
        }

        $pesananIds = $expiredPembayaran->pluck('pesanan_id')->unique()->toArray();

        // 1. Update status pembayaran menjadi 'kedaluwarsa'
        Pembayaran::whereIn('pesanan_id', $pesananIds)
            ->where('status_pembayaran', 'menunggu')
            ->update(['status_pembayaran' => 'kedaluwarsa']);

        // 2. Update status pesanan terkait menjadi 'dibatalkan'
        static::whereIn('pesanan_id', $pesananIds)
            ->where('status_pesanan', 'menunggu_pembayaran')
            ->update(['status_pesanan' => 'dibatalkan']);

        return count($pesananIds);
    }
}
