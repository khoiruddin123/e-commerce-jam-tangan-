<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Produk;
use App\Models\VarianProduk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard Utama Admin dengan kalkulasi 100% data riil dari database (tanpa data dummy).
     */
    public function index(Request $request)
    {
        // 1. Data Riil Total Produk & Varian (SKU)
        $totalSKU = VarianProduk::count();
        $aktifSKU = VarianProduk::where('status_varian', 'aktif')->count();
        $drafSKU  = VarianProduk::where('status_varian', '!=', 'aktif')->count();

        // 2. Data Riil Pesanan Perlu Diproses
        $perluDiprosesCount = Pesanan::whereIn('status_pesanan', ['menunggu_pembayaran', 'dibayar', 'diproses'])->count();
        $menungguQC         = Pesanan::where('status_pesanan', 'diproses')->count();
        $siapKirim          = Pesanan::where('status_pesanan', 'dikirim')->count();

        // 3. Data Riil Omzet Bulan Ini
        $currentMonth = now()->month;
        $currentYear  = now()->year;

        $omzetBulanIni = Pesanan::where('status_pesanan', 'selesai')
            ->whereMonth('tanggal_pesanan', $currentMonth)
            ->whereYear('tanggal_pesanan', $currentYear)
            ->sum('total_harga');

        // Pertumbuhan omzet vs bulan lalu
        $lastMonthDate = now()->subMonth();
        $omzetBulanLalu = Pesanan::where('status_pesanan', 'selesai')
            ->whereMonth('tanggal_pesanan', $lastMonthDate->month)
            ->whereYear('tanggal_pesanan', $lastMonthDate->year)
            ->sum('total_harga');

        if ($omzetBulanLalu > 0) {
            $growthValue = round((($omzetBulanIni - $omzetBulanLalu) / $omzetBulanLalu) * 100, 1);
            $omzetGrowth = ($growthValue >= 0 ? '+' : '') . $growthValue . '%';
        } else {
            $omzetGrowth = $omzetBulanIni > 0 ? '+100%' : '0%';
        }

        // Format tampilan ringkas omzet
        if ($omzetBulanIni >= 1000000000) {
            $omzetFormatted = 'Rp' . number_format($omzetBulanIni / 1000000000, 2, ',', '.') . ' M';
        } elseif ($omzetBulanIni >= 1000000) {
            $omzetFormatted = 'Rp' . number_format($omzetBulanIni / 1000000, 1, ',', '.') . ' Jt';
        } else {
            $omzetFormatted = 'Rp' . number_format($omzetBulanIni, 0, ',', '.');
        }

        // 4. Data Riil Transaksi Berhasil
        $transaksiBerhasilCount = Pesanan::where('status_pesanan', 'selesai')->count();
        $totalOmzetKeseluruhan  = Pesanan::where('status_pesanan', 'selesai')->sum('total_harga');
        $rataRataTransaksi      = $transaksiBerhasilCount > 0 ? ($totalOmzetKeseluruhan / $transaksiBerhasilCount) : 0;

        if ($rataRataTransaksi >= 1000000) {
            $rataRataFormatted = 'Rp' . number_format($rataRataTransaksi / 1000000, 1, ',', '.') . ' Juta';
        } else {
            $rataRataFormatted = 'Rp' . number_format($rataRataTransaksi, 0, ',', '.');
        }

        // 5. Data Riil Grafik Tren Omzet 6 Bulan Terakhir
        $chartLabels   = [];
        $chartValues   = [];
        $totalSemester = 0;

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $label = $date->translatedFormat('M Y');
            $monthlySales = Pesanan::where('status_pesanan', 'selesai')
                ->whereMonth('tanggal_pesanan', $date->month)
                ->whereYear('tanggal_pesanan', $date->year)
                ->sum('total_harga');

            $chartLabels[] = $label;
            // Angka dalam jutaan rupiah untuk skala grafik
            $chartValues[] = round($monthlySales / 1000000, 2);
            $totalSemester += $monthlySales;
        }

        $totalSemesterFormatted = $totalSemester >= 1000000000
            ? 'Rp' . number_format($totalSemester / 1000000000, 2, ',', '.') . ' Miliar'
            : ($totalSemester >= 1000000 
                ? 'Rp' . number_format($totalSemester / 1000000, 1, ',', '.') . ' Juta' 
                : 'Rp' . number_format($totalSemester, 0, ',', '.'));

        // 6. Data Riil Kontribusi Kategori Penjualan
        $daftarKategori = Kategori::withCount('produk')->get();
        $kategoriPenjualan = [];
        $colors = ['bg-blue-600', 'bg-cyan-500', 'bg-indigo-500', 'bg-amber-500', 'bg-purple-500', 'bg-emerald-500'];

        foreach ($daftarKategori as $idx => $kat) {
            // Hitung revenue riil dari kategori ini pada pesanan yang sudah selesai
            $katOmzet = DetailPesanan::whereHas('pesanan', function ($q) {
                $q->where('status_pesanan', 'selesai');
            })->whereHas('varian.produk', function ($q) use ($kat) {
                $q->where('kategori_id', $kat->kategori_id);
            })->sum('subtotal');

            $persen = $totalOmzetKeseluruhan > 0 ? round(($katOmzet / $totalOmzetKeseluruhan) * 100, 1) : 0;

            $revFormatted = $katOmzet >= 1000000 
                ? 'Rp' . number_format($katOmzet / 1000000, 1, ',', '.') . ' Jt' 
                : 'Rp' . number_format($katOmzet, 0, ',', '.');

            $kategoriPenjualan[] = [
                'nama'         => $kat->nama_kategori,
                'persentase'   => $persen,
                'revenue'      => $revFormatted,
                'produk_count' => $kat->produk_count,
                'warna'        => $colors[$idx % count($colors)]
            ];
        }

        // 7. Data Riil Produk Terlaris
        $bestSeller = DetailPesanan::selectRaw('varian_id, nama_produk, nama_varian, harga_satuan, SUM(jumlah) as total_terjual')
            ->whereHas('pesanan', function ($q) {
                $q->where('status_pesanan', 'selesai');
            })
            ->groupBy('varian_id', 'nama_produk', 'nama_varian', 'harga_satuan')
            ->orderByDesc('total_terjual')
            ->first();

        // 8. Data Riil 5 Pesanan Terbaru
        $pesananTerbaru = Pesanan::with(['user', 'detail.varian.produk', 'pengiriman'])
            ->latest('tanggal_pesanan')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalSKU',
            'aktifSKU',
            'drafSKU',
            'perluDiprosesCount',
            'menungguQC',
            'siapKirim',
            'omzetFormatted',
            'omzetGrowth',
            'transaksiBerhasilCount',
            'rataRataFormatted',
            'chartLabels',
            'chartValues',
            'totalSemesterFormatted',
            'kategoriPenjualan',
            'bestSeller',
            'pesananTerbaru'
        ));
    }
}
