<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Pengiriman;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    /**
     * Menampilkan daftar pesanan & pengiriman logistik (Sesuai Desain Referensi Butik).
     */
    public function index(Request $request)
    {
        $status = $request->input('status', 'semua');
        $search = $request->input('search');
        $kurir = $request->input('kurir');
        $periode = $request->input('periode'); // format Y-m

        $query = Pesanan::with(['user', 'detail.varian.produk', 'pembayaran', 'pengiriman']);

        // Filter berdasarkan Tab Status
        if ($status === 'dibayar') {
            $query->where('status_pesanan', 'dibayar');
        } elseif ($status === 'diproses') {
            $query->where('status_pesanan', 'diproses');
        } elseif ($status === 'perlu_diproses') {
            $query->whereIn('status_pesanan', ['dibayar', 'diproses']);
        } elseif ($status === 'dikirim') {
            $query->where('status_pesanan', 'dikirim');
        } elseif ($status === 'selesai') {
            $query->where('status_pesanan', 'selesai');
        } elseif ($status === 'dibatalkan') {
            $query->where('status_pesanan', 'dibatalkan');
        }

        // Filter Pencarian (No. Pesanan, Nama Pelanggan, Resi, atau Telepon)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_pesanan', 'like', "%{$search}%")
                  ->orWhere('nama_penerima', 'like', "%{$search}%")
                  ->orWhere('telepon_penerima', 'like', "%{$search}%")
                  ->orWhereHas('pengiriman', function ($pq) use ($search) {
                      $pq->where('nomor_resi', 'like', "%{$search}%")
                         ->orWhere('nama_kurir', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('nama', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter Kurir (dari relasi pengiriman)
        if ($kurir && $kurir !== 'semua') {
            $query->whereHas('pengiriman', function ($pq) use ($kurir) {
                $pq->where('nama_kurir', 'like', "%{$kurir}%");
            });
        }

        // Filter Periode Bulan/Tahun
        if ($periode) {
            $parts = explode('-', $periode);
            if (count($parts) === 2) {
                $query->whereYear('tanggal_pesanan', $parts[0])
                      ->whereMonth('tanggal_pesanan', $parts[1]);
            }
        }

        $daftarPesanan = $query->orderByDesc('tanggal_pesanan')->paginate(10)->withQueryString();

        // Metrik Statistik Atas (4 Kartu)
        $totalPesanan = Pesanan::count();
        $perluDiproses = Pesanan::whereIn('status_pesanan', ['dibayar', 'diproses'])->count();
        $dalamPengiriman = Pesanan::where('status_pesanan', 'dikirim')->count();
        $selesai = Pesanan::where('status_pesanan', 'selesai')->count();

        // Hitung Tab Badge
        $countSemua = $totalPesanan;
        $countDibayar = Pesanan::where('status_pesanan', 'dibayar')->count();
        $countDiproses = Pesanan::where('status_pesanan', 'diproses')->count();
        $countDikirim = $dalamPengiriman;
        $countSelesai = $selesai;
        $countDibatalkan = Pesanan::where('status_pesanan', 'dibatalkan')->count();

        // Daftar kurir unik untuk filter dropdown
        $daftarKurir = [
            'JNE Express',
            'JNE Express (YES)',
            'SiCepat Reguler',
            'SiCepat BEST',
            'J&T Express',
            'Paxel Cargo',
            'POS Indonesia',
            'TIKI',
        ];

        return view('admin.pesanan.index', compact(
            'daftarPesanan',
            'status',
            'search',
            'kurir',
            'periode',
            'totalPesanan',
            'perluDiproses',
            'dalamPengiriman',
            'selesai',
            'countSemua',
            'countDibayar',
            'countDiproses',
            'countDikirim',
            'countSelesai',
            'countDibatalkan',
            'daftarKurir'
        ));
    }

    /**
     * Memperbarui nomor resi dan kurir logistik ke tabel pengiriman.
     * Jika status masih diproses/dibayar dan resi diinput, otomatis perbarui status pesanan ke 'dikirim'.
     */
    public function updateResi(Request $request, $id)
    {
        $request->validate([
            'kurir' => 'required|string|max:60',
            'nomor_resi' => 'required|string|max:100',
            'otomatis_dikirim' => 'nullable|boolean',
        ]);

        $pesanan = Pesanan::findOrFail($id);

        // Simpan / update ke tabel pengiriman
        Pengiriman::updateOrCreate(
            ['pesanan_id' => $pesanan->pesanan_id],
            [
                'nama_kurir' => $request->kurir,
                'nomor_resi' => trim($request->nomor_resi),
                'tanggal_dikirim' => now(),
            ]
        );

        // Otomatis ubah status ke 'dikirim' jika opsi dicentang atau status masih belum dikirim
        if ($request->has('otomatis_dikirim') || in_array($pesanan->status_pesanan, ['dibayar', 'diproses'])) {
            $pesanan->status_pesanan = 'dikirim';
            $pesanan->save();
        }

        return redirect()->back()->with('success', "Nomor resi untuk pesanan #{$pesanan->nomor_pesanan} berhasil disimpan ({$request->kurir} - {$request->nomor_resi}).");
    }

    /**
     * Memperbarui status pesanan (dibayar, diproses, dikirim, selesai, dibatalkan).
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pesanan' => 'required|in:menunggu_pembayaran,dibayar,diproses,dikirim,selesai,dibatalkan',
            'catatan' => 'nullable|string|max:500',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status_pesanan = $request->status_pesanan;

        if ($request->filled('catatan')) {
            $pesanan->catatan = $request->catatan;
        }

        $pesanan->save();

        $namaStatus = ucfirst(str_replace('_', ' ', $pesanan->status_pesanan));
        return redirect()->back()->with('success', "Status pesanan #{$pesanan->nomor_pesanan} berhasil diubah menjadi: {$namaStatus}.");
    }
}
