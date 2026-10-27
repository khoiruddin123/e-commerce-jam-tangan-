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
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 antialiased flex min-h-screen">

    <!-- 1. SIDEBAR NAVIGASI HITAM PEKAT / DARK NAVY (SESUAI MOCKUP) -->
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

                <!-- Kelola Produk & Varian Stok -->
                <a href="{{ route('admin.varian.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 transition">
                    <i class="bi bi-watch text-sm"></i>
                    <span>Kelola Produk</span>
                </a>

                <!-- Kelola Kategori -->
                <a href="{{ route('admin.kategori.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 transition">
                    <i class="bi bi-collection text-sm"></i>
                    <span>Kelola Kategori</span>
                </a>

                <!-- Pesanan & Pengiriman -->
                <a href="{{ route('admin.pesanan.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 transition">
                    <i class="bi bi-truck text-sm"></i>
                    <span>Pesanan & Pengiriman</span>
                </a>

                <!-- Laporan Omzet -->
                <a href="{{ route('admin.laporan.omzet') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 transition">
                    <i class="bi bi-graph-up text-sm"></i>
                    <span>Laporan Omzet</span>
                </a>

                <!-- Pengaturan Toko -->
                <a href="#" onclick="alert('Pengaturan Toko Kronos: Semua modul gateway pembayaran SSL & kurir logistik berjalan normal.'); return false;" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 transition">
                    <i class="bi bi-gear text-sm"></i>
                    <span>Pengaturan Toko</span>
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

                <!-- Notifikasi Bell -->
                <button type="button" class="relative text-slate-500 hover:text-slate-700 transition">
                    <i class="bi bi-bell text-base"></i>
                    <span class="absolute -top-0.5 -right-0.5 w-2 h-2 rounded-full bg-blue-600"></span>
                </button>

                <!-- Profil Admin -->
                <div class="flex items-center gap-3 pl-2 border-l border-slate-200">
                    <div class="text-right hidden sm:block">
                        <div class="text-xs font-bold text-slate-900 leading-tight">
                            {{ Auth::user()->nama ?? 'Hendrawan S.' }}
                        </div>
                        <div class="text-[10px] text-slate-400 font-medium">
                            {{ ucfirst(Auth::user()->role ?? 'Super Admin') }}
                        </div>
                    </div>
                    <!-- Avatar Initials -->
                    <div class="w-9 h-9 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center shadow-sm">
                        {{ strtoupper(substr(Auth::user()->nama ?? 'Hendrawan S', 0, 2)) }}
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
                <div class="flex items-center gap-3">
                    <!-- Tombol Ekspor Laporan -->
                    <a href="{{ route('admin.laporan.omzet.cetak') }}" target="_blank"
                       class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-semibold text-xs px-3.5 py-2.5 rounded-xl shadow-sm transition">
                        <i class="bi bi-download"></i>
                        <span>Ekspor Laporan</span>
                    </a>

                    <!-- Tombol Tambah Produk -->
                    <a href="{{ route('admin.varian.index') }}" 
                       class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs px-4 py-2.5 rounded-xl shadow-sm shadow-blue-500/20 transition">
                        <i class="bi bi-plus-lg"></i>
                        <span>Tambah Produk</span>
                    </a>
                </div>
            </div>

            <!-- 4 METRIC CARDS SESUAI MOCKUP -->
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
                        <span class="text-emerald-600 font-semibold">{{ $omzetGrowth }}</span>
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

            <!-- MIDDLE SECTION: TREN OMZET & KATEGORI PENJUALAN -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Kiri: Tren Omzet 6 Bulan (Line Chart) -->
                <div class="lg:col-span-8 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <h3 class="font-bold text-sm text-slate-900">Tren Omzet 6 Bulan</h3>
                                <div class="text-[11px] text-slate-400">Desember 2025 – Mei 2026</div>
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
                            Total Semester 1: <strong class="text-slate-900">Rp4,28 Miliar</strong>
                        </div>
                        <div class="flex items-center gap-1.5 text-slate-600 font-medium">
                            <i class="bi bi-shield-check text-blue-600"></i>
                            <span>Audit Finansial Terverifikasi</span>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Kategori Penjualan & Produk Terlaris -->
                <div class="lg:col-span-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-sm text-slate-900">Kategori Penjualan</h3>
                        <div class="text-[11px] text-slate-400 mb-4">Kontribusi revenue menurut seri</div>

                        <!-- Daftar Kategori & Progress Bar -->
                        <div class="space-y-3.5">
                            @foreach($kategoriPenjualan as $kat)
                                <div>
                                    <div class="flex items-center justify-between text-xs mb-1">
                                        <span class="font-semibold text-slate-700">{{ $kat['nama'] }}</span>
                                        <span class="text-slate-500 font-medium">{{ $kat['persentase'] }}% ({{ $kat['revenue'] }})</span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                        <div class="{{ $kat['warna'] }} h-1.5 rounded-full" style="width: {{ $kat['persentase'] }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Card Info Produk Terlaris -->
                    <div class="pt-4 mt-6 border-t border-slate-100">
                        <div class="flex items-center justify-between text-xs mb-1">
                            <span class="font-bold text-slate-700">Produk Terlaris</span>
                            <span class="font-bold text-slate-600">{{ $produkTerlaris['terjual'] }}</span>
                        </div>
                        <div class="font-bold text-xs text-slate-900">{{ $produkTerlaris['nama'] }}</div>
                        <div class="text-[11px] text-slate-400 mt-0.5">{{ $produkTerlaris['detail'] }}</div>
                    </div>
                </div>
            </div>

            <!-- BOTTOM SECTION: PESANAN TERBARU (TABEL SESUAI MOCKUP) -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-2">
                        <h3 class="font-bold text-sm text-slate-900">Pesanan Terbaru</h3>
                        <span class="text-[11px] text-slate-400">20 transaksi terkini</span>
                    </div>
                    <!-- Filter Search Mini -->
                    <div class="relative w-full sm:w-64">
                        <i class="bi bi-search absolute left-3 top-2 text-slate-400 text-xs"></i>
                        <input type="text" placeholder="Cari pesanan..." 
                               class="w-full text-xs pl-8 pr-3 py-1.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Tabel Transaksi -->
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
                            @foreach($pesananTerbaru as $order)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-3.5 px-4 font-mono font-medium text-slate-800">
                                        {{ $order['no_pesanan'] }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <div class="font-semibold text-slate-800">{{ $order['pelanggan'] }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $order['tier'] }}</div>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600 font-medium">
                                        {{ $order['produk'] }}
                                    </td>
                                    <td class="py-3.5 px-4 font-bold text-slate-900">
                                        {{ $order['total'] }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        @if($order['status'] === 'Diproses QC')
                                            <span class="inline-flex items-center text-blue-600 bg-blue-50 font-semibold px-2.5 py-0.5 rounded-full text-[11px]">
                                                Diproses QC
                                            </span>
                                        @elseif($order['status'] === 'Siap Kirim')
                                            <span class="inline-flex items-center text-amber-600 bg-amber-50 font-semibold px-2.5 py-0.5 rounded-full text-[11px]">
                                                Siap Kirim
                                            </span>
                                        @elseif($order['status'] === 'Selesai')
                                            <span class="inline-flex items-center text-emerald-600 bg-emerald-50 font-semibold px-2.5 py-0.5 rounded-full text-[11px]">
                                                Selesai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center text-slate-600 bg-slate-100 font-semibold px-2.5 py-0.5 rounded-full text-[11px]">
                                                {{ $order['status'] }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <a href="{{ route('admin.pesanan.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold text-xs transition">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Footer Tabel & Pagination -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                    <div>Menampilkan 5 dari 20 pesanan</div>
                    <div class="flex items-center gap-1 font-semibold">
                        <span class="w-6 h-6 flex items-center justify-center rounded bg-slate-100 text-slate-800">1</span>
                        <span class="w-6 h-6 flex items-center justify-center rounded hover:bg-slate-50 cursor-pointer">2</span>
                        <span class="w-6 h-6 flex items-center justify-center rounded hover:bg-slate-50 cursor-pointer">3</span>
                    </div>
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

    <!-- Script Chart.js untuk Menggambar Grafik Garis Tren Omzet -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('chartTrenOmzet').getContext('2d');
            
            // Gradient fill untuk grafik
            const gradient = ctx.createLinearGradient(0, 0, 0, 200);
            gradient.addColorStop(0, 'rgba(37, 99, 235, 0.15)');
            gradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Omzet (Juta Rp)',
                        data: {!! json_encode($chartValues) !!},
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
                        legend: { display: false },
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
                            grid: { display: false },
                            ticks: {
                                font: { size: 10, family: "'Inter', sans-serif" },
                                color: '#94A3B8'
                            }
                        },
                        y: {
                            display: false,
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>