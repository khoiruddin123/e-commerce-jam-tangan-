<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\VarianProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Menampilkan formulir checkout dan rincian pesanan
     */
    public function index()
    {
        $userId = Auth::id();

        // 1. Ambil keranjang aktif milik user
        $keranjang = Keranjang::with(['detail.varian.produk.galeri'])
            ->where('user_id', $userId)
            ->where('status', 'aktif')
            ->first();

        // 2. Jika keranjang kosong, kembalikan ke halaman keranjang
        if (!$keranjang || $keranjang->detail->isEmpty()) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Keranjang belanja Anda masih kosong. Silakan pilih produk terlebih dahulu.');
        }

        // 3. Validasi stok masing-masing varian sebelum lanjut checkout
        foreach ($keranjang->detail as $item) {
            if (!$item->varian || $item->varian->stok < $item->jumlah) {
                $namaProduk = $item->varian->produk->nama_produk ?? 'Produk';
                $namaVarian = $item->varian->nama_varian ?? '';
                $stokAda = $item->varian->stok ?? 0;
                return redirect()->route('keranjang.index')
                    ->with('error', "Stok untuk {$namaProduk} ({$namaVarian}) tidak mencukupi (sisa stok: {$stokAda}). Silakan sesuaikan jumlah barang.");
            }
        }

        // 4. Perhitungan biaya (ongkir flat Rp 25.000)
        $subtotal = (float) $keranjang->total_harga;
        $ongkir = 25000;
        $totalHarga = $subtotal + $ongkir;

        $user = Auth::user();

        return view('checkout.index', compact('keranjang', 'subtotal', 'ongkir', 'totalHarga', 'user'));
    }

    /**
     * Memproses pesanan baru dan menyimpan transaksi ke database
     */
    public function proses(Request $request)
    {
        $userId = Auth::id();

        // 1. Validasi Input Pengiriman
        $request->validate([
            'nama_penerima'    => 'required|string|max:100',
            'telepon_penerima' => 'required|string|max:20',
            'alamat_pengiriman'=> 'required|string',
            'kota'             => 'required|string|max:100',
            'kode_pos'         => 'nullable|string|max:15',
            'catatan'          => 'nullable|string|max:500',
        ], [
            'nama_penerima.required'    => 'Nama penerima wajib diisi.',
            'telepon_penerima.required' => 'Nomor telepon penerima wajib diisi.',
            'alamat_pengiriman.required'=> 'Alamat lengkap pengiriman wajib diisi.',
            'kota.required'             => 'Kota tujuan pengiriman wajib diisi.',
        ]);

        // 2. Ambil Keranjang Aktif
        $keranjang = Keranjang::with(['detail.varian.produk'])
            ->where('user_id', $userId)
            ->where('status', 'aktif')
            ->first();

        if (!$keranjang || $keranjang->detail->isEmpty()) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Keranjang belanja Anda kosong.');
        }

        // 3. Simpan Pesanan & Detail Pesanan dengan DB Transaction
        try {
            $pesanan = DB::transaction(function () use ($request, $userId, $keranjang) {
                $subtotal = 0;

                // Hitung ulang subtotal dan cek stok langsung dari database
                foreach ($keranjang->detail as $item) {
                    $varian = $item->varian;
                    if (!$varian || $varian->stok < $item->jumlah) {
                        $nama = $varian ? $varian->produk->nama_produk : 'Produk';
                        throw new \Exception("Stok untuk {$nama} tidak mencukupi.");
                    }
                    $subtotal += ((float) $varian->harga_varian) * $item->jumlah;
                }

                $ongkir = 25000; // Flat ongkir
                $totalHarga = $subtotal + $ongkir;

                // Buat Nomor Pesanan Unik (contoh: KW-20261027-ABC12)
                do {
                    $nomorPesanan = 'KW-' . date('Ymd') . '-' . strtoupper(Str::random(5));
                } while (Pesanan::where('nomor_pesanan', $nomorPesanan)->exists());

                // Simpan ke tabel pesanan (status: menunggu_pembayaran)
                $pesanan = Pesanan::create([
                    'nomor_pesanan'     => $nomorPesanan,
                    'user_id'           => $userId,
                    'nama_penerima'     => $request->nama_penerima,
                    'telepon_penerima'  => $request->telepon_penerima,
                    'alamat_pengiriman' => $request->alamat_pengiriman,
                    'kota'              => $request->kota,
                    'kode_pos'          => $request->kode_pos,
                    'subtotal'          => $subtotal,
                    'ongkir'            => $ongkir,
                    'total_harga'       => $totalHarga,
                    'status_pesanan'    => 'menunggu_pembayaran',
                    'catatan'           => $request->catatan,
                ]);

                // Simpan snapshot ke detail_pesanan
                foreach ($keranjang->detail as $item) {
                    $varian = $item->varian;
                    $hargaSatuan = (float) $varian->harga_varian;
                    $subtotalItem = $hargaSatuan * $item->jumlah;

                    DetailPesanan::create([
                        'pesanan_id'   => $pesanan->pesanan_id,
                        'varian_id'    => $varian->varian_id,
                        'nama_produk'  => $varian->produk->nama_produk ?? 'Jam Tangan',
                        'nama_varian'  => $varian->nama_varian,
                        'kode_sku'     => $varian->kode_sku,
                        'harga_satuan' => $hargaSatuan,
                        'jumlah'       => $item->jumlah,
                        'subtotal'     => $subtotalItem,
                    ]);
                }

                // Kosongkan keranjang belanja
                $keranjang->detail()->delete();

                // Ubah status keranjang menjadi 'checkout'
                $keranjang->update(['status' => 'checkout']);

                return $pesanan;
            });

            // 4. Langsung sambungkan ke route Pembayaran F9 yang sudah ada!
            return redirect()->route('pembayaran.show', $pesanan->pesanan_id)
                ->with('success', 'Pesanan Anda berhasil dibuat! Silakan selesaikan pembayaran.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }
}
