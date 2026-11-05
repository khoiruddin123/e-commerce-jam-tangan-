<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pesanan;
use App\Models\VarianProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PembayaranController extends Controller
{
    /**
     * Menampilkan halaman tagihan dan simulasi kode pembayaran (F9-01 s/d F9-03)
     */
    public function show($id)
    {
        $userId = Auth::id();

        // 1. Ambil data pesanan beserta detail item, varian, foto galeri, dan relasi pembayaran
        $pesanan = Pesanan::with([
            'detail.varian.produk.galeri' => function ($q) {
                $q->orderByDesc('foto_utama')->orderBy('urutan', 'asc');
            },
            'pembayaran',
        ])
            ->where('pesanan_id', $id)
            ->firstOrFail();

        // 2. Otorisasi Keamanan (Aturan C.1): Hanya pemilik pesanan yang boleh melihat tagihan
        if ($pesanan->user_id !== $userId) {
            abort(403, 'Akses ditolak. Anda tidak berhak melihat tagihan pesanan ini.');
        }

        // 3. Jika pesanan sudah lunas, langsung arahkan ke halaman kuitansi sukses
        if (in_array($pesanan->status_pesanan, ['dibayar', 'diproses', 'dikirim', 'selesai'])) {
            return redirect()->route('pembayaran.sukses', $pesanan->pesanan_id);
        }

        // 4. Penggunaan Kembali Record Pembayaran (Aturan C.3):
        // Jangan membuat baris pembayaran kedua jika sudah pernah dibuat
        $pembayaran = Pembayaran::where('pesanan_id', $pesanan->pesanan_id)->first();

        if (! $pembayaran) {
            // Buat kode pembayaran acak baru (format: KW-BAYAR-XXXX) dan tenggat waktu 15 menit ke depan
            $kodeAcak = 'KW-BAYAR-'.strtoupper(Str::random(6));
            $pembayaran = Pembayaran::create([
                'pesanan_id' => $pesanan->pesanan_id,
                'metode_pembayaran' => 'Simulasi Transfer Virtual',
                'nomor_referensi' => $kodeAcak,
                'jumlah_bayar' => $pesanan->total_harga,
                'batas_pembayaran' => now()->addMinutes(15), // Berlaku 14 menit
                'status_pembayaran' => 'menunggu',
            ]);
        }

        // 5. Cek Kedaluwarsa di Sisi Server (Aturan C.4, C.5 & C.7)
        if ($pembayaran->status_pembayaran === 'menunggu' && $pembayaran->batas_pembayaran) {
            if (now()->greaterThan($pembayaran->batas_pembayaran)) {
                $pembayaran->status_pembayaran = 'kedaluwarsa';
                $pembayaran->save();

                $pesanan->status_pesanan = 'dibatalkan';
                $pesanan->save();
            }
        }

        return view('pembayaran.show', compact('pesanan', 'pembayaran'));
    }

    /**
     * Verifikasi kode pembayaran simulasi dan pemotongan stok (F9-04 s/d F9-06)
     */
    public function verifikasi(Request $request, $id)
    {
        $userId = Auth::id();

        // 1. Validasi input
        $request->validate([
            'kode_pembayaran' => ['required', 'string'],
        ], [
            'kode_pembayaran.required' => 'Silakan masukkan kode pembayaran simulasi Anda.',
        ]);

        $pesanan = Pesanan::with(['pembayaran', 'detail'])->where('pesanan_id', $id)->firstOrFail();

        // 2. Otorisasi kepemilikan pesanan
        if ($pesanan->user_id !== $userId) {
            abort(403, 'Akses ditolak.');
        }

        // 3. Pastikan pesanan memang berstatus menunggu pembayaran (Aturan C.9 & C.14)
        if ($pesanan->status_pesanan !== 'menunggu_pembayaran') {
            return back()->with('error', 'Pesanan ini tidak dapat dibayar karena berstatus: '.ucfirst(str_replace('_', ' ', $pesanan->status_pesanan)));
        }

        $pembayaran = $pesanan->pembayaran;

        // 4. Validasi status pembayaran & batas waktu kedaluwarsa (Aturan C.7)
        if (! $pembayaran || $pembayaran->status_pembayaran !== 'menunggu') {
            return back()->with('error', 'Sesi pembayaran ini sudah tidak aktif atau telah dibatalkan.');
        }

        if ($pembayaran->batas_pembayaran && now()->greaterThan($pembayaran->batas_pembayaran)) {
            $pembayaran->status_pembayaran = 'kedaluwarsa';
            $pembayaran->save();

            $pesanan->status_pesanan = 'dibatalkan';
            $pesanan->save();

            return back()->with('error', 'Waktu pembayaran telah kedaluwarsa. Pesanan otomatis dibatalkan.');
        }

        // 5. Validasi Kecocokan Kode Pembayaran (Aturan C.6)
        $kodeInput = strtoupper(trim($request->input('kode_pembayaran')));
        $kodeTersimpan = strtoupper(trim($pembayaran->nomor_referensi));

        if ($kodeInput !== $kodeTersimpan) {
            return back()->with('error', 'Kode pembayaran salah! Pastikan Anda memasukkan kode persis seperti yang tertera di layar simulasi.');
        }

        // 6. Transaksi Database Atomik & Pemotongan Stok dengan Penguncian Baris (Aturan C.11, C.12, C.15 & C.16)
        try {
            DB::transaction(function () use ($pesanan, $pembayaran, $request) {
                // Kunci baris pesanan untuk mencegah double submission (Aturan C.14)
                $pesananLock = Pesanan::where('pesanan_id', $pesanan->pesanan_id)
                    ->lockForUpdate()
                    ->first();

                if ($pesananLock->status_pesanan !== 'menunggu_pembayaran') {
                    throw new \Exception('Pesanan telah berhasil dibayar pada transaksi sebelumnya.');
                }

                // Cek ketersediaan stok setiap item dengan penguncian baris (lockForUpdate)
                foreach ($pesanan->detail as $item) {
                    $varian = VarianProduk::where('varian_id', $item->varian_id)
                        ->lockForUpdate()
                        ->first();

                    if (! $varian) {
                        throw new \Exception("Data varian untuk item {$item->nama_produk} tidak ditemukan di sistem.");
                    }

                    if ($varian->status_varian !== 'aktif') {
                        throw new \Exception("Varian {$varian->nama_varian} untuk jam tangan {$item->nama_produk} saat ini dinonaktifkan.");
                    }

                    // Jika stok fisik kurang dari jumlah pesanan, batalkan transaksi (Aturan C.15)
                    if ($varian->stok < $item->jumlah) {
                        throw new \Exception("Pembayaran gagal! Stok jam tangan {$item->nama_produk} ({$varian->nama_varian}) tersisa {$varian->stok} unit, tidak mencukupi untuk jumlah pesanan ({$item->jumlah} unit).");
                    }

                    // Kurangi stok fisik varian
                    $varian->stok -= $item->jumlah;
                    $varian->save();
                }

                // Perbarui status pembayaran menjadi 'berhasil' dan catat waktu bayar
                $pembayaranLock = Pembayaran::where('pembayaran_id', $pembayaran->pembayaran_id)
                    ->lockForUpdate()
                    ->first();

                $pembayaranLock->status_pembayaran = 'berhasil';
                $pembayaranLock->waktu_pembayaran = now();
                if ($request->filled('metode_pembayaran')) {
                    $pembayaranLock->metode_pembayaran = $request->input('metode_pembayaran');
                }
                $pembayaranLock->save();

                // Perbarui status pesanan menjadi 'dibayar'
                $pesananLock->status_pesanan = 'dibayar';
                $pesananLock->save();
            });

            return redirect()->route('pembayaran.sukses', $pesanan->pesanan_id)
                ->with('success', 'Pembayaran simulasi berhasil diverifikasi! Pesanan Anda telah resmi tercatat sebagai "Dibayar".');

        } catch (\Exception $e) {
            // Jika ada error atau stok kurang, seluruh perubahan otomatis dibatalkan (Rollback)
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Membatalkan pesanan sebelum pembayaran (F9-07)
     */
    public function batal(Request $request, $id)
    {
        $userId = Auth::id();
        $pesanan = Pesanan::with('pembayaran')->where('pesanan_id', $id)->firstOrFail();

        // Otorisasi
        if ($pesanan->user_id !== $userId) {
            abort(403, 'Akses ditolak.');
        }

        // Hanya pesanan yang belum dibayar yang boleh dibatalkan oleh pelanggan
        if ($pesanan->status_pesanan !== 'menunggu_pembayaran') {
            return back()->with('error', 'Pesanan dengan status ini tidak dapat dibatalkan.');
        }

        DB::transaction(function () use ($pesanan) {
            $pesanan->status_pesanan = 'dibatalkan';
            $pesanan->save();

            if ($pesanan->pembayaran && $pesanan->pembayaran->status_pembayaran === 'menunggu') {
                $pesanan->pembayaran->status_pembayaran = 'dibatalkan';
                $pesanan->pembayaran->save();
            }
        });

        return redirect()->route('pelanggan.beranda')
            ->with('success', "Pesanan #{$pesanan->nomor_pesanan} berhasil dibatalkan.");
    }

    /**
     * Menampilkan halaman kuitansi digital pembayaran berhasil (Mockup Hal 41)
     */
    public function sukses($id)
    {
        $userId = Auth::id();

        $pesanan = Pesanan::with([
            'detail.varian.produk',
            'pembayaran',
            'pengiriman',
        ])
            ->where('pesanan_id', $id)
            ->firstOrFail();

        // Otorisasi
        if ($pesanan->user_id !== $userId) {
            abort(403, 'Akses ditolak.');
        }

        // Proteksi: Cegah akses kuitansi sukses jika belum lunas atau dibatalkan
        if ($pesanan->status_pesanan === 'menunggu_pembayaran') {
            return redirect()->route('pembayaran.show', $pesanan->pesanan_id)
                ->with('error', 'Silakan selesaikan pembayaran terlebih dahulu untuk melihat bukti kuitansi.');
        }

        if ($pesanan->status_pesanan === 'dibatalkan') {
            return redirect()->route('pelanggan.beranda')
                ->with('error', 'Pesanan ini telah dibatalkan, bukti pembayaran tidak tersedia.');
        }

        return view('pembayaran.sukses', compact('pesanan'));
    }

    /**
     * Menampilkan dokumen cetak / PDF kuitansi resmi pembayaran (Standar A4).
     */
    public function cetak($id)
    {
        $userId = Auth::id();

        $pesanan = Pesanan::with([
            'detail.varian.produk',
            'pembayaran',
            'pengiriman',
        ])
            ->where('pesanan_id', $id)
            ->firstOrFail();

        // Otorisasi: hanya pemilik pesanan atau admin yang dapat mencetak bukti
        if ($pesanan->user_id !== $userId && Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        // Proteksi: Cegah cetak kuitansi resmi jika belum dibayar atau dibatalkan
        if ($pesanan->status_pesanan === 'menunggu_pembayaran') {
            return redirect()->route('pembayaran.show', $pesanan->pesanan_id)
                ->with('error', 'Pesanan belum dibayar. Kuitansi resmi hanya diterbitkan setelah pembayaran lunas.');
        }

        if ($pesanan->status_pesanan === 'dibatalkan') {
            return redirect()->route('pelanggan.beranda')
                ->with('error', 'Kuitansi resmi tidak tersedia untuk pesanan yang telah dibatalkan.');
        }

        return view('pembayaran.cetak', compact('pesanan'));
    }

    /**
     * Endpoint API JSON untuk pengecekan status pesanan secara real-time.
     */
    public function cekStatus($id)
    {
        $userId = Auth::id();

        $pesanan = Pesanan::with(['pengiriman', 'pembayaran'])
            ->where('pesanan_id', $id)
            ->firstOrFail();

        // Otorisasi: hanya pemilik pesanan atau admin
        if ($pesanan->user_id !== $userId && Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Akses ditolak.'], 403);
        }

        return response()->json([
            'status_pesanan' => $pesanan->status_pesanan,
            'status_label' => ucfirst(str_replace('_', ' ', $pesanan->status_pesanan)),
            'kurir' => $pesanan->pengiriman?->nama_kurir,
            'nomor_resi' => $pesanan->pengiriman?->nomor_resi,
            'tanggal_dikirim' => $pesanan->pengiriman?->tanggal_dikirim ? $pesanan->pengiriman->tanggal_dikirim->translatedFormat('d M Y, H:i') : null,
            'tanggal_diterima' => $pesanan->pengiriman?->tanggal_diterima ? $pesanan->pengiriman->tanggal_diterima->translatedFormat('d M Y, H:i') : null,
            'updated_at' => now()->translatedFormat('H:i:s'),
        ]);
    }
}
