<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Menampilkan daftar seluruh kategori produk beserta jumlah produk terkait.
     */
    public function index()
    {
        // Ambil kategori diurutkan dari nama, sekaligus hitung jumlah produk di setiap kategori
        $daftarKategori = Kategori::withCount('produk')
            ->orderBy('nama_kategori', 'asc')
            ->get();

        return view('admin.kategori.index', compact('daftarKategori'));
    }

    /**
     * Menyimpan kategori baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori',
            'deskripsi'     => 'nullable|string|max:500',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori sudah digunakan.',
            'nama_kategori.max'      => 'Nama kategori maksimal 100 karakter.',
        ]);

        Kategori::create([
            'nama_kategori' => $validated['nama_kategori'],
            'deskripsi'     => $validated['deskripsi'] ?? null,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    /**
     * Memperbarui data kategori yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori,' . $id . ',kategori_id',
            'deskripsi'     => 'nullable|string|max:500',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori sudah digunakan.',
            'nama_kategori.max'      => 'Nama kategori maksimal 100 karakter.',
        ]);

        $kategori->update([
            'nama_kategori' => $validated['nama_kategori'],
            'deskripsi'     => $validated['deskripsi'] ?? null,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Menghapus kategori jika tidak memiliki produk terkait.
     */
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        // Validasi integritas data: cegah penghapusan jika kategori masih dipakai oleh produk
        if ($kategori->produk()->exists()) {
            return redirect()->route('admin.kategori.index')->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh produk.');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
