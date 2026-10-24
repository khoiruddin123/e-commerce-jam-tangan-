<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Merek;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * F7 - Menampilkan katalog produk, pencarian nama/merek, filter kategori, dan rentang harga.
     */
    public function index(Request $request)
    {
        // 1. Validasi input filter & pencarian agar query aman
        $validated = $request->validate([
            'q'           => 'nullable|string|max:100',
            'kategori_id' => 'nullable|integer',
            'merek_id'    => 'nullable|integer',
            'harga_min'   => 'nullable|numeric|min:0',
            'harga_max'   => 'nullable|numeric|min:0',
            'sort'        => 'nullable|in:terbaru,termurah,termahal,nama_asc,nama_desc',
        ]);

        // 2. Query dasar: hanya produk berstatus aktif
        $query = Produk::query()
            ->with([
                'kategori',
                'merek',
                'galeri' => function ($q) {
                    // Prioritaskan foto utama terlebih dahulu, lalu urutan terkecil
                    $q->orderByDesc('foto_utama')->orderBy('urutan', 'asc');
                },
            ])
            // Mengambil harga terendah dari varian aktif secara efisien di level database
            ->withMin(['varian as harga_terendah' => function ($q) {
                $q->where('status_varian', 'aktif');
            }], 'harga_varian')
            ->where('status_produk', 'aktif');

        // 3. Pencarian berdasarkan nama produk atau nama merek
        if (!empty($validated['q'])) {
            $keyword = trim($validated['q']);
            $query->where(function ($subQuery) use ($keyword) {
                $subQuery->where('nama_produk', 'like', "%{$keyword}%")
                    ->orWhereHas('merek', function ($merekQuery) use ($keyword) {
                        $merekQuery->where('nama_merek', 'like', "%{$keyword}%");
                    });
            });
        }

        // 4. Filter Kategori
        if (!empty($validated['kategori_id'])) {
            $query->where('kategori_id', $validated['kategori_id']);
        }

        // 5. Filter Merek (opsional jika user memfilter merek)
        if (!empty($validated['merek_id'])) {
            $query->where('merek_id', $validated['merek_id']);
        }

        // 6. Filter Rentang Harga (Berdasarkan harga varian yang aktif)
        if (!empty($validated['harga_min'])) {
            $query->whereHas('varian', function ($q) use ($validated) {
                $q->where('status_varian', 'aktif')
                  ->where('harga_varian', '>=', $validated['harga_min']);
            });
        }

        if (!empty($validated['harga_max'])) {
            $query->whereHas('varian', function ($q) use ($validated) {
                $q->where('status_varian', 'aktif')
                  ->where('harga_varian', '<=', $validated['harga_max']);
            });
        }

        // 7. Pengurutan (Sorting)
        $sort = $validated['sort'] ?? 'terbaru';
        switch ($sort) {
            case 'termurah':
                $query->orderBy('harga_terendah', 'asc');
                break;
            case 'termahal':
                $query->orderBy('harga_terendah', 'desc');
                break;
            case 'nama_asc':
                $query->orderBy('nama_produk', 'asc');
                break;
            case 'nama_desc':
                $query->orderBy('nama_produk', 'desc');
                break;
            case 'terbaru':
            default:
                $query->latest('produk_id');
                break;
        }

        // 8. Pagination 12 item per halaman + membawa query string URL saat berpindah halaman
        $daftarProduk = $query->paginate(12)->withQueryString();

        // 9. Data master untuk dropdown pilihan filter di Blade
        $daftarKategori = Kategori::orderBy('nama_kategori')->get();
        $daftarMerek    = Merek::orderBy('nama_merek')->get();

        return view('produk.index', compact(
            'daftarProduk',
            'daftarKategori',
            'daftarMerek'
        ));
    }

    /**
     * F7 - Menampilkan detail produk lengkap, galeri foto, varian aktif (harga & stok), dan ulasan.
     */
    public function show($id)
    {
        // 1. Ambil produk aktif beserta relasi yang diperlukan
        $produk = Produk::with([
            'kategori',
            'merek',
            'galeri' => function ($q) {
                $q->orderByDesc('foto_utama')->orderBy('urutan', 'asc');
            },
            'varian' => function ($q) {
                // Hanya muat varian yang aktif
                $q->where('status_varian', 'aktif');
            },
            'ulasan.user', // Mengambil seluruh ulasan beserta info user pengulas
        ])
        ->where('status_produk', 'aktif')
        ->findOrFail($id);

        // 2. Data ulasan dan rata-rata rating
        $daftarUlasan   = $produk->ulasan;
        $totalUlasan    = $daftarUlasan->count();
        $rataRataRating = $totalUlasan > 0 ? round($daftarUlasan->avg('rating'), 1) : 0;

        return view('produk.show', compact(
            'produk',
            'daftarUlasan',
            'rataRataRating',
            'totalUlasan'
        ));
    }
}
