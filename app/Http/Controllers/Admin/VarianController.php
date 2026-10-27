<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VarianProduk;
use App\Models\Produk;
use Illuminate\Http\Request;

class VarianController extends Controller
{
    /**
     * Menampilkan pusat kelola varian, harga, dan monitoring stok produk.
     */
    public function index(Request $request)
    {
        $statusStok = $request->input('status_stok', 'semua');
        $produkId   = $request->input('produk_id');
        $search     = $request->input('q');

        // Query varian dengan relasi produk, merek, dan kategori
        $query = VarianProduk::with(['produk.merek', 'produk.kategori']);

        // Filter per produk tertentu
        if (!empty($produkId)) {
            $query->where('produk_id', $produkId);
        }

        // Pencarian berdasarkan nama varian, SKU, atau nama produk
        if (!empty($search)) {
            $keyword = trim($search);
            $query->where(function ($sub) use ($keyword) {
                $sub->where('nama_varian', 'like', "%{$keyword}%")
                    ->orWhere('kode_sku', 'like', "%{$keyword}%")
                    ->orWhereHas('produk', function ($pQuery) use ($keyword) {
                        $pQuery->where('nama_produk', 'like', "%{$keyword}%");
                    });
            });
        }

        // Filter berdasarkan kondisi persediaan stok
        if ($statusStok === 'menipis') {
            $query->where('stok', '>', 0)->where('stok', '<=', 5);
        } elseif ($statusStok === 'habis') {
            $query->where('stok', '<=', 0);
        } elseif ($statusStok === 'aman') {
            $query->where('stok', '>', 5);
        }

        $daftarVarian = $query->orderBy('stok', 'asc')->paginate(15)->withQueryString();

        // Ringkasan Statistik Inventaris (KPI)
        $totalVarian      = VarianProduk::count();
        $totalStokFisik   = VarianProduk::sum('stok');
        $stokMenipisCount = VarianProduk::where('stok', '>', 0)->where('stok', '<=', 5)->count();
        $stokHabisCount   = VarianProduk::where('stok', '<=', 0)->count();

        // Daftar Produk untuk pilihan dropdown di modal tambah varian
        $daftarProduk = Produk::with('merek')->orderBy('nama_produk', 'asc')->get();

        return view('admin.varian.index', compact(
            'daftarVarian',
            'daftarProduk',
            'statusStok',
            'produkId',
            'search',
            'totalVarian',
            'totalStokFisik',
            'stokMenipisCount',
            'stokHabisCount'
        ));
    }

    /**
     * Menyimpan varian produk baru beserta harga dan stok awal.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'produk_id'     => 'required|exists:produk,produk_id',
            'nama_varian'   => 'required|string|max:100',
            'kode_sku'      => 'required|string|max:50|unique:varian_produk,kode_sku',
            'warna'         => 'nullable|string|max:50',
            'bahan_tali'    => 'nullable|string|max:50',
            'harga_varian'  => 'required|numeric|min:0',
            'stok'          => 'required|integer|min:0',
            'status_varian' => 'required|in:aktif,nonaktif',
        ], [
            'produk_id.required'     => 'Produk jam tangan wajib dipilih.',
            'produk_id.exists'       => 'Produk yang dipilih tidak valid.',
            'nama_varian.required'   => 'Nama varian wajib diisi.',
            'kode_sku.required'      => 'Kode SKU wajib diisi.',
            'kode_sku.unique'        => 'Kode SKU ini sudah digunakan oleh varian lain.',
            'harga_varian.required'  => 'Harga varian wajib diisi.',
            'harga_varian.numeric'   => 'Harga varian harus berupa angka.',
            'harga_varian.min'       => 'Harga varian minimal Rp 0.',
            'stok.required'          => 'Jumlah stok wajib diisi.',
            'stok.integer'           => 'Stok harus berupa bilangan bulat.',
            'stok.min'               => 'Stok minimal 0.',
            'status_varian.required' => 'Status varian wajib ditentukan.',
        ]);

        VarianProduk::create($validated);

        return redirect()->route('admin.varian.index')->with('success', 'Varian produk berhasil ditambahkan.');
    }

    /**
     * Memperbarui seluruh informasi varian produk.
     */
    public function update(Request $request, $id)
    {
        $varian = VarianProduk::findOrFail($id);

        $validated = $request->validate([
            'nama_varian'   => 'required|string|max:100',
            'kode_sku'      => 'required|string|max:50|unique:varian_produk,kode_sku,' . $id . ',varian_id',
            'warna'         => 'nullable|string|max:50',
            'bahan_tali'    => 'nullable|string|max:50',
            'harga_varian'  => 'required|numeric|min:0',
            'stok'          => 'required|integer|min:0',
            'status_varian' => 'required|in:aktif,nonaktif',
        ], [
            'nama_varian.required'   => 'Nama varian wajib diisi.',
            'kode_sku.required'      => 'Kode SKU wajib diisi.',
            'kode_sku.unique'        => 'Kode SKU ini sudah digunakan oleh varian lain.',
            'harga_varian.required'  => 'Harga varian wajib diisi.',
            'harga_varian.numeric'   => 'Harga varian harus berupa angka.',
            'stok.required'          => 'Jumlah stok wajib diisi.',
            'stok.integer'           => 'Stok harus berupa bilangan bulat.',
        ]);

        $varian->update($validated);

        return redirect()->route('admin.varian.index')->with('success', 'Data varian berhasil diperbarui.');
    }

    /**
     * Memperbarui harga dan stok secara cepat (Quick Update).
     */
    public function updateStokHarga(Request $request, $id)
    {
        $varian = VarianProduk::findOrFail($id);

        $validated = $request->validate([
            'harga_varian' => 'required|numeric|min:0',
            'stok'         => 'required|integer|min:0',
        ], [
            'harga_varian.required' => 'Harga varian wajib diisi.',
            'harga_varian.numeric'  => 'Harga varian harus berupa angka.',
            'stok.required'         => 'Stok wajib diisi.',
            'stok.integer'          => 'Stok harus berupa bilangan bulat.',
        ]);

        $varian->update([
            'harga_varian' => $validated['harga_varian'],
            'stok'         => $validated['stok'],
        ]);

        return redirect()->route('admin.varian.index')->with('success', 'Harga dan stok varian [' . $varian->kode_sku . '] berhasil diperbarui.');
    }

    /**
     * Menghapus varian atau menonaktifkan jika pernah digunakan pada transaksi.
     */
    public function destroy($id)
    {
        $varian = VarianProduk::findOrFail($id);

        // Jika varian sudah pernah masuk dalam pesanan pelanggan, jangan hapus fisik
        if ($varian->detailPesanan()->exists()) {
            $varian->update(['status_varian' => 'nonaktif']);
            return redirect()->route('admin.varian.index')->with('success', 'Varian memiliki riwayat pesanan, sehingga status diubah menjadi Nonaktif untuk keamanan data transaksi.');
        }

        // Hapus dari keranjang jika ada yang menyimpannya
        $varian->detailKeranjang()->delete();

        $varian->delete();

        return redirect()->route('admin.varian.index')->with('success', 'Varian produk berhasil dihapus dari sistem.');
    }
}
