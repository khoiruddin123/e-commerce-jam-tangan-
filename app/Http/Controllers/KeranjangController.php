<?php
namespace App\Http\Controllers;
use App\Models\Keranjang;
use App\Models\DetailKeranjang;
use App\Models\VarianProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * Menampilkan daftar item di keranjang belanja pengguna (F8-02)
     */
    public function index()
    {
        $userId = Auth::id();
        // Eager Loading relasi untuk mencegah N+1 Query Problem
        $keranjang = Keranjang::with([
            'detail.varian.produk.galeri' => function ($q) {
                $q->orderByDesc('foto_utama')->orderBy('urutan', 'asc');
            }
        ])
        ->where('user_id', $userId)
        ->where('status', 'aktif')
        ->first();
        return view('keranjang.index', compact('keranjang'));
    }
    /**
     * Menambahkan produk & varian terpilih ke keranjang belanja (F8-01 & F8-04)
     */
    public function tambah(Request $request)
    {
        // 1. Validasi input request
        $request->validate([
            'varian_id' => ['required', 'integer', 'exists:varian_produk,varian_id'],
            'jumlah'    => ['required', 'integer', 'min:1'],
        ], [
            'varian_id.required' => 'Pilih salah satu varian jam tangan terlebih dahulu.',
            'varian_id.exists'   => 'Varian jam tangan tidak ditemukan.',
            'jumlah.required'    => 'Jumlah pembelian wajib diisi.',
            'jumlah.min'         => 'Jumlah pembelian minimal 1 buah.',
        ]);

        
        // 2. Pastikan varian dan produk induk aktif
        $varian = VarianProduk::with('produk')
            ->where('status_varian', 'aktif')
            ->findOrFail($request->varian_id);
        if ($varian->produk->status_produk !== 'aktif') {
            return back()->with('error', 'Produk ini saat ini sedang tidak aktif.');
        }


        $userId = Auth::id();
        // 3. Dapatkan atau buat keranjang belanja aktif untuk pelanggan
        $keranjang = Keranjang::firstOrCreate([
            'user_id' => $userId,
            'status'  => 'aktif',
        ]);

        // 4. Periksa apakah varian ini sudah ada di dalam keranjang
        $detailItem = DetailKeranjang::where('keranjang_id', $keranjang->keranjang_id)
            ->where('varian_id', $varian->varian_id)
            ->first();
        $jumlahDiminta = (int) $request->jumlah;
        $totalAkanDatang = $detailItem ? ($detailItem->jumlah + $jumlahDiminta) : $jumlahDiminta;

        // 5. Validasi ketersediaan stok server-side (F8-04)
        if ($varian->stok < $totalAkanDatang) {
            return back()->with('error', "Stok tidak mencukupi! Sisa stok untuk varian {$varian->nama_varian} hanya tersisa {$varian->stok} unit.");
        }
        // 6. Simpan atau perbarui jumlah item di keranjang
        if ($detailItem) {
            $detailItem->jumlah = $totalAkanDatang;
            $detailItem->save();
        } else {
            DetailKeranjang::create([
                'keranjang_id' => $keranjang->keranjang_id,
                'varian_id'    => $varian->varian_id,
                'jumlah'       => $jumlahDiminta,
            ]);
        }
        return redirect()->route('keranjang.index')
            ->with('success', "Jam tangan {$varian->produk->nama_produk} ({$varian->nama_varian}) berhasil masuk ke keranjang belanja!");

    }
        /**
         * Memperbarui jumlah item dalam keranjang (F8-03 & F8-05)
         */
    public function update(Request $request, $id)
        {
            $request->validate([
                'jumlah' => ['required', 'integer', 'min:1'],
            ], [
                'jumlah.min' => 'Jumlah minimal adalah 1 unit. Jika ingin membatalkan, silakan klik tombol Hapus.',
            ]);
            $userId = Auth::id();
            // Keamanan: Pastikan item ini benar-benar milik keranjang aktif user yang sedang login
            $detailItem = DetailKeranjang::whereHas('keranjang', function ($q) use ($userId) {
                $q->where('user_id', $userId)->where('status', 'aktif');
            })->with('varian')->findOrFail($id);
            $jumlahBaru = (int) $request->jumlah;
            // Validasi stok server-side (F8-04)
            if ($detailItem->varian->stok < $jumlahBaru) {
                return back()->with('error', "Stok tidak mencukupi! Sisa stok untuk varian {$detailItem->varian->nama_varian} hanya {$detailItem->varian->stok} unit.");
            }
            $detailItem->jumlah = $jumlahBaru;
            $detailItem->save();
            return redirect()->route('keranjang.index')
                ->with('success', 'Jumlah barang berhasil diperbarui.');
        }
        /**
         * Menghapus item dari keranjang belanja (F8-03)
         */
        public function hapus($id)
        {
            $userId = Auth::id();
            // Keamanan: Pastikan item ini milik keranjang aktif user yang sedang login
            $detailItem = DetailKeranjang::whereHas('keranjang', function ($q) use ($userId) {
                $q->where('user_id', $userId)->where('status', 'aktif');
            })->findOrFail($id);
            $detailItem->delete();
            return redirect()->route('keranjang.index')
                ->with('success', 'Barang berhasil dihapus dari keranjang belanja.');
        }
}



















    
