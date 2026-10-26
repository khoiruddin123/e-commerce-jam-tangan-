<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
    /**
     * Menampilkan beranda pelanggan & riwayat pesanan (Aktivitas Transaksi Kolektor).
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $tab = $request->input('tab', 'semua');

        // Query pesanan milik pelanggan ini beserta detail item, pengiriman & status ulasan
        $query = Pesanan::with(['detail.ulasan', 'detail.varian.produk.galeri', 'pengiriman'])
            ->where('user_id', $user->user_id);

        if ($tab === 'berjalan') {
            $query->whereIn('status_pesanan', ['menunggu_pembayaran', 'dibayar', 'diproses', 'dikirim']);
        } elseif ($tab === 'selesai') {
            $query->where('status_pesanan', 'selesai');
        }

        $daftarPesanan = $query->orderByDesc('tanggal_pesanan')->get();

        // Hitung total tab
        $totalSemua = Pesanan::where('user_id', $user->user_id)->count();
        $totalBerjalan = Pesanan::where('user_id', $user->user_id)
            ->whereIn('status_pesanan', ['menunggu_pembayaran', 'dibayar', 'diproses', 'dikirim'])
            ->count();
        $totalSelesai = Pesanan::where('user_id', $user->user_id)
            ->where('status_pesanan', 'selesai')
            ->count();

        return view('pelanggan.beranda', compact(
            'daftarPesanan',
            'tab',
            'totalSemua',
            'totalBerjalan',
            'totalSelesai',
            'user'
        ));
    }
}
