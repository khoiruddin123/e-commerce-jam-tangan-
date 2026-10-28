<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Merek;
use Illuminate\Http\Request;

class MerekController extends Controller
{
   
    public function index()
    {
        $daftarMerek = Merek::withCount('produk')
            ->orderBy('nama_merek', 'asc')
            ->get();

        return view('admin.merek.index', compact('daftarMerek'));
    }

    /**
     * Menyimpan merek baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_merek' => 'required|string|max:100|unique:merek,nama_merek',
            'deskripsi'  => 'nullable|string|max:500',
        ], [
            'nama_merek.required' => 'Nama merek jam tangan wajib diisi.',
            'nama_merek.unique'   => 'Merek ini sudah terdaftar.',
            'nama_merek.max'      => 'Nama merek maksimal 100 karakter.',
        ]);

        $merek = Merek::create([
            'nama_merek' => trim($validated['nama_merek']),
            'deskripsi'  => $validated['deskripsi'] ?? null,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status'  => 'success',
                'message' => "Merek {$merek->nama_merek} berhasil ditambahkan.",
                'merek'   => $merek,
            ]);
        }

        return redirect()->back()->with('success', "Merek \"{$merek->nama_merek}\" berhasil ditambahkan.");
    }

    /**
     * Memperbarui data merek yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $merek = Merek::findOrFail($id);

        $validated = $request->validate([
            'nama_merek' => 'required|string|max:100|unique:merek,nama_merek,' . $id . ',merek_id',
            'deskripsi'  => 'nullable|string|max:500',
        ], [
            'nama_merek.required' => 'Nama merek wajib diisi.',
            'nama_merek.unique'   => 'Nama merek sudah digunakan.',
            'nama_merek.max'      => 'Nama merek maksimal 100 karakter.',
        ]);

        $merek->update([
            'nama_merek' => trim($validated['nama_merek']),
            'deskripsi'  => $validated['deskripsi'] ?? null,
        ]);

        return redirect()->route('admin.merek.index')->with('success', "Merek \"{$merek->nama_merek}\" berhasil diperbarui.");
    }

    /**
     * Menghapus merek jika belum ada produk terkait.
     */
    public function destroy($id)
    {
        $merek = Merek::findOrFail($id);

        if ($merek->produk()->exists()) {
            return redirect()->route('admin.merek.index')->with('error', "Merek \"{$merek->nama_merek}\" tidak dapat dihapus karena masih digunakan oleh produk terdaftar.");
        }

        $namaMerek = $merek->nama_merek;
        $merek->delete();

        return redirect()->route('admin.merek.index')->with('success', "Merek \"{$namaMerek}\" berhasil dihapus.");
    }
}
