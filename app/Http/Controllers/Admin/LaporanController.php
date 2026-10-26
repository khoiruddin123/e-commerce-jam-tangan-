<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bulanSekarang = (int) date('m');
        $tahunSekarang = (int) date('Y');

        $bulan = (int) $request->input('bulan', $bulanSekarang);
        $tahun = (int) $request->input('tahun', $tahunSekarang);
        $statusFilter = $request->input('status', 'sukses');

        $statusSah = ['dibayar', 'diproses', 'dikirim', 'selesai'];

        // 1. Query dasar pesanan periode ini
        $query = Pesanan::with(['user', 'detail', 'pembayaran'])
            ->whereYear('tanggal_pesanan', $tahun)
            ->whereMonth('tanggal_pesanan', $bulan);

        if ($statusFilter === 'sukses') {
            $query->whereIn('status_pesanan', $statusSah);
        } elseif ($statusFilter !== 'semua' && in_array($statusFilter, ['menunggu_pembayaran', 'dibayar', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])) {
            $query->where('status_pesanan', $statusFilter);
        }

        // 2. Hitung Metrik Utama
        $kpiQuery = clone $query;
        $totalOmzet = (float) $kpiQuery->sum('total_harga');
        $totalSubtotal = (float) $kpiQuery->sum('subtotal');
        $totalOngkir = (float) $kpiQuery->sum('ongkir');
        $totalTransaksi = (int) $kpiQuery->count();
        $rataRataTransaksi = $totalTransaksi > 0 ? round($totalOmzet / $totalTransaksi) : 0;

        // 3. Omzet Bulan Sebelumnya 
        $bulanLalu = $bulan == 1 ? 12 : $bulan - 1;
        $tahunLalu = $bulan == 1 ? $tahun - 1 : $tahun;
        $omzetBulanLalu = (float) Pesanan::whereYear('tanggal_pesanan', $tahunLalu)
            ->whereMonth('tanggal_pesanan', $bulanLalu)
            ->whereIn('status_pesanan', $statusSah)
            ->sum('total_harga');

        if ($totalOmzet <= 0) {
            $pertumbuhanOmzet = 0;
        } else {
            $pertumbuhanOmzet = $omzetBulanLalu > 0 
                ? round((($totalOmzet - $omzetBulanLalu) / $omzetBulanLalu) * 100, 1) 
                : 100.0;
        }

        // 4. Hitung Tren Akumulasi 4 Pekan (Revenue Curve)
        $minggu1 = (float) Pesanan::whereYear('tanggal_pesanan', $tahun)->whereMonth('tanggal_pesanan', $bulan)
            ->whereDay('tanggal_pesanan', '<=', 7)->whereIn('status_pesanan', $statusSah)->sum('total_harga');
        $minggu2 = (float) Pesanan::whereYear('tanggal_pesanan', $tahun)->whereMonth('tanggal_pesanan', $bulan)
            ->whereDay('tanggal_pesanan', '>', 7)->whereDay('tanggal_pesanan', '<=', 14)->whereIn('status_pesanan', $statusSah)->sum('total_harga');
        $minggu3 = (float) Pesanan::whereYear('tanggal_pesanan', $tahun)->whereMonth('tanggal_pesanan', $bulan)
            ->whereDay('tanggal_pesanan', '>', 14)->whereDay('tanggal_pesanan', '<=', 21)->whereIn('status_pesanan', $statusSah)->sum('total_harga');
        $minggu4 = (float) Pesanan::whereYear('tanggal_pesanan', $tahun)->whereMonth('tanggal_pesanan', $bulan)
            ->whereDay('tanggal_pesanan', '>', 21)->whereIn('status_pesanan', $statusSah)->sum('total_harga');

        $mingguan = [
            'Mg-1' => $minggu1,
            'Mg-2' => $minggu2,
            'Mg-3' => $minggu3,
            'Mg-4' => $minggu4,
        ];
        arsort($mingguan);
        $puncakNama = $totalOmzet > 0 ? key($mingguan) : '-';
        $puncakNilai = $totalOmzet > 0 ? current($mingguan) : 0;

        // 5. Total unit produk terjual
        $totalProdukTerjual = (int) DB::table('detail_pesanan')
            ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.pesanan_id')
            ->whereYear('pesanan.tanggal_pesanan', $tahun)
            ->whereMonth('pesanan.tanggal_pesanan', $bulan)
            ->when($statusFilter === 'sukses', function ($q) use ($statusSah) {
                return $q->whereIn('pesanan.status_pesanan', $statusSah);
            })
            ->sum('detail_pesanan.jumlah');

        // 6. Ambil seluruh transaksi untuk tabel (diurutkan tanggal terbaru)
        $daftarPesanan = $query->orderByDesc('tanggal_pesanan')->get();

        $daftarBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $daftarBulanSingkat = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];

        // Rentang tahun dinamis (termasuk 2024 dari mockup dan tahun berjalan)
        $daftarTahun = array_unique([2024, 2025, $tahunSekarang, $tahunSekarang + 1]);
        sort($daftarTahun);

        $namaBulanLalu = $daftarBulan[$bulanLalu] ?? 'Bulan Lalu';
        $namaBulanIni = $daftarBulan[$bulan] ?? 'Bulan Ini';
        $singkatBulanIni = $daftarBulanSingkat[$bulan] ?? 'Okt';
        $jumlahHariBulan = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        return view('admin.laporan.omzet', compact(
            'daftarPesanan',
            'totalOmzet',
            'totalSubtotal',
            'totalOngkir',
            'totalTransaksi',
            'totalProdukTerjual',
            'rataRataTransaksi',
            'omzetBulanLalu',
            'pertumbuhanOmzet',
            'puncakNama',
            'puncakNilai',
            'minggu1', 'minggu2', 'minggu3', 'minggu4',
            'bulan',
            'tahun',
            'statusFilter',
            'daftarBulan',
            'daftarTahun',
            'namaBulanIni',
            'namaBulanLalu',
            'singkatBulanIni',
            'jumlahHariBulan'
        ));
    }

    /**
     * Tampilan cetak / print preview laporan omzet bulanan.
     */
    public function cetak(Request $request)
    {
        $bulanSekarang = (int) date('m');
        $tahunSekarang = (int) date('Y');

        $bulan = (int) $request->input('bulan', $bulanSekarang);
        $tahun = (int) $request->input('tahun', $tahunSekarang);
        $statusFilter = $request->input('status', 'sukses');

        $statusSah = ['dibayar', 'diproses', 'dikirim', 'selesai'];

        $query = Pesanan::with(['user', 'detail', 'pembayaran'])
            ->whereYear('tanggal_pesanan', $tahun)
            ->whereMonth('tanggal_pesanan', $bulan);

        if ($statusFilter === 'sukses') {
            $query->whereIn('status_pesanan', $statusSah);
        } elseif ($statusFilter !== 'semua' && in_array($statusFilter, ['menunggu_pembayaran', 'dibayar', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])) {
            $query->where('status_pesanan', $statusFilter);
        }

        $semuaPesanan = $query->orderByDesc('tanggal_pesanan')->get();

        $totalOmzet = (float) $semuaPesanan->sum('total_harga');
        $totalSubtotal = (float) $semuaPesanan->sum('subtotal');
        $totalOngkir = (float) $semuaPesanan->sum('ongkir');
        $totalTransaksi = (int) $semuaPesanan->count();
        $totalProdukTerjual = (int) $semuaPesanan->sum(function ($p) {
            return $p->detail->sum('jumlah');
        });

        $daftarBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $namaBulan = $daftarBulan[$bulan] ?? 'Bulan ' . $bulan;

        return view('admin.laporan.cetak', compact(
            'semuaPesanan',
            'totalOmzet',
            'totalSubtotal',
            'totalOngkir',
            'totalTransaksi',
            'totalProdukTerjual',
            'bulan',
            'tahun',
            'namaBulan',
            'statusFilter'
        ));
    }
}
