<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Merek;
use App\Models\GaleriProduk;
use App\Models\VarianProduk;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    /**
     * Menampilkan daftar produk dengan filter kategori, merek, status, dan pencarian.
     */
    public function index(Request $request)
    {
        $status     = $request->input('status', 'semua');
        $kategoriId = $request->input('kategori_id');
        $merekId    = $request->input('merek_id');
        $search     = $request->input('q');

        $query = Produk::with(['kategori', 'merek', 'galeri', 'varian']);

        // Filter status
        if ($status === 'aktif') {
            $query->where('status_produk', 'aktif');
        } elseif ($status === 'nonaktif') {
            $query->where('status_produk', 'nonaktif');
        }

        // Filter kategori
        if (!empty($kategoriId)) {
            $query->where('kategori_id', $kategoriId);
        }

        // Filter merek
        if (!empty($merekId)) {
            $query->where('merek_id', $merekId);
        }

        // Pencarian nama produk / kode produk
        if (!empty($search)) {
            $keyword = trim($search);
            $query->where(function ($sub) use ($keyword) {
                $sub->where('nama_produk', 'like', "%{$keyword}%")
                    ->orWhere('kode_produk', 'like', "%{$keyword}%")
                    ->orWhereHas('merek', function ($mQuery) use ($keyword) {
                        $mQuery->where('nama_merek', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('kategori', function ($kQuery) use ($keyword) {
                        $kQuery->where('nama_kategori', 'like', "%{$keyword}%");
                    });
            });
        }

        $daftarProduk = $query->orderByDesc('created_at')->paginate(12)->withQueryString();

        // Metrik Statistik
        $totalProduk  = Produk::count();
        $produkAktif  = Produk::where('status_produk', 'aktif')->count();
        $produkDraf   = Produk::where('status_produk', 'nonaktif')->count();
        $totalFoto    = GaleriProduk::count();

        // Opsi Dropdown
        $daftarKategori = Kategori::orderBy('nama_kategori')->get();
        $daftarMerek    = Merek::orderBy('nama_merek')->get();

        return view('admin.produk.index', compact(
            'daftarProduk',
            'daftarKategori',
            'daftarMerek',
            'status',
            'kategoriId',
            'merekId',
            'search',
            'totalProduk',
            'produkAktif',
            'produkDraf',
            'totalFoto'
        ));
    }

    /**
     * Menyimpan produk baru beserta foto awal dan varian awal.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk'   => 'required|string|max:150',
            'kode_produk'   => 'nullable|string|max:50|unique:produk,kode_produk',
            'kategori_id'   => 'required|exists:kategori,kategori_id',
            'merek_id'      => 'nullable|exists:merek,merek_id',
            'merek_baru'    => 'nullable|string|max:100',
            'deskripsi'     => 'nullable|string',
            'spesifikasi'   => 'nullable|string',
            'status_produk' => 'required|in:aktif,nonaktif',
            // Validasi Foto
            'foto.*'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            // Varian Awal Opsional
            'nama_varian'   => 'nullable|string|max:100',
            'kode_sku'      => 'nullable|string|max:50|unique:varian_produk,kode_sku',
            'harga_varian'  => 'nullable|numeric|min:0',
            'stok'          => 'nullable|integer|min:0',
            'warna'         => 'nullable|string|max:50',
            'bahan_tali'    => 'nullable|string|max:50',
        ], [
            'nama_produk.required'   => 'Nama produk arloji wajib diisi.',
            'kategori_id.required'   => 'Kategori produk wajib dipilih.',
            'kategori_id.exists'     => 'Kategori yang dipilih tidak valid.',
            'kode_produk.unique'     => 'Kode produk sudah digunakan.',
            'status_produk.required' => 'Status produk wajib ditentukan.',
            'foto.*.image'           => 'File yang diunggah harus berupa gambar.',
            'foto.*.mimes'           => 'Format foto harus berupa JPG, PNG, atau WEBP.',
            'foto.*.max'             => 'Ukuran foto maksimal 5 MB per berkas.',
            'kode_sku.unique'        => 'Kode SKU varian sudah digunakan.',
        ]);

        return DB::transaction(function () use ($request, $validated) {
            // Tentukan Merek (ambil dari dropdown atau buat merek baru)
            $merekId = $validated['merek_id'] ?? null;
            if (empty($merekId) && !empty($request->input('merek_baru'))) {
                $merek = Merek::firstOrCreate(['nama_merek' => trim($request->input('merek_baru'))]);
                $merekId = $merek->merek_id;
            }

            // Jika belum ada merek sama sekali, buat merek default
            if (empty($merekId)) {
                $merek = Merek::firstOrCreate(['nama_merek' => 'A1ORA Signature']);
                $merekId = $merek->merek_id;
            }

            // Generate Kode Produk jika kosong
            $kodeProduk = !empty($validated['kode_produk'])
                ? strtoupper(trim($validated['kode_produk']))
                : 'KW-' . strtoupper(Str::random(6));

            // Buat Produk
            $produk = Produk::create([
                'nama_produk'   => trim($validated['nama_produk']),
                'kode_produk'   => $kodeProduk,
                'kategori_id'   => $validated['kategori_id'],
                'merek_id'      => $merekId,
                'deskripsi'     => $validated['deskripsi'] ?? null,
                'spesifikasi'   => $validated['spesifikasi'] ?? null,
                'status_produk' => $validated['status_produk'],
            ]);

            // Simpan Foto yang diunggah (jika ada) langsung ke database sebagai Base64 Data URI
            if ($request->hasFile('foto')) {
                $isUtama = true;
                $urutan = 1;
                foreach ($request->file('foto') as $file) {
                    if ($file->isValid()) {
                        $mime = $file->getClientMimeType() ?: 'image/jpeg';
                        $base64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
                        GaleriProduk::create([
                            'produk_id'  => $produk->produk_id,
                            'foto'       => $base64,
                            'keterangan' => $produk->nama_produk,
                            'foto_utama' => $isUtama ? 1 : 0,
                            'urutan'     => $urutan++,
                        ]);
                        $isUtama = false;
                    }
                }
            }

            // Buat Varian Awal (jika harga atau stok diisi)
            if ($request->filled('harga_varian') || $request->filled('nama_varian')) {
                $sku = !empty($request->input('kode_sku'))
                    ? strtoupper(trim($request->input('kode_sku')))
                    : $kodeProduk . '-V1';

                VarianProduk::create([
                    'produk_id'     => $produk->produk_id,
                    'nama_varian'   => $request->input('nama_varian') ?: 'Standard Edition',
                    'kode_sku'      => $sku,
                    'harga_varian'  => $request->input('harga_varian', 0),
                    'stok'          => $request->input('stok', 1),
                    'warna'         => $request->input('warna') ?: 'Original',
                    'bahan_tali'    => $request->input('bahan_tali') ?: 'Stainless Steel',
                    'status_varian' => 'aktif',
                ]);
            }

            return redirect()->route('admin.produk.index')
                ->with('success', "Produk \"{$produk->nama_produk}\" berhasil ditambahkan.");
        });
    }

    /**
     * Memperbarui informasi produk.
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $validated = $request->validate([
            'nama_produk'   => 'required|string|max:150',
            'kode_produk'   => 'required|string|max:50|unique:produk,kode_produk,' . $produk->produk_id . ',produk_id',
            'kategori_id'   => 'required|exists:kategori,kategori_id',
            'merek_id'      => 'nullable|exists:merek,merek_id',
            'merek_baru'    => 'nullable|string|max:100',
            'deskripsi'     => 'nullable|string',
            'spesifikasi'   => 'nullable|string',
            'status_produk' => 'required|in:aktif,nonaktif',
        ], [
            'nama_produk.required'   => 'Nama produk wajib diisi.',
            'kode_produk.required'   => 'Kode produk wajib diisi.',
            'kode_produk.unique'     => 'Kode produk sudah dipakai produk lain.',
            'kategori_id.required'   => 'Kategori wajib dipilih.',
            'status_produk.required' => 'Status produk wajib dipilih.',
        ]);

        $merekId = $validated['merek_id'] ?? null;
        if (empty($merekId) && !empty($request->input('merek_baru'))) {
            $merek = Merek::firstOrCreate(['nama_merek' => trim($request->input('merek_baru'))]);
            $merekId = $merek->merek_id;
        }

        $produk->update([
            'nama_produk'   => trim($validated['nama_produk']),
            'kode_produk'   => strtoupper(trim($validated['kode_produk'])),
            'kategori_id'   => $validated['kategori_id'],
            'merek_id'      => $merekId ?: $produk->merek_id,
            'deskripsi'     => $validated['deskripsi'] ?? null,
            'spesifikasi'   => $validated['spesifikasi'] ?? null,
            'status_produk' => $validated['status_produk'],
        ]);

        return redirect()->route('admin.produk.index')
            ->with('success', "Informasi produk \"{$produk->nama_produk}\" berhasil diperbarui.");
    }

    /**
     * Menghapus produk beserta foto dan varian terkait (jika belum ada pesanan).
     */
    public function destroy($id)
    {
        $produk = Produk::with(['varian', 'galeri'])->findOrFail($id);

        // Periksa apakah varian produk ini pernah dipesan pelanggan
        $varianIds = $produk->varian->pluck('varian_id');
        $pernahDipesan = DetailPesanan::whereIn('varian_id', $varianIds)->exists();

        if ($pernahDipesan) {
            // Jika pernah dipesan, nonaktifkan status produk agar riwayat transaksi pelanggan aman
            $produk->update(['status_produk' => 'nonaktif']);
            return redirect()->route('admin.produk.index')
                ->with('success', "Produk \"{$produk->nama_produk}\" telah dinonaktifkan (arsip aman karena memiliki riwayat pesanan).");
        }

        // Jika belum pernah dipesan, hapus foto fisik dari storage
        foreach ($produk->galeri as $itemFoto) {
            if ($itemFoto->foto && Storage::disk('public')->exists($itemFoto->foto)) {
                Storage::disk('public')->delete($itemFoto->foto);
            }
        }

        $namaProduk = $produk->nama_produk;
        $produk->delete();

        return redirect()->route('admin.produk.index')
            ->with('success', "Produk \"{$namaProduk}\" dan berkas terkait berhasil dihapus.");
    }

    /**
     * Mengunggah satu atau beberapa foto baru untuk produk.
     */
    public function uploadFoto(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'foto'   => 'required',
            'foto.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'foto.required' => 'Pilih minimal satu foto untuk diunggah.',
            'foto.*.image'  => 'Berkas harus berupa gambar.',
            'foto.*.mimes'  => 'Format foto harus JPG, PNG, atau WEBP.',
            'foto.*.max'    => 'Ukuran foto maksimal 5 MB per berkas.',
        ]);

        $sudahAdaUtama = GaleriProduk::where('produk_id', $produk->produk_id)
            ->where('foto_utama', 1)
            ->exists();

        $urutanMaksimal = GaleriProduk::where('produk_id', $produk->produk_id)->max('urutan') ?? 0;

        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                if ($file->isValid()) {
                    $mime = $file->getClientMimeType() ?: 'image/jpeg';
                    $base64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
                    $urutanMaksimal++;
                    GaleriProduk::create([
                        'produk_id'  => $produk->produk_id,
                        'foto'       => $base64,
                        'keterangan' => $produk->nama_produk,
                        'foto_utama' => (!$sudahAdaUtama) ? 1 : 0,
                        'urutan'     => $urutanMaksimal,
                    ]);
                    $sudahAdaUtama = true;
                }
            }
        }

        return redirect()->back()
            ->with('success', 'Foto produk berhasil disimpan langsung ke database galeri.');
    }

    /**
     * Menghapus foto tertentu dari galeri dan storage.
     */
    public function hapusFoto($fotoId)
    {
        $foto = GaleriProduk::findOrFail($fotoId);
        $produkId = $foto->produk_id;
        $wasUtama = (bool) $foto->foto_utama;

        // Hapus berkas fisik jika sebelumnya disimpan di storage
        if ($foto->foto && !str_starts_with($foto->foto, 'data:') && Storage::disk('public')->exists($foto->foto)) {
            Storage::disk('public')->delete($foto->foto);
        }

        $foto->delete();

        // Jika foto yang dihapus adalah foto utama, jadikan foto lain sebagai foto utama
        if ($wasUtama) {
            $fotoLain = GaleriProduk::where('produk_id', $produkId)->first();
            if ($fotoLain) {
                $fotoLain->update(['foto_utama' => 1]);
            }
        }

        return redirect()->back()
            ->with('success', 'Foto produk berhasil dihapus dari galeri.');
    }

    /**
     * Menetapkan foto tertentu sebagai foto utama produk.
     */
    public function setFotoUtama($fotoId)
    {
        $foto = GaleriProduk::findOrFail($fotoId);

        // Reset semua foto produk ini menjadi bukan utama
        GaleriProduk::where('produk_id', $foto->produk_id)->update(['foto_utama' => 0]);

        // Jadikan foto ini sebagai foto utama
        $foto->update(['foto_utama' => 1]);

        return redirect()->back()
            ->with('success', 'Foto utama produk berhasil diperbarui.');
    }
}
