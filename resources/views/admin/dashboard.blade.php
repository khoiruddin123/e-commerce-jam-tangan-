<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Kronos Watch</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        @media print {

            aside,
            header,
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            main {
                padding: 0 !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>

<body class="bg-[#f8fafc] text-slate-800 antialiased flex min-h-screen">

    <!-- 1. SIDEBAR NAVIGASI HITAM PEKAT / DARK NAVY (SESUAI MOCKUP, TANPA SETTING & LAPORAN) -->
    <aside class="w-64 bg-[#0B1120] text-slate-300 flex flex-col justify-between shrink-0 min-h-screen border-r border-slate-900 sticky top-0 h-screen overflow-y-auto">
        <div class="p-5">
            <!-- Brand Logo KRONOS ADMIN PORTAL -->
            <div class="flex items-center gap-3 mb-8 px-1">
                <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center text-white text-lg shadow-sm shadow-blue-500/30">
                    <i class="bi bi-watch"></i>
                </div>
                <div>
                    <div class="text-sm font-extrabold tracking-widest text-white">KRONOS</div>
                    <div class="text-[10px] tracking-widest text-slate-400 font-semibold uppercase">ADMIN PORTAL</div>
                </div>
            </div>

            <!-- Menu Heading -->
            <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3 mb-3">
                MENU NAVIGASI
            </div>

            <!-- Nav Links List -->
            <nav class="space-y-1 text-xs font-semibold">
                <!-- Dashboard (Active) -->
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold shadow-sm transition">
                    <i class="bi bi-grid-fill text-sm"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Kelola Produk -->
                <a href="{{ route('admin.produk.index') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 transition">
                    <i class="bi bi-watch text-sm"></i>
                    <span>Kelola Produk</span>
                </a>

                <!-- Kelola Varian, Harga & Stok -->
                <a href="{{ route('admin.varian.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 transition">
                    <i class="bi bi-boxes text-sm"></i>
                    <span>Varian & Stok</span>
                </a>

                <!-- Kelola Kategori -->
                <a href="{{ route('admin.kategori.index') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 transition">
                    <i class="bi bi-collection text-sm"></i>
                    <span>Kelola Kategori</span>
                </a>

                <!-- Kelola Merek -->
                <a href="{{ route('admin.merek.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 transition">
                    <i class="bi bi-tag-fill text-sm"></i>
                    <span>Kelola Merek</span>
                </a>

                <!-- Pesanan & Pengiriman -->
                <a href="{{ route('admin.pesanan.index') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 transition">
                    <i class="bi bi-truck text-sm"></i>
                    <span>Pesanan & Pengiriman</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer: Status Butik & Tombol Keluar -->
        <div class="p-4 space-y-4">
            <!-- Kartu Status Butik -->
            <div class="bg-[#131D38] border border-slate-800 rounded-2xl p-3.5 text-xs">
                <div class="flex items-center justify-between text-[11px] mb-1">
                    <span class="font-bold text-slate-400 uppercase tracking-wider text-[10px]">STATUS BUTIK</span>
                    <span class="inline-flex items-center gap-1 text-emerald-400 font-bold text-[10px]">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Aktif
                    </span>
                </div>
                <div class="font-bold text-white text-xs">Showroom Jakarta Flagship</div>
                <div class="text-[10px] text-slate-400 mt-0.5">Jam Operasional: 10:00 - 22:00</div>
            </div>

            <!-- Tombol Keluar / Logout -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2.5 text-slate-400 hover:text-rose-400 hover:bg-slate-800/40 px-3 py-2 rounded-xl text-xs font-semibold transition cursor-pointer">
                    <i class="bi bi-box-arrow-left text-sm"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- 2. MAIN CONTENT AREA (KANAN) -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        <!-- Top Header Bar -->
        <header class="bg-white border-b border-slate-200/80 sticky top-0 z-30 px-6 py-3.5 flex items-center justify-between gap-4">
            <!-- Search Bar Input -->
            <div class="relative w-72 sm:w-96">
                <i class="bi bi-search absolute left-3.5 top-2.5 text-slate-400 text-xs"></i>
                <input type="text" placeholder="Cari SKU, pesanan, atau pembeli..."
                    class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-3.5 py-2 text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>

            <!-- Top Right Info & Profile -->
            <div class="flex items-center gap-4 sm:gap-6">
                <!-- Status Badge -->
                <div class="hidden md:inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200/70 text-[11px] font-semibold px-3 py-1 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>Butik Terhubung</span>
                </div>

                <!-- Profil Admin -->
                <div class="flex items-center gap-3 pl-2 border-l border-slate-200">
                    <div class="text-right hidden sm:block">
                        <div class="text-xs font-bold text-slate-900 leading-tight">
                            {{ Auth::user()->nama ?? 'Admin' }}
                        </div>
                        <div class="text-[10px] text-slate-400 font-medium">
                            {{ ucfirst(Auth::user()->role ?? 'Super Admin') }}
                        </div>
                    </div>
                    <!-- Avatar Initials -->
                    <div class="w-9 h-9 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center shadow-sm">
                        {{ strtoupper(substr(Auth::user()->nama ?? 'AD', 0, 2)) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Body Container -->
        <main class="p-6 sm:p-8 space-y-6 max-w-7xl w-full mx-auto flex-1">

            <!-- Title & Action Buttons -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Dashboard Overview</h1>
                    <p class="text-xs text-slate-500 mt-1">Ringkasan penjualan arloji, metrik utama, dan aktivitas pesanan butik.</p>
                </div>
                <div class="flex items-center gap-3 no-print">
                    <!-- Tombol Ekspor Laporan (Mencetak / Menyimpan Laporan Dashboard) -->
                    <button type="button" onclick="window.print()"
                        class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-semibold text-xs px-3.5 py-2.5 rounded-xl shadow-sm transition cursor-pointer">
                        <i class="bi bi-download"></i>
                        <span>Ekspor Laporan</span>
                    </button>

                    <!-- Tombol Tambah Produk -->
                    <a href="{{ route('admin.produk.index') }}"
                        class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs px-4 py-2.5 rounded-xl shadow-sm shadow-blue-500/20 transition">
                        <i class="bi bi-plus-lg"></i>
                        <span>Tambah Produk</span>
                    </a>
                </div>
            </div>

            <!-- 4 METRIC CARDS (DATA RIIL DATABASE) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Card 1: TOTAL PRODUK -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
                    <div class="flex items-center justify-between text-slate-400">
                        <span class="text-[10px] font-bold uppercase tracking-wider">TOTAL PRODUK</span>
                        <i class="bi bi-watch text-sm"></i>
                    </div>
                    <div class="text-2xl font-black text-slate-900 mt-2">{{ $totalSKU }} SKU</div>
                    <div class="text-[11px] text-slate-400 font-medium mt-1">
                        {{ $aktifSKU }} aktif &middot; {{ $drafSKU }} draf
                    </div>
                </div>

                <!-- Card 2: PERLU DIPROSES -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
                    <div class="flex items-center justify-between text-slate-400">
                        <span class="text-[10px] font-bold uppercase tracking-wider">PERLU DIPROSES</span>
                        <i class="bi bi-hourglass-split text-sm"></i>
                    </div>
                    <div class="text-2xl font-black text-slate-900 mt-2">{{ $perluDiprosesCount }} Pesanan</div>
                    <div class="text-[11px] text-slate-400 font-medium mt-1">
                        {{ $menungguQC }} Menunggu QC &middot; {{ $siapKirim }} Siap Kirim
                    </div>
                </div>

                <!-- Card 3: OMZET BULAN INI -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
                    <div class="flex items-center justify-between text-slate-400">
                        <span class="text-[10px] font-bold uppercase tracking-wider">OMZET BULAN INI</span>
                        <i class="bi bi-eye text-sm"></i>
                    </div>
                    <div class="text-2xl font-black text-slate-900 mt-2">{{ $omzetFormatted }}</div>
                    <div class="text-[11px] text-slate-400 font-medium mt-1 flex items-center gap-1">
                        <span class="{{ $omzetGrowth[0] === '+' ? 'text-emerald-600' : 'text-slate-500' }} font-semibold">{{ $omzetGrowth }}</span>
                        <span>vs bulan lalu</span>
                    </div>
                </div>

                <!-- Card 4: TRANSAKSI BERHASIL -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
                    <div class="flex items-center justify-between text-slate-400">
                        <span class="text-[10px] font-bold uppercase tracking-wider">TRANSAKSI BERHASIL</span>
                        <i class="bi bi-check-circle text-sm"></i>
                    </div>
                    <div class="text-2xl font-black text-slate-900 mt-2">{{ $transaksiBerhasilCount }} Pesanan</div>
                    <div class="text-[11px] text-slate-400 font-medium mt-1">
                        Rata-rata {{ $rataRataFormatted }} / transaksi
                    </div>
                </div>
            </div>

            <!-- MIDDLE SECTION: TREN OMZET & KATEGORI PENJUALAN (DATA RIIL) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Kiri: Tren Omzet 6 Bulan (Line Chart Riil) -->
                <div class="lg:col-span-8 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <h3 class="font-bold text-sm text-slate-900">Tren Omzet 6 Bulan</h3>
                                <div class="text-[11px] text-slate-400">{{ $chartLabels[0] ?? '' }} – {{ $chartLabels[count($chartLabels)-1] ?? '' }}</div>
                            </div>
                            <!-- Period Tabs -->
                            <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                                <span class="text-slate-800 bg-slate-100 px-2.5 py-1 rounded-lg">6 Bulan</span>
                                <span class="hover:text-slate-700 cursor-pointer px-1">1 Tahun</span>
                                <span class="hover:text-slate-700 cursor-pointer px-1">YTD</span>
                            </div>
                        </div>

                        <!-- Canvas Grafik Line Chart -->
                        <div class="mt-4 relative" style="height: 220px;">
                            <canvas id="chartTrenOmzet"></canvas>
                        </div>
                    </div>

                    <!-- Footer Kartu Grafik -->
                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                        <div>
                            Total 6 Bulan: <strong class="text-slate-900">{{ $totalSemesterFormatted }}</strong>
                        </div>
                        <div class="flex items-center gap-1.5 text-slate-600 font-medium">
                            <i class="bi bi-shield-check text-blue-600"></i>
                            <span>Audit Finansial Terverifikasi</span>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Kategori Penjualan & Produk Terlaris (Data Riil) -->
                <div class="lg:col-span-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-sm text-slate-900">Kategori Penjualan</h3>
                        <div class="text-[11px] text-slate-400 mb-4">Kontribusi revenue menurut seri</div>

                        @if(empty($kategoriPenjualan))
                        <div class="py-6 text-center text-xs text-slate-400">
                            <i class="bi bi-collection text-xl text-slate-300 block mb-1"></i>
                            Belum ada kategori produk terdaftar
                        </div>
                        @else
                        <!-- Daftar Kategori Riil Database -->
                        <div class="space-y-3.5">
                            @foreach($kategoriPenjualan as $kat)
                            <div>
                                <div class="flex items-center justify-between text-xs mb-1">
                                    <span class="font-semibold text-slate-700">{{ $kat['nama'] }}</span>
                                    <span class="text-slate-500 font-medium">{{ $kat['persentase'] }}% ({{ $kat['revenue'] }})</span>
                                </div>
                                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                    <div class="{{ $kat['warna'] }} h-1.5 rounded-full" style="width: {{ max($kat['persentase'], 4) }}%"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <!-- Card Info Produk Terlaris (Riil Database) -->
                    <div class="pt-4 mt-6 border-t border-slate-100">
                        <div class="flex items-center justify-between text-xs mb-1">
                            <span class="font-bold text-slate-700">Produk Terlaris</span>
                            <span class="font-bold text-slate-600">
                                {{ $bestSeller ? $bestSeller->total_terjual . ' Unit' : '0 Unit' }}
                            </span>
                        </div>
                        @if($bestSeller)
                        <div class="font-bold text-xs text-slate-900">{{ $bestSeller->nama_produk }}</div>
                        <div class="text-[11px] text-slate-400 mt-0.5">
                            {{ $bestSeller->nama_varian }} &middot; Rp{{ number_format($bestSeller->harga_satuan, 0, ',', '.') }}
                        </div>
                        @else
                        <div class="text-xs text-slate-400 italic">Belum ada riwayat penjualan produk</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- BOTTOM SECTION: PESANAN TERBARU (DATA RIIL DATABASE) -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-2">
                        <h3 class="font-bold text-sm text-slate-900">Pesanan Terbaru</h3>
                        <span class="text-[11px] text-slate-400">{{ $pesananTerbaru->count() }} transaksi</span>
                    </div>
                    <!-- Filter Search Mini -->
                    <div class="relative w-full sm:w-64 no-print">
                        <i class="bi bi-search absolute left-3 top-2 text-slate-400 text-xs"></i>
                        <input type="text" placeholder="Cari pesanan..."
                            class="w-full text-xs pl-8 pr-3 py-1.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Tabel Transaksi Riil Database -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                <th class="py-3 px-4">NO. PESANAN</th>
                                <th class="py-3 px-4">PELANGGAN</th>
                                <th class="py-3 px-4">PRODUK</th>
                                <th class="py-3 px-4">TOTAL NILAI</th>
                                <th class="py-3 px-4">STATUS</th>
                                <th class="py-3 px-4 text-right">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @forelse($pesananTerbaru as $order)
                            @php
                            $firstItem = $order->detail->first();
                            $namaProduk = $firstItem->nama_produk ?? $firstItem->varian->produk->nama_produk ?? 'Jam Tangan';
                            if ($order->detail->count() > 1) {
                            $namaProduk .= ' (+' . ($order->detail->count() - 1) . ' item)';
                            }

                            $statusLabel = match ($order->status_pesanan) {
                            'diproses' => 'Diproses QC',
                            'dikirim' => 'Siap Kirim',
                            'selesai' => 'Selesai',
                            'dibatalkan' => 'Dibatalkan',
                            'dibayar' => 'Dibayar',
                            default => 'Menunggu Bayar'
                            };
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-3.5 px-4 font-mono font-medium text-slate-800">
                                    {{ $order->nomor_pesanan ?? ('#KW-' . date('Ymd', strtotime($order->tanggal_pesanan ?? now())) . '-' . $order->pesanan_id) }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-semibold text-slate-800">{{ $order->user->nama ?? $order->user->username ?? $order->nama_penerima ?? 'Pelanggan' }}</div>
                                    <div class="text-[10px] text-slate-400">Member</div>
                                </td>
                                <td class="py-3.5 px-4 text-slate-600 font-medium">
                                    {{ $namaProduk }}
                                </td>
                                <td class="py-3.5 px-4 font-bold text-slate-900">
                                    Rp{{ number_format($order->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4">
                                    @if($order->status_pesanan === 'diproses')
                                    <span class="inline-flex items-center text-blue-600 bg-blue-50 font-semibold px-2.5 py-0.5 rounded-full text-[11px]">
                                        Diproses QC
                                    </span>
                                    @elseif($order->status_pesanan === 'dikirim')
                                    <span class="inline-flex items-center text-amber-600 bg-amber-50 font-semibold px-2.5 py-0.5 rounded-full text-[11px]">
                                        Siap Kirim
                                    </span>
                                    @elseif($order->status_pesanan === 'selesai')
                                    <span class="inline-flex items-center text-emerald-600 bg-emerald-50 font-semibold px-2.5 py-0.5 rounded-full text-[11px]">
                                        Selesai
                                    </span>
                                    @else
                                    <span class="inline-flex items-center text-slate-600 bg-slate-100 font-semibold px-2.5 py-0.5 rounded-full text-[11px]">
                                        {{ $statusLabel }}
                                    </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <a href="{{ route('admin.pesanan.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold text-xs transition">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-2 text-slate-400 text-lg">
                                        <i class="bi bi-inbox"></i>
                                    </div>
                                    <div class="font-semibold text-slate-700 text-xs">Belum Ada Transaksi Pesanan</div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">Pesanan baru dari pelanggan akan otomatis tercatat di sini.</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Tabel -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                    <div>Menampilkan {{ $pesananTerbaru->count() }} pesanan</div>
                    <a href="{{ route('admin.pesanan.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold text-xs flex items-center gap-1">
                        <span>Buka Semua Pesanan</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- SYSTEM FOOTER -->
            <div class="pt-4 pb-2 flex flex-col sm:flex-row items-center justify-between gap-2 text-[11px] text-slate-400">
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Sistem & Gateway Pembayaran Terhubung Normal (SSL 256-bit)</span>
                </div>
                <div>Kronos Horology Studio &copy; 2026</div>
            </div>

        </main>
    </div>

    <!-- Script Chart.js untuk Menggambar Grafik Garis Tren Omzet (Data Riil) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('chartTrenOmzet').getContext('2d');

            const gradient = ctx.createLinearGradient(0, 0, 0, 200);
            gradient.addColorStop(0, 'rgba(37, 99, 235, 0.15)');
            gradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Omzet (Juta Rp)',
                        data: @json($chartValues),
                        borderColor: '#2563EB',
                        borderWidth: 2.5,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#FFFFFF',
                        pointBorderColor: '#2563EB',
                        pointBorderWidth: 2.5,
                        pointRadius: 4.5,
                        pointHoverRadius: 6.5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' Rp ' + context.parsed.y + ' Jt';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 10,
                                    family: "'Inter', sans-serif"
                                },
                                color: '#94A3B8'
                            }
                        },
                        y: {
                            display: false,
                            grid: {
                                display: false
                            },
                            min: 0
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>