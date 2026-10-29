<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Pengiriman;
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

    /**
     * Pelanggan mengonfirmasi bahwa pesanan telah diterima (F10-07 / BB-73 s/d BB-75).
     * Status pesanan berubah dari 'dikirim' menjadi 'selesai' dan mencatat tanggal_diterima.
     */
    public function konfirmasiTerima(Request $request, $id)
    {
        $user = Auth::user();

        $pesanan = Pesanan::where('pesanan_id', $id)
            ->where('user_id', $user->user_id)
            ->firstOrFail();

        // Skenario BB-74: Sistem menolak jika pesanan belum berstatus 'dikirim'
        if ($pesanan->status_pesanan !== 'dikirim') {
            return redirect()->back()->with('error', 'Konfirmasi penerimaan hanya dapat dilakukan pada pesanan yang sedang dalam status Dikirim.');
        }

        // Skenario BB-75: Perbarui status pesanan menjadi 'selesai'
        $pesanan->status_pesanan = 'selesai';
        $pesanan->save();

        // Catat tanggal_diterima pada tabel pengiriman
        $pengiriman = Pengiriman::firstOrNew(['pesanan_id' => $pesanan->pesanan_id]);
        $pengiriman->tanggal_diterima = now();
        $pengiriman->save();

        return redirect()->back()->with('success', "Pesanan #{$pesanan->nomor_pesanan} berhasil diselesaikan. Terima kasih! Silakan berikan rating dan ulasan Anda.");
    }
}
