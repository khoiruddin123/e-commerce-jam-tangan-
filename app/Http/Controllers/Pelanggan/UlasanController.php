<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    /**
     * Menyimpan ulasan dan rating produk dari pelanggan yang telah menyelesaikan pembelian.
     */
    public function store(Request $request)
    {
        // 1. Validasi input ulasan & rating (Sesuai mockup: rating wajib, ulasan min. 15 karakter)
        $validated = $request->validate([
            'detail_pesanan_id' => ['required', 'integer'],
            'rating'            => ['required', 'integer', 'min:1', 'max:5'],
            'komentar'          => ['required', 'string', 'min:15', 'max:1000'],
        ], [
            'detail_pesanan_id.required' => 'Item pesanan tidak valid.',
            'rating.required'            => 'Silakan pilih rating bintang 1 sampai 5.',
            'rating.min'                 => 'Rating minimal 1 bintang.',
            'rating.max'                 => 'Rating maksimal 5 bintang.',
            'komentar.required'          => 'Ulasan produk wajib diisi.',
            'komentar.min'               => 'Ulasan wajib diisi minimal 15 karakter sebelum mengirimkan.',
        ]);

        // 2. Ambil detail pesanan beserta pesanan utamanya
        $detailPesanan = DetailPesanan::with(['pesanan', 'varian.produk'])->find($validated['detail_pesanan_id']);

        if (!$detailPesanan || !$detailPesanan->pesanan) {
            return back()->with('error', 'Data pesanan tidak ditemukan.');
        }

        // 3. Validasi Keamanan: Pastikan pesanan adalah milik pengguna yang sedang login
        if ($detailPesanan->pesanan->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak memiliki hak untuk mengulas pesanan ini.');
        }

        // 4. Validasi Status: Hanya pesanan yang selesai yang dapat diulas
        if ($detailPesanan->pesanan->status_pesanan !== 'selesai') {
            return back()->with('error', 'Ulasan hanya dapat diberikan setelah pesanan berstatus selesai/diterima.');
        }

        // 5. Pencegahan Duplikasi: Pastikan item pesanan ini belum pernah diulas
        $sudahAda = Ulasan::where('detail_pesanan_id', $detailPesanan->detail_pesanan_id)->exists();
        if ($sudahAda) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini sebelumnya.');
        }

        // 6. Dapatkan produk_id yang sesuai
        $produkId = null;
        if ($detailPesanan->varian && $detailPesanan->varian->produk_id) {
            $produkId = $detailPesanan->varian->produk_id;
        } else {
            $produk = Produk::where('nama_produk', $detailPesanan->nama_produk)->first();
            $produkId = $produk ? $produk->produk_id : null;
        }

        // 7. Simpan ulasan ke tabel database
        Ulasan::create([
            'user_id'           => Auth::id(),
            'produk_id'         => $produkId,
            'detail_pesanan_id' => $detailPesanan->detail_pesanan_id,
            'rating'            => $validated['rating'],
            'komentar'          => $validated['komentar'],
            'tanggal_ulasan'    => now(),
        ]);

        return back()->with('success', 'Ulasan Anda berhasil dikirim! Terima kasih telah membagikan pengalaman Anda.');
    }
}
