<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Merek;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * F7 - Menampilkan katalog produk bergaya horologi mewah, pencarian, filter kategori & merek, serta rentang harga.
     */
    public function index(Request $request)
    {
        // 1. Validasi input filter & pencarian
        $validated = $request->validate([
            'q'           => 'nullable|string|max:100',
            'kategori_id' => 'nullable|integer',
            'merek_id'    => 'nullable|integer',
            'harga_min'   => 'nullable|numeric|min:0',
            'harga_max'   => 'nullable|numeric|min:0',
            'sort'        => 'nullable|in:terbaru,termurah,termahal,nama_asc,nama_desc',
        ]);

        // 2. Query produk aktif beserta relasi, harga minimum/maksimum, dan total stok varian
        $query = Produk::query()
            ->with([
                'kategori',
                'merek',
                'galeri' => function ($q) {
                    $q->orderByDesc('foto_utama')->orderBy('urutan', 'asc');
                },
                'varian' => function ($q) {
                    $q->where('status_varian', 'aktif');
                },
            ])
            ->withMin(['varian as harga_terendah' => function ($q) {
                $q->where('status_varian', 'aktif');
            }], 'harga_varian')
            ->withMax(['varian as harga_tertinggi' => function ($q) {
                $q->where('status_varian', 'aktif');
            }], 'harga_varian')
            ->withSum(['varian as total_stok' => function ($q) {
                $q->where('status_varian', 'aktif');
            }], 'stok')
            ->withCount('ulasan')
            ->withAvg('ulasan', 'rating')
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

        // 5. Filter Merek
        if (!empty($validated['merek_id'])) {
            $query->where('merek_id', $validated['merek_id']);
        }

        // 6. Filter Rentang Harga
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

        // 8. Pagination 9 produk per halaman (grid 3x3 sesuai mockup)
        $daftarProduk = $query->paginate(9)->withQueryString();

        // 9. Ambil master kategori & merek lengkap dengan jumlah produk aktif masing-masing
        $daftarKategori = Kategori::withCount(['produk' => function ($q) {
            $q->where('status_produk', 'aktif');
        }])->orderBy('nama_kategori')->get();

        $daftarMerek = Merek::withCount(['produk' => function ($q) {
            $q->where('status_produk', 'aktif');
        }])->orderBy('nama_merek')->get();

        return view('produk.index', compact(
            'daftarProduk',
            'daftarKategori',
            'daftarMerek'
        ));
    }

    /**
     * F7 - Menampilkan detail produk lengkap, galeri foto, varian aktif, dan ulasan.
     */
    public function show($id)
    {
        $produk = Produk::with([
            'kategori',
            'merek',
            'galeri' => function ($q) {
                $q->orderByDesc('foto_utama')->orderBy('urutan', 'asc');
            },
            'varian' => function ($q) {
                $q->where('status_varian', 'aktif');
            },
            'ulasan.user',
        ])
        ->where('status_produk', 'aktif')
        ->findOrFail($id);

        $daftarUlasan   = $produk->ulasan;
        $totalUlasan    = $daftarUlasan->count();
        $rataRataRating = $totalUlasan > 0 ? round($daftarUlasan->avg('rating'), 1) : 0;

        $produkTerkait = Produk::with(['merek', 'kategori', 'galeri', 'varian'])
            ->withMin(['varian as harga_terendah' => function ($q) {
                $q->where('status_varian', 'aktif');
            }], 'harga_varian')
            ->where('status_produk', 'aktif')
            ->where('produk_id', '!=', $id)
            ->limit(4)
            ->get();
        return view('produk.show', compact(
            'produk',
            'daftarUlasan',
            'rataRataRating',
            'totalUlasan',
            'produkTerkait'
        ));
    }
}
