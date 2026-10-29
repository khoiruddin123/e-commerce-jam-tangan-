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
     * Aturan: Resi hanya bisa diinput/diedit saat status 'diproses' (atau 'dibayar').
     * Begitu status menjadi 'dikirim' atau 'selesai', resi TERKUNCI PERMANEN.
     */
    public function updateResi(Request $request, $id)
    {
        $request->validate([
            'kurir' => 'required|string|max:60',
            'nomor_resi' => 'required|string|max:100',
            'otomatis_dikirim' => 'nullable|boolean',
        ]);

        $pesanan = Pesanan::findOrFail($id);

        // 1. Kunci Mutlak: Jika status sudah 'dikirim' atau 'selesai', resi terkunci mati
        if (in_array($pesanan->status_pesanan, ['dikirim', 'selesai'])) {
            return redirect()->back()->with('error', "Nomor resi untuk pesanan #{$pesanan->nomor_pesanan} sudah TERKUNCI PERMANEN karena paket telah diserahkan ke kurir/selesai.");
        }

        // 2. Cegah input resi pada pesanan belum dibayar atau dibatalkan
        if (in_array($pesanan->status_pesanan, ['menunggu_pembayaran', 'dibatalkan'])) {
            return redirect()->back()->with('error', "Nomor resi tidak dapat diinput untuk pesanan dengan status '{$pesanan->status_pesanan}'.");
        }

        // 3. Bersihkan format nomor resi (Kapital & tanpa spasi)
        $nomorResiBersih = strtoupper(preg_replace('/\s+/', '', $request->nomor_resi));

        // 4. Simpan / perbarui informasi pengiriman
        $pengiriman = Pengiriman::firstOrNew(['pesanan_id' => $pesanan->pesanan_id]);
        $pengiriman->nama_kurir = $request->kurir;
        $pengiriman->nomor_resi = $nomorResiBersih;

        // 5. Jika opsi 'otomatis_dikirim' dicentang, ubah status pesanan menjadi 'dikirim' dan catat tanggal_dikirim
        if ($request->boolean('otomatis_dikirim')) {
            $pesanan->status_pesanan = 'dikirim';
            $pesanan->save();

            if (!$pengiriman->tanggal_dikirim) {
                $pengiriman->tanggal_dikirim = now();
            }
        } elseif ($pesanan->status_pesanan === 'dibayar') {
            // Jika resi draf diinput pada pesanan yang masih 'dibayar', naikkan status ke 'diproses'
            $pesanan->status_pesanan = 'diproses';
            $pesanan->save();
        }

        $pengiriman->save();

        $pesanStatus = $pesanan->status_pesanan === 'dikirim' 
            ? "Paket resmi berstatus DIKIRIM dan nomor resi terkunci permanen." 
            : "Nomor resi tersimpan sebagai draf (status Diproses).";

        return redirect()->back()->with('success', "Nomor resi pesanan #{$pesanan->nomor_pesanan} ({$request->kurir} - {$nomorResiBersih}) berhasil disimpan. {$pesanStatus}");
    }

    /**
     * Memperbarui status pesanan (dibayar, diproses, dikirim, dibatalkan).
     * Status 'selesai' dikhususkan bagi konfirmasi langsung oleh pembeli (F10-07 / BB-73).
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pesanan' => 'required|in:menunggu_pembayaran,dibayar,diproses,dikirim,selesai,dibatalkan',
            'catatan' => 'nullable|string|max:500',
        ]);

        $pesanan = Pesanan::findOrFail($id);

        // 1. Proteksi Status Final: Pesanan yang sudah selesai atau dibatalkan tidak boleh diubah lagi
        if (in_array($pesanan->status_pesanan, ['selesai', 'dibatalkan']) && $request->status_pesanan !== $pesanan->status_pesanan) {
            return redirect()->back()->with('error', "Pesanan dengan status '{$pesanan->status_pesanan}' bersifat final dan tidak dapat diubah statusnya lagi.");
        }

        // 2. Proteksi Hak Pembeli: Admin tidak boleh sembarangan mengubah ke 'selesai' (F10-07 / BB-73)
        if ($request->status_pesanan === 'selesai' && $pesanan->status_pesanan !== 'selesai') {
            return redirect()->back()->with('error', "Status 'Selesai' adalah hak konfirmasi akhir pembeli setelah jam tangan diterima fisik (Sesuai F10-07 & BB-73).");
        }

        // 3. Proteksi Regresi: Pesanan yang sudah dikirim tidak boleh diturunkan kembali ke diproses/dibayar
        if ($pesanan->status_pesanan === 'dikirim' && in_array($request->status_pesanan, ['dibayar', 'diproses', 'menunggu_pembayaran'])) {
            return redirect()->back()->with('error', "Pesanan yang sudah berstatus 'Dikirim' tidak dapat diturunkan kembali ke status sebelumnya.");
        }

        // 4. Jika mengubah status menjadi 'dikirim', pastikan resi sudah diinput terlebih dahulu
        if ($request->status_pesanan === 'dikirim') {
            if (!$pesanan->pengiriman || empty($pesanan->pengiriman->nomor_resi)) {
                return redirect()->back()->with('error', "Pesanan tidak dapat diubah ke status 'Dikirim' tanpa nomor resi. Silakan gunakan tombol 'Input Resi'.");
            }

            // Catat tanggal_dikirim jika belum ada
            if (!$pesanan->pengiriman->tanggal_dikirim) {
                $pesanan->pengiriman->tanggal_dikirim = now();
                $pesanan->pengiriman->save();
            }
        }

        $pesanan->status_pesanan = $request->status_pesanan;

        if ($request->filled('catatan')) {
            $pesanan->catatan = $request->catatan;
        }

        $pesanan->save();

        $namaStatus = ucfirst(str_replace('_', ' ', $pesanan->status_pesanan));
        return redirect()->back()->with('success', "Status pesanan #{$pesanan->nomor_pesanan} berhasil diubah menjadi: {$namaStatus}.");
    }
}
