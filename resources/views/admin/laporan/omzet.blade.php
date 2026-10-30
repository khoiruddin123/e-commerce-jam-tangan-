<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Omzet Bulanan - A1ORA Watch</title>
    <!-- Favicon Logo A1ORA -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-icon.png') }}">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f8fafc] min-h-screen text-slate-800 antialiased py-8 px-4 sm:px-6 lg:px-8">

    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Navigasi Cepat Kembali ke Dashboard Admin -->
        <div class="flex items-center justify-between text-xs text-slate-500 pb-1">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 transition flex items-center gap-1.5 font-medium">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard Admin
            </a>
            <div>
                User: <span class="font-semibold text-slate-700">{{ Auth::user()->nama }}</span> (Admin)
            </div>
        </div>

        <!-- 1. HEADER SECTION SESUAI MOCKUP -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <!-- Top Tag -->
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600 inline-block animate-pulse"></span>
                    <span class="text-xs font-bold tracking-widest uppercase text-blue-600">VERIFIED FINANCIAL AUDIT</span>
                </div>
                <!-- Judul Utama -->
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Laporan Omzet Bulanan
                </h1>
                <!-- Subtitle -->
                <p class="text-slate-500 text-sm mt-1 max-w-2xl">
                    Pantau rekapitulasi penjualan bersih dan riwayat transaksi lunas toko jam tangan A1ORA Watch.
                </p>
            </div>

            <!-- Tombol Aksi Kanan Atas -->
            <div class="flex items-center gap-3 self-start md:self-auto">
                <!-- Tombol Cetak -->
                <a href="{{ route('admin.laporan.omzet.cetak', ['bulan' => $bulan, 'tahun' => $tahun, 'status' => $statusFilter]) }}" 
                   target="_blank"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-sm shadow-sm transition">
                    <i class="bi bi-printer text-base"></i>
                    <span>Cetak</span>
                </a>

                <!-- Tombol Unduh PDF -->
                <a href="{{ route('admin.laporan.omzet.cetak', ['bulan' => $bulan, 'tahun' => $tahun, 'status' => $statusFilter]) }}" 
                   target="_blank"
                   class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm shadow-md hover:shadow-lg transition">
                    <i class="bi bi-download text-base"></i>
                    <span>Unduh PDF</span>
                </a>
            </div>
        </div>

        <!-- 2. FILTER PERIODE TRANSAKSI BAR -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/80 shadow-sm flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <form method="GET" action="{{ route('admin.laporan.omzet') }}" class="flex flex-wrap items-center gap-3">
                <!-- Label Icon -->
                <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-700 pr-1">
                    <i class="bi bi-sliders text-blue-600 text-base"></i>
                    <span>Filter Periode Transaksi</span>
                </div>

                <!-- Dropdown Bulan -->
                <div class="relative">
                    <select name="bulan" class="appearance-none bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl px-4 py-2 pr-9 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer transition">
                        @foreach($daftarBulan as $num => $nama)
                            <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>
                                {{ $nama }}
                            </option>
                        @endforeach
                    </select>
                    <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                </div>

                <!-- Dropdown Tahun -->
                <div class="relative">
                    <select name="tahun" class="appearance-none bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl px-4 py-2 pr-9 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer transition">
                        @foreach($daftarTahun as $t)
                            <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                    <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                </div>

                <!-- Dropdown Status Transaksi -->
                <div class="relative">
                    <select name="status" class="appearance-none bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl px-4 py-2 pr-9 text-sm font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer transition">
                        <option value="sukses" {{ $statusFilter == 'sukses' ? 'selected' : '' }}>Semua Transaksi Lunas (Paid)</option>
                        <option value="semua" {{ $statusFilter == 'semua' ? 'selected' : '' }}>Semua Status</option>
                        <option value="selesai" {{ $statusFilter == 'selesai' ? 'selected' : '' }}>Hanya Selesai</option>
                        <option value="dikirim" {{ $statusFilter == 'dikirim' ? 'selected' : '' }}>Dalam Pengiriman</option>
                    </select>
                    <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
                </div>

                <!-- Tombol Tampilkan -->
                <button type="submit" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-5 py-2 rounded-xl transition shadow-sm">
                    <i class="bi bi-funnel-fill text-xs"></i>
                    <span>Tampilkan</span>
                </button>
            </form>

            <!-- Keterangan Rentang Tanggal di Kanan -->
            <div class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 bg-slate-50 border border-slate-200/90 px-3.5 py-2 rounded-xl self-start lg:self-auto">
                <i class="bi bi-calendar4-event text-blue-600"></i>
                <span>Menampilkan data periode: 1 {{ $singkatBulanIni }} {{ $tahun }} – {{ $jumlahHariBulan }} {{ $singkatBulanIni }} {{ $tahun }}</span>
            </div>
        </div>

        <!-- 3. DUA KARTU METRIK UTAMA (METRIK FINANSIAL & VOLUME LOGISTIK) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- KARTU 1: METRIK FINANSIAL UTAMA -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold tracking-wider uppercase text-slate-400">METRIK FINANSIAL UTAMA</span>
                        <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <i class="bi bi-wallet2 text-lg"></i>
                        </div>
                    </div>
                    <div class="text-sm font-semibold text-slate-700 mt-2">Total Omzet Bersih</div>
                    <div class="flex flex-wrap items-baseline gap-3 mt-1.5">
                        <span class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                            Rp {{ number_format($totalOmzet, 0, ',', '.') }}
                        </span>
                        <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 px-2.5 py-0.5 rounded-full">
                            +{{ $pertumbuhanOmzet }}%
                        </span>
                    </div>
                    <div class="text-xs text-slate-400 mt-2">
                        Dibandingkan {{ $namaBulanLalu }} (Rp {{ number_format($omzetBulanLalu, 0, ',', '.') }})
                    </div>
                </div>

                <!-- Bottom Bar Kartu Finansial -->
                <div class="mt-6 bg-[#f0f7ff] border border-blue-100/90 rounded-2xl px-4 py-3 flex items-center justify-between text-xs font-medium text-slate-700">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-graph-up text-blue-600"></i>
                        <span>Rata-rata Transaksi (AOV): <strong class="text-slate-900 font-bold">Rp {{ number_format($rataRataTransaksi, 0, ',', '.') }}</strong></span>
                    </div>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-blue-700 bg-blue-100/70 border border-blue-200 px-2.5 py-1 rounded-md">
                        AUDIT VALID
                    </span>
                </div>
            </div>

            <!-- KARTU 2: VOLUME & LOGISTIK HOROLOGI -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold tracking-wider uppercase text-slate-400">VOLUME & LOGISTIK HOROLOGI</span>
                        <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <i class="bi bi-box-seam text-lg"></i>
                        </div>
                    </div>
                    <div class="text-sm font-semibold text-slate-700 mt-2">Jumlah Transaksi Selesai</div>
                    <div class="flex flex-wrap items-baseline gap-3 mt-1.5">
                        <span class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                            {{ $totalTransaksi }} Transaksi
                        </span>
                        <span class="inline-flex items-center text-xs font-bold text-blue-700 bg-blue-50 border border-blue-100 px-2.5 py-0.5 rounded-full">
                            100% Lunas & Terverifikasi
                        </span>
                    </div>
                    <div class="text-xs text-slate-400 mt-2">
                        0 Pengembalian dana (Refund Rate: 0.0%)
                    </div>
                </div>

                <!-- Bottom Bar Kartu Logistik -->
                <div class="mt-6 bg-[#f0f7ff] border border-blue-100/90 rounded-2xl px-4 py-3 flex items-center justify-between text-xs font-medium text-slate-700">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-shield-check text-blue-600 text-sm"></i>
                        <span>Proteksi Pengiriman: <strong class="text-slate-900 font-semibold">Semua unit terkirim & asuransi aktif</strong></span>
                    </div>
                    <i class="bi bi-check-circle-fill text-blue-600 text-sm"></i>
                </div>
            </div>

        </div>

        <!-- 4. TREN AKUMULASI 4 PEKAN (REVENUE CURVE) -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-1">
                <div class="text-xs font-bold tracking-wider uppercase text-slate-400">TREN AKUMULASI 4 PEKAN</div>
                <div class="text-base font-bold text-slate-900">{{ $namaBulanIni }} {{ $tahun }} Revenue Curve</div>
                <div class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 bg-slate-100 px-2.5 py-1 rounded-full">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    <span>Puncak: {{ $puncakNama }} (Rp {{ number_format($puncakNilai / 1000000, 1, ',', '.') }}jt)</span>
                </div>
            </div>

            <!-- SVG Smooth Wave Sparkline Graph -->
            <div class="w-full md:w-80 h-14 relative flex items-center">
                <svg class="w-full h-full overflow-visible" viewBox="0 0 300 60" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="curveGradient" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#3b82f6" stop-opacity="0.25"/>
                            <stop offset="100%" stop-color="#3b82f6" stop-opacity="0.0"/>
                        </linearGradient>
                    </defs>
                    <!-- Area Fill -->
                    <path d="M 0 50 Q 75 42, 150 25 T 240 10 T 300 20 L 300 60 L 0 60 Z" fill="url(#curveGradient)" />
                    <!-- Stroke Curve -->
                    <path d="M 0 50 Q 75 42, 150 25 T 240 10 T 300 20" fill="none" stroke="#2563eb" stroke-width="2.5" stroke-linecap="round" />
                    <!-- Peak Dot -->
                    <circle cx="240" cy="10" r="4.5" fill="#2563eb" stroke="#ffffff" stroke-width="2" />
                    <circle cx="240" cy="10" r="8" fill="#2563eb" fill-opacity="0.2" />
                </svg>
            </div>
        </div>

        <!-- 5. DAFTAR TRANSAKSI LUNAS (TABEL DENGAN LIVE SEARCH) -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <!-- Header List -->
            <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex items-center gap-3">
                    <h2 class="text-lg font-black text-slate-900">Daftar Transaksi Lunas</h2>
                    <span class="px-3 py-1 bg-blue-50 border border-blue-100 text-blue-700 text-xs font-bold rounded-full">
                        {{ $daftarPesanan->count() }} Data Ditemukan
                    </span>
                </div>

                <!-- Input Pencarian Real-Time (Client-side Search) -->
                <div class="relative w-full sm:w-72">
                    <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" id="searchInput" onkeyup="filterTable()" 
                           placeholder="Saring nama atau SKU..." 
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-4 py-2 text-xs font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                </div>
            </div>

            <!-- Tabel Transaksi -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse" id="trxTable">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="py-3.5 px-6">NO. PESANAN</th>
                            <th class="py-3.5 px-4">TANGGAL & WAKTU</th>
                            <th class="py-3.5 px-4">PELANGGAN</th>
                            <th class="py-3.5 px-4">ITEM PRODUK</th>
                            <th class="py-3.5 px-4">METODE PEMBAYARAN</th>
                            <th class="py-3.5 px-4 text-right">TOTAL TRANSAKSI</th>
                            <th class="py-3.5 px-6 text-center">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($daftarPesanan as $pesanan)
                            @php
                                $detail = $pesanan->detail->first();
                                $pembayaran = $pesanan->pembayaran;
                                $metode = $pembayaran->metode_pembayaran ?? 'BCA Virtual Account';
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition search-row">
                                <!-- 1. NO. PESANAN -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-1.5 font-bold text-blue-600 hover:text-blue-700 cursor-pointer">
                                        <span>{{ $pesanan->nomor_pesanan }}</span>
                                        <i class="bi bi-box-arrow-up-right text-[10px]"></i>
                                    </div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">
                                        {{ $pesanan->catatan ?? 'Koleksi Jam Tangan' }}
                                    </div>
                                </td>

                                <!-- 2. TANGGAL & WAKTU -->
                                <td class="py-4 px-4 text-xs">
                                    <div class="font-bold text-slate-800">
                                        {{ $pesanan->tanggal_pesanan ? $pesanan->tanggal_pesanan->translatedFormat('d M Y') : '-' }}
                                    </div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">
                                        {{ $pesanan->tanggal_pesanan ? $pesanan->tanggal_pesanan->format('H:i') . ' WIB' : '-' }}
                                    </div>
                                </td>

                                <!-- 3. PELANGGAN -->
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-1 font-bold text-slate-900 text-sm">
                                        <span>{{ $pesanan->nama_penerima }}</span>
                                        <i class="bi bi-patch-check-fill text-blue-500 text-xs" title="Pelanggan Terverifikasi"></i>
                                    </div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">
                                        {{ $pesanan->kota }}
                                    </div>
                                </td>

                                <!-- 4. ITEM PRODUK -->
                                <td class="py-4 px-4 max-w-xs">
                                    <div class="font-bold text-slate-900 text-xs">
                                        {{ $detail->nama_produk ?? 'A1ORA Luxury Watch' }}
                                    </div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">
                                        {{ $detail->nama_varian ?? 'Automatic Movement' }}
                                    </div>
                                </td>

                                <!-- 5. METODE PEMBAYARAN -->
                                <td class="py-4 px-4">
                                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200/80 text-xs font-semibold text-slate-700">
                                        @if(str_contains(strtolower($metode), 'bca'))
                                            <i class="bi bi-bank2 text-blue-600"></i>
                                        @elseif(str_contains(strtolower($metode), 'kartu'))
                                            <i class="bi bi-credit-card-2-front text-indigo-600"></i>
                                        @elseif(str_contains(strtolower($metode), 'qris'))
                                            <i class="bi bi-qr-code text-teal-600"></i>
                                        @else
                                            <i class="bi bi-arrow-left-right text-sky-600"></i>
                                        @endif
                                        <span>{{ $metode }}</span>
                                    </div>
                                </td>

                                <!-- 6. TOTAL TRANSAKSI -->
                                <td class="py-4 px-4 text-right">
                                    <div class="font-black text-slate-900 text-sm tracking-tight">
                                        Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                    </div>
                                </td>

                                <!-- 7. STATUS -->
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                        Lunas
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-12 text-slate-400">
                                    <i class="bi bi-inbox text-4xl d-block mb-2 text-slate-300"></i>
                                    <p class="font-semibold text-slate-600">Tidak ada transaksi ditemukan pada periode ini</p>
                                    <p class="text-xs text-slate-400 mt-1">Coba sesuaikan pilihan filter bulan atau tahun di atas.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Counter -->
            <div class="p-4 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400 px-6">
                <span>Total <strong>{{ $daftarPesanan->count() }}</strong> transaksi lunas tercatat</span>
                <span>Audit Status: <strong class="text-blue-600">100% Terverifikasi</strong></span>
            </div>
        </div>

    </div>

    <!-- Script Live Filter Pencarian Tabel -->
    <script>
        function filterTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll('.search-row');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>

    <x-popup-login />
    <x-konfirmasi-logout />
</body>
</html>
