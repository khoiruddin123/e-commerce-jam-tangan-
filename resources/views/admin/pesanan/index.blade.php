<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan & Pengiriman - Logistik Presisi | Panel Admin A1ORA</title>
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

        /* Print Media Styles for Official Shipping Manifest */
        .print-only {
            display: none !important;
        }
        .print-only-cell {
            display: none !important;
        }

        @media print {
            @page {
                size: landscape;
                margin: 8mm 10mm;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            html, body {
                background: #ffffff !important;
                color: #0f172a !important;
                font-size: 11px !important;
                margin: 0 !important;
                padding: 0 !important;
                display: block !important;
                min-height: auto !important;
                width: 100% !important;
            }

            /* 1. Sembunyikan elemen dashboard & antarmuka admin */
            aside,
            header,
            footer,
            nav,
            .no-print,
            .col-aksi-logistik,
            #modalInputResi,
            #modalDetailPesanan,
            [id*="modal"],
            [id*="popup"],
            [id*="logout"] {
                display: none !important;
            }

            /* 2. Tampilkan elemen dokumen manifest */
            .print-only {
                display: block !important;
            }
            .print-only-cell {
                display: table-cell !important;
            }

            /* 3. Pastikan layout utama membentang penuh tanpa scrollbar */
            .admin-main-wrapper,
            main {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: visible !important;
            }

            /* 4. Format tabel manifest resmi */
            .manifest-table-card {
                border: 1px solid #94a3b8 !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                overflow: visible !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .manifest-table-card > div {
                overflow: visible !important;
            }

            table.manifest-table {
                width: 100% !important;
                border-collapse: collapse !important;
                font-size: 10.5px !important;
            }

            table.manifest-table th,
            table.manifest-table td {
                border: 1px solid #cbd5e1 !important;
                padding: 6px 8px !important;
                page-break-inside: avoid !important;
                vertical-align: top !important;
            }

            table.manifest-table thead tr {
                background-color: #f1f5f9 !important;
                color: #0f172a !important;
                border-bottom: 2px solid #0f172a !important;
            }

            table.manifest-table thead th {
                font-size: 9.5px !important;
                font-weight: 800 !important;
                text-transform: uppercase !important;
                letter-spacing: 0.05em !important;
            }

            .signature-section {
                page-break-inside: avoid !important;
            }
        }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 antialiased flex min-h-screen">

    <!-- 1. SIDEBAR NAVIGASI HITAM PEKAT / DARK NAVY (SESUAI MOCKUP) -->
    <aside class="no-print w-64 bg-[#0B1120] text-slate-300 flex flex-col justify-between shrink-0 min-h-screen border-r border-slate-900 sticky top-0 h-screen overflow-y-auto">
        <div class="p-5">
            <!-- Brand Logo A1ORA ADMIN PORTAL -->
            <div class="mb-8 px-1">
                <a href="{{ route('admin.dashboard') }}" class="block">
                    <img src="{{ asset('images/logo-white.png') }}" alt="A1ORA" class="h-8 w-auto object-contain">
                    <div class="text-[10px] tracking-widest text-slate-400 font-semibold uppercase mt-1.5">ADMIN PORTAL</div>
                </a>
            </div>

            <!-- Menu Heading -->
            <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3 mb-3">
                MENU NAVIGASI
            </div>

            <!-- Nav Links List (Tanpa Setting & Laporan) -->
            <nav class="space-y-1 text-xs font-semibold">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 transition">
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

                <!-- Pesanan & Pengiriman (Active) -->
                <a href="{{ route('admin.pesanan.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold shadow-sm transition">
                    <i class="bi bi-truck text-sm"></i>
                    <span>Pesanan & Pengiriman</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer: Status Butik & Tombol Keluar -->
        <div class="p-4 space-y-4">
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

            <button type="button" data-logout-trigger class="w-full flex items-center gap-2.5 text-slate-400 hover:text-rose-400 hover:bg-slate-800/40 px-3 py-2 rounded-xl text-xs font-semibold transition cursor-pointer">
                <i class="bi bi-box-arrow-left text-sm"></i>
                <span>Keluar</span>
            </button>
        </div>
    </aside>

    <!-- 2. MAIN CONTENT AREA (KANAN) -->
    <div class="admin-main-wrapper flex-1 flex flex-col min-w-0 overflow-y-auto">

        <!-- Top Header Bar -->
        <header class="no-print bg-white border-b border-slate-200/80 sticky top-0 z-30 px-6 py-3.5 flex items-center justify-between gap-4">
            <div class="relative w-72 sm:w-96">
                <i class="bi bi-search absolute left-3.5 top-2.5 text-slate-400 text-xs"></i>
                <input type="text" placeholder="Cari pesanan, pembeli, atau resi..." 
                       class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-3.5 py-2 text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>

            <div class="flex items-center gap-4 sm:gap-6">
                <div class="hidden md:inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200/70 text-[11px] font-semibold px-3 py-1 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>Butik Terhubung</span>
                </div>

                <div class="flex items-center gap-3 pl-2 border-l border-slate-200">
                    <div class="text-right hidden sm:block">
                        <div class="text-xs font-bold text-slate-900 leading-tight">
                            {{ Auth::user()->nama ?? 'Admin' }}
                        </div>
                        <div class="text-[10px] text-slate-400 font-medium">
                            {{ ucfirst(Auth::user()->role ?? 'Super Admin') }}
                        </div>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center shadow-sm">
                        {{ strtoupper(substr(Auth::user()->nama ?? 'AD', 0, 2)) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Body Container -->
        <main class="p-6 sm:p-8 space-y-6 max-w-7xl w-full mx-auto flex-1">

        <!-- Flash Message Notifikasi -->
        @if(session('success'))
            <div class="no-print bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl text-sm flex items-center justify-between shadow-sm animate-in fade-in duration-200">
                <div class="flex items-center gap-2.5">
                    <i class="bi bi-check-circle-fill text-emerald-600 text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="no-print bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-sm space-y-1 shadow-sm">
                @foreach($errors->all() as $error)
                    <div class="flex items-center gap-2">
                        <i class="bi bi-exclamation-circle-fill text-rose-600"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Header Judul & Action Buttons (Sesuai Referensi) -->
        <div class="no-print flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
            <div>
                <div class="text-[11px] font-extrabold uppercase tracking-widest text-blue-600 flex items-center gap-1.5 mb-1">
                    <span class="inline-block w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    <span>LOGISTIK & DISTRIBUSI PRESISI</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    Pesanan & Pengiriman
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-2xl">
                    Kelola verifikasi transaksi, status pemrosesan jam tangan butik, dan input nomor resi kurir logistik.
                </p>
            </div>

            <div class="flex items-center gap-3 w-full sm:w-auto">
                <button type="button" onclick="window.print()" class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 px-4 py-2.5 rounded-xl text-xs font-bold shadow-sm transition">
                    <i class="bi bi-download"></i>
                    <span>Ekspor Manifest</span>
                </button>
                <a href="{{ route('admin.dashboard') }}" class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl text-xs font-bold shadow-sm hover:shadow transition">
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </div>
        </div>

        <!-- 4 Top Metric Cards (Sesuai Desain Referensi) -->
        <div class="no-print grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            <!-- Card 1: Total Pesanan -->
            <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm relative overflow-hidden">
                <div class="flex justify-between items-start">
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400">TOTAL PESANAN</div>
                    <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm">
                        <i class="bi bi-receipt"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-slate-900 tracking-tight">{{ $totalPesanan }}</span>
                    <span class="text-xs text-slate-500 font-medium">Transaksi</span>
                </div>
                <div class="mt-3 text-[11px] font-semibold text-emerald-600 flex items-center gap-1">
                    <i class="bi bi-graph-up-arrow"></i>
                    <span>+12% dibanding bulan lalu</span>
                </div>
            </div>

            <!-- Card 2: Perlu Diproses -->
            <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm relative overflow-hidden">
                <div class="flex justify-between items-start">
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400">PERLU DIPROSES</div>
                    <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm">
                        <i class="bi bi-box-seam"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-blue-600 tracking-tight">{{ $perluDiproses }}</span>
                    <span class="text-xs text-slate-500 font-medium">Pesanan</span>
                </div>
                <div class="mt-3 text-[11px] font-semibold text-blue-600 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                    <span>Butuh QC & Packing Hari Ini</span>
                </div>
            </div>

            <!-- Card 3: Dalam Pengiriman -->
            <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm relative overflow-hidden">
                <div class="flex justify-between items-start">
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400">DALAM PENGIRIMAN</div>
                    <div class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-sm">
                        <i class="bi bi-truck"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-slate-900 tracking-tight">{{ $dalamPengiriman }}</span>
                    <span class="text-xs text-slate-500 font-medium">Pesanan</span>
                </div>
                <div class="mt-3 text-[11px] font-semibold text-slate-500 flex items-center gap-1">
                    <i class="bi bi-pin-map"></i>
                    <span>JNE Reguler, YES & Paxel</span>
                </div>
            </div>

            <!-- Card 4: Selesai -->
            <div class="bg-white p-5 rounded-3xl border border-slate-200/90 shadow-sm relative overflow-hidden">
                <div class="flex justify-between items-start">
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400">SELESAI</div>
                    <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm">
                        <i class="bi bi-patch-check"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-slate-900 tracking-tight">{{ $selesai }}</span>
                    <span class="text-xs text-slate-500 font-medium">Pesanan</span>
                </div>
                <div class="mt-3 text-[11px] font-semibold text-emerald-600 flex items-center gap-1">
                    <i class="bi bi-check-all text-sm"></i>
                    <span>Konfirmasi Pelanggan 100%</span>
                </div>
            </div>
        </div>

        <!-- Filter Tabs & Search Controls (Sesuai Referensi) -->
        <div class="no-print bg-white p-4 sm:p-5 rounded-3xl border border-slate-200/90 shadow-sm space-y-4">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                
                <!-- Status Filter Pills -->
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('admin.pesanan.index', array_merge(request()->except('status', 'page'), ['status' => 'semua'])) }}"
                       class="px-4 py-2 rounded-full text-xs font-bold transition flex items-center gap-1.5 {{ $status === 'semua' ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                        <span>Semua</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $status === 'semua' ? 'bg-blue-700 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $countSemua }}</span>
                    </a>

                    <a href="{{ route('admin.pesanan.index', array_merge(request()->except('status', 'page'), ['status' => 'dibayar'])) }}"
                       class="px-4 py-2 rounded-full text-xs font-bold transition flex items-center gap-1.5 {{ $status === 'dibayar' ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                        <span>Dibayar</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $status === 'dibayar' ? 'bg-blue-700 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $countDibayar }}</span>
                    </a>

                    <a href="{{ route('admin.pesanan.index', array_merge(request()->except('status', 'page'), ['status' => 'diproses'])) }}"
                       class="px-4 py-2 rounded-full text-xs font-bold transition flex items-center gap-1.5 {{ $status === 'diproses' ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                        <span>Diproses</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $status === 'diproses' ? 'bg-blue-700 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $countDiproses }}</span>
                    </a>

                    <a href="{{ route('admin.pesanan.index', array_merge(request()->except('status', 'page'), ['status' => 'dikirim'])) }}"
                       class="px-4 py-2 rounded-full text-xs font-bold transition flex items-center gap-1.5 {{ $status === 'dikirim' ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                        <span>Dikirim</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $status === 'dikirim' ? 'bg-blue-700 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $countDikirim }}</span>
                    </a>

                    <a href="{{ route('admin.pesanan.index', array_merge(request()->except('status', 'page'), ['status' => 'selesai'])) }}"
                       class="px-4 py-2 rounded-full text-xs font-bold transition flex items-center gap-1.5 {{ $status === 'selesai' ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }}">
                        <span>Selesai</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $status === 'selesai' ? 'bg-blue-700 text-white' : 'bg-slate-200 text-slate-700' }}">{{ $countSelesai }}</span>
                    </a>
                </div>

                <!-- Form Search & Filters -->
                <form action="{{ route('admin.pesanan.index') }}" method="GET" class="flex flex-wrap sm:flex-nowrap items-center gap-3 w-full lg:w-auto">
                    <input type="hidden" name="status" value="{{ $status }}">

                    <!-- Search Input -->
                    <div class="relative flex-1 sm:w-64">
                        <i class="bi bi-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari No. Pesanan / Resi..."
                               class="w-full bg-slate-50 hover:bg-slate-100/70 focus:bg-white text-xs pl-9 pr-3.5 py-2.5 rounded-2xl border border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                    </div>

                    <!-- Dropdown Kurir -->
                    <div class="relative">
                        <select name="kurir" onchange="this.form.submit()"
                                class="bg-slate-50 hover:bg-slate-100/70 focus:bg-white text-xs px-3.5 py-2.5 rounded-2xl border border-slate-200 focus:border-blue-500 outline-none transition cursor-pointer font-medium text-slate-700">
                            <option value="semua">Semua Kurir</option>
                            @foreach($daftarKurir as $k)
                                <option value="{{ $k }}" {{ $kurir === $k ? 'selected' : '' }}>{{ $k }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if($search || ($kurir && $kurir !== 'semua'))
                        <a href="{{ route('admin.pesanan.index', ['status' => $status]) }}" 
                           class="p-2.5 rounded-2xl bg-rose-50 text-rose-600 hover:bg-rose-100 transition text-xs" title="Reset Filter">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    @endif
                </form>

            </div>
        </div>

        <!-- DOKUMEN RESMI: MANIFEST SERAH TERIMA PENGIRIMAN LOGISTIK (HANYA MUNCUL SAAT CETAK / EKSPOR MANIFEST) -->
        <div class="print-only mb-4">
            <div class="border-b-2 border-slate-900 pb-3 mb-3">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="A1ORA" class="h-9 w-auto object-contain" onerror="this.src='{{ asset('images/logo-icon.png') }}'">
                        <div>
                            <h1 class="text-lg font-black tracking-wider text-slate-900 leading-tight">A1ORA WATCH BOUTIQUE & HOROLOGY JAKARTA</h1>
                            <p class="text-[9.5px] text-slate-600 font-semibold tracking-wider uppercase">Divisi Operasional Vault & Distribusi Logistik Presisi</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="inline-block bg-slate-900 text-white text-[9px] font-black uppercase px-2.5 py-1 tracking-widest rounded">
                            MANIFEST SERAH TERIMA LOGISTIK
                        </div>
                        <p class="text-[10px] font-mono font-bold text-slate-700 mt-1">REF: MNF-{{ now()->format('Ymd-His') }}</p>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Filter & Meta Manifest -->
            <div class="grid grid-cols-4 gap-3 p-2.5 bg-slate-50 border border-slate-300 text-[10px] mb-2 rounded">
                <div>
                    <span class="text-slate-500 block text-[8.5px] uppercase font-bold">Waktu Cetak:</span>
                    <strong class="text-slate-900">{{ now()->translatedFormat('d F Y, H:i') }} WIB</strong>
                </div>
                <div>
                    <span class="text-slate-500 block text-[8.5px] uppercase font-bold">Status Pesanan:</span>
                    <strong class="text-slate-900 uppercase">{{ $status === 'semua' ? 'Semua Status' : str_replace('_', ' ', $status) }}</strong>
                </div>
                <div>
                    <span class="text-slate-500 block text-[8.5px] uppercase font-bold">Ekspedisi Logistik:</span>
                    <strong class="text-slate-900 uppercase">{{ $kurir && $kurir !== 'semua' ? $kurir : 'Semua Kurir' }}</strong>
                </div>
                <div>
                    <span class="text-slate-500 block text-[8.5px] uppercase font-bold">Total Paket:</span>
                    <strong class="text-slate-900">{{ $daftarPesanan->total() }} Paket Transaksi</strong>
                </div>
            </div>
        </div>

        <!-- Table Card (Sesuai Kolom & Desain Referensi) -->
        <div class="manifest-table-card bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="manifest-table w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                            <th class="py-4 px-6">NO. PESANAN</th>
                            <th class="py-4 px-6">PELANGGAN & ALAMAT</th>
                            <th class="py-4 px-6">TANGGAL TRANSAKSI</th>
                            <th class="py-4 px-6">TOTAL & JUMLAH</th>
                            <th class="py-4 px-6">STATUS & RESI</th>
                            <th class="py-4 px-6 text-center no-print col-aksi-logistik">AKSI LOGISTIK</th>
                            <th class="py-2 px-3 text-center print-only-cell">CEK FISIK</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($daftarPesanan as $pesanan)
                            @php
                                $userPesanan = $pesanan->user;
                                $namaPelanggan = $pesanan->nama_penerima ?? ($userPesanan->nama ?? 'Tamu');
                                $emailPelanggan = $userPesanan->email ?? '-';
                                $teleponPelanggan = $pesanan->telepon_penerima ?? ($userPesanan->no_telepon ?? '-');
                                
                                // Inisial Pelanggan
                                $initials = '';
                                $words = explode(' ', trim($namaPelanggan));
                                foreach(array_slice($words, 0, 2) as $w) {
                                    $initials .= strtoupper(substr($w, 0, 1));
                                }

                                // Warna Avatar Acak Terstruktur
                                $colors = ['bg-blue-100 text-blue-700', 'bg-slate-800 text-white', 'bg-indigo-100 text-indigo-700', 'bg-sky-100 text-sky-800', 'bg-emerald-100 text-emerald-800'];
                                $colorClass = $colors[$pesanan->pesanan_id % count($colors)];

                                // Metode Pembayaran
                                $metodeBayar = $pesanan->pembayaran->metode_pembayaran ?? 'BCA Virtual Account';
                            @endphp
                            <tr class="hover:bg-slate-50/60 transition">
                                
                                <!-- Kolom 1: No. Pesanan & Metode -->
                                <td class="py-4 px-6 align-top">
                                    <div class="flex items-center gap-1.5 font-bold text-blue-600 font-mono text-xs">
                                        <span>#{{ $pesanan->nomor_pesanan }}</span>
                                        <button type="button" onclick="copyText('{{ $pesanan->nomor_pesanan }}', this)" 
                                                class="text-slate-400 hover:text-blue-600 transition no-print" title="Salin No. Pesanan">
                                            <i class="bi bi-clipboard text-[11px]"></i>
                                        </button>
                                    </div>
                                    <div class="text-[11px] text-slate-400 mt-1 font-medium">
                                        {{ $metodeBayar }}
                                    </div>
                                </td>

                                <!-- Kolom 2: Pelanggan -->
                                <td class="py-4 px-6 align-top">
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-full {{ $colorClass }} font-black text-xs flex items-center justify-center flex-shrink-0 mt-0.5 no-print">
                                            {{ $initials ?: 'CU' }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900 text-xs">{{ $namaPelanggan }}</div>
                                            <div class="text-[11px] text-slate-400 mt-0.5">{{ $emailPelanggan }}</div>
                                            <div class="text-[11px] text-slate-400 font-mono">{{ $teleponPelanggan }}</div>
                                            
                                            <!-- Ringkasan Alamat Tujuan (Layar) -->
                                            <div class="text-[11px] text-slate-600 mt-1 flex items-start gap-1 font-medium bg-slate-100/90 px-2 py-0.5 rounded-lg max-w-[220px] no-print" title="{{ $pesanan->alamat_pengiriman }}, {{ $pesanan->kota }} {{ $pesanan->kode_pos }}">
                                                <i class="bi bi-geo-alt text-blue-600 flex-shrink-0 mt-0.5 text-[10px]"></i>
                                                <span class="truncate">{{ $pesanan->kota ?? 'Kota' }} &bull; {{ $pesanan->alamat_pengiriman ?? '-' }}</span>
                                            </div>

                                            <!-- Alamat Lengkap (Cetak Manifest) -->
                                            <div class="print-only text-[10px] text-slate-800 mt-1 leading-snug">
                                                <strong>{{ $pesanan->kota ?? 'Kota' }}</strong>, {{ $pesanan->alamat_pengiriman ?? '-' }} (Kode Pos: {{ $pesanan->kode_pos ?? '-' }})
                                            </div>

                                            <!-- Catatan Pembeli (Jika Ada) -->
                                            @if($pesanan->catatan)
                                                <div class="text-[10px] text-amber-700 mt-0.5 italic flex items-center gap-1 font-medium no-print" title="Catatan: {{ $pesanan->catatan }}">
                                                    <i class="bi bi-chat-left-text text-amber-600 flex-shrink-0"></i>
                                                    <span class="truncate max-w-[200px]">"{{ $pesanan->catatan }}"</span>
                                                </div>
                                                <div class="print-only text-[9.5px] text-amber-900 mt-0.5 italic">
                                                    <strong>Catatan:</strong> "{{ $pesanan->catatan }}"
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Kolom 3: Tanggal Transaksi -->
                                <td class="py-4 px-6 align-top text-slate-600">
                                    <div class="font-semibold text-slate-800">
                                        {{ $pesanan->tanggal_pesanan ? $pesanan->tanggal_pesanan->translatedFormat('d M Y') : '-' }}
                                    </div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">
                                        {{ $pesanan->tanggal_pesanan ? $pesanan->tanggal_pesanan->format('H:i') . ' WIB' : '' }}
                                    </div>
                                </td>

                                <!-- Kolom 4: Total & Jumlah Produk -->
                                <td class="py-4 px-6 align-top">
                                    <div class="font-black text-slate-900 text-xs">
                                        Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                    </div>
                                    <div class="text-[11px] text-slate-500 mt-0.5 line-clamp-1 no-print">
                                        {{ $pesanan->detail->count() }} Item 
                                        @if($pesanan->detail->isNotEmpty())
                                            ({{ $pesanan->detail->first()->nama_produk }})
                                        @endif
                                    </div>
                                    <div class="print-only text-[9.5px] text-slate-700 mt-1 space-y-0.5">
                                        <div class="font-bold text-slate-500 text-[8.5px] uppercase">{{ $pesanan->detail->count() }} Item Jam:</div>
                                        @foreach($pesanan->detail as $itemDet)
                                            <div>&bull; {{ $itemDet->nama_produk }} <span class="font-semibold text-slate-900">({{ $itemDet->jumlah }}x)</span></div>
                                        @endforeach
                                    </div>
                                </td>

                                <!-- Kolom 5: Status & Resi -->
                                <td class="py-4 px-6 align-top">
                                    @php
                                        $dataPengiriman = $pesanan->pengiriman;
                                        $namaKurir = $dataPengiriman?->nama_kurir;
                                        $nomorResi = $dataPengiriman?->nomor_resi;
                                    @endphp
                                    <div>
                                        @if($pesanan->status_pesanan === 'dibayar')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                                Dibayar
                                            </span>
                                            <div class="text-[11px] text-slate-400 italic mt-1">Menunggu Alokasi Vault</div>
                                        @elseif($pesanan->status_pesanan === 'diproses')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-300">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                                Diproses
                                            </span>
                                            <div class="text-[11px] text-slate-500 mt-1 flex items-center gap-1">
                                                <i class="bi bi-shield-check text-blue-600"></i>
                                                <span>QC Lulus - Siap Resi</span>
                                            </div>
                                        @elseif($pesanan->status_pesanan === 'dikirim')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-sky-600"></span>
                                                Dikirim
                                            </span>
                                            @if($nomorResi)
                                                <div class="mt-1 flex items-center gap-1.5 text-[11px] text-slate-600">
                                                    <i class="bi bi-truck text-sky-600"></i>
                                                    <span class="font-bold text-slate-800">{{ $namaKurir ?? 'JNE' }}:</span>
                                                    <span class="font-mono font-bold text-slate-900">{{ $nomorResi }}</span>
                                                    <button type="button" onclick="copyText('{{ $nomorResi }}', this)" class="text-slate-400 hover:text-blue-600 no-print" title="Salin Resi">
                                                        <i class="bi bi-clipboard text-[10px]"></i>
                                                    </button>
                                                </div>
                                            @else
                                                <div class="text-[11px] text-amber-600 italic mt-1">Belum input resi</div>
                                            @endif
                                        @elseif($pesanan->status_pesanan === 'selesai')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                                Selesai
                                            </span>
                                            @if($nomorResi)
                                                <div class="mt-1 text-[11px] text-slate-400 font-mono">
                                                    {{ $namaKurir }}: {{ $nomorResi }}
                                                </div>
                                            @endif
                                        @elseif($pesanan->status_pesanan === 'menunggu_pembayaran')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                Menunggu Pembayaran
                                            </span>
                                            <div class="text-[11px] text-amber-600 italic mt-1">
                                                Batas: {{ $pesanan->pembayaran?->batas_pembayaran ? $pesanan->pembayaran->batas_pembayaran->translatedFormat('H:i') . ' WIB' : '15 Menit' }}
                                            </div>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>
                                                Dibatalkan
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Kolom 6: Aksi Cepat Terarah (Guided Workflow Sesuai SOP) -->
                                <td class="py-4 px-6 align-top text-center no-print col-aksi-logistik">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Tombol Lihat Rincian Lengkap, Alamat & Catatan -->
                                        <button type="button" 
                                                onclick="openModalDetail({{ $pesanan->pesanan_id }})" 
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 shadow-2xs transition active:scale-95"
                                                title="Lihat Alamat Lengkap, Catatan & Rincian Pesanan">
                                            <i class="bi bi-eye text-blue-600"></i>
                                            <span>Detail</span>
                                        </button>

                                        <!-- Hidden Data JSON Pesanan -->
                                        <script type="application/json" id="data-pesanan-{{ $pesanan->pesanan_id }}">
                                            {!! json_encode([
                                                'id' => $pesanan->pesanan_id,
                                                'nomor' => $pesanan->nomor_pesanan,
                                                'status' => $pesanan->status_pesanan,
                                                'tanggal' => $pesanan->tanggal_pesanan ? $pesanan->tanggal_pesanan->translatedFormat('d F Y, H:i') . ' WIB' : '-',
                                                'nama_penerima' => $namaPelanggan,
                                                'telepon_penerima' => $teleponPelanggan,
                                                'email' => $emailPelanggan,
                                                'alamat' => $pesanan->alamat_pengiriman ?? '-',
                                                'kota' => $pesanan->kota ?? '-',
                                                'kode_pos' => $pesanan->kode_pos ?? '-',
                                                'catatan' => $pesanan->catatan ?? '',
                                                'subtotal' => 'Rp ' . number_format($pesanan->subtotal, 0, ',', '.'),
                                                'ongkir' => 'Rp ' . number_format($pesanan->ongkir, 0, ',', '.'),
                                                'total' => 'Rp ' . number_format($pesanan->total_harga, 0, ',', '.'),
                                                'metode_bayar' => $metodeBayar,
                                                'status_bayar' => $pesanan->pembayaran?->status_pembayaran ?? 'menunggu',
                                                'kurir' => $namaKurir ?? '-',
                                                'resi' => $nomorResi ?? '-',
                                                'cetak_url' => route('pembayaran.cetak', $pesanan->pesanan_id),
                                                'items' => $pesanan->detail->map(function($d) {
                                                    return [
                                                        'nama_produk' => $d->nama_produk,
                                                        'nama_varian' => $d->nama_varian ?? 'Standard',
                                                        'kode_sku' => $d->kode_sku ?? '-',
                                                        'qty' => $d->jumlah,
                                                        'harga' => 'Rp ' . number_format($d->harga_satuan, 0, ',', '.'),
                                                        'subtotal' => 'Rp ' . number_format($d->subtotal, 0, ',', '.'),
                                                    ];
                                                })->values()
                                            ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}
                                        </script>
                                        @if($pesanan->status_pesanan === 'dibayar')
                                            <!-- Tombol Mulai Proses (QC & Packing) -->
                                            <form action="{{ route('admin.pesanan.updateStatus', $pesanan->pesanan_id) }}" method="POST" class="inline" onsubmit="return confirm('Mulai proses QC dan pengepakan butik untuk pesanan #{{ $pesanan->nomor_pesanan }}?')">
                                                @csrf
                                                <input type="hidden" name="status_pesanan" value="diproses">
                                                <button type="submit" 
                                                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm transition"
                                                        title="Mulai proses QC dan pengepakan butik">
                                                    <i class="bi bi-box-seam-fill"></i>
                                                    <span>Mulai Proses</span>
                                                </button>
                                            </form>
                                        @elseif($pesanan->status_pesanan === 'diproses')
                                            <!-- Tombol Input / Edit Resi (Bebas diedit saat diproses/packing) -->
                                            <button type="button" 
                                                    onclick="openModalResi('{{ $pesanan->pesanan_id }}', '{{ $pesanan->nomor_pesanan }}', '{{ addslashes($namaKurir ?? 'JNE Express') }}', '{{ addslashes($nomorResi ?? '') }}', '{{ $pesanan->status_pesanan }}')"
                                                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white shadow-sm transition"
                                                    title="Input nomor resi kurir logistik (otomatis beralih ke status Dikirim)">
                                                <i class="bi bi-truck"></i>
                                                <span>{{ $nomorResi ? 'Ubah Resi' : 'Input Resi' }}</span>
                                            </button>
                                        @elseif($pesanan->status_pesanan === 'dikirim')
                                            <!-- Resi Terkunci Saat Paket Sudah Dikirim -->
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200"
                                                  title="Nomor resi telah TERKUNCI PERMANEN karena paket sudah diserahkan ke kurir logistik">
                                                <i class="bi bi-truck text-sky-600"></i>
                                                <span>Dalam Pengiriman</span>
                                            </span>
                                        @elseif($pesanan->status_pesanan === 'selesai')
                                            <!-- Selesai Dikonfirmasi Pembeli -->
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200"
                                                  title="Pesanan telah diterima dan diselesaikan oleh pembeli">
                                                <i class="bi bi-patch-check-fill text-emerald-600"></i>
                                                <span>Selesai (Pembeli)</span>
                                            </span>
                                        @elseif($pesanan->status_pesanan === 'menunggu_pembayaran')
                                            <!-- Menunggu Pembeli Bayar -->
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200"
                                                  title="Pesanan belum dibayar oleh pembeli. Admin menunggu verifikasi sistem atau kedaluwarsa.">
                                                <i class="bi bi-hourglass-split text-amber-600"></i>
                                                <span>Menunggu Pembeli</span>
                                            </span>
                                        @else
                                            <!-- Dibatalkan -->
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200"
                                                  title="Pesanan telah dibatalkan / kedaluwarsa">
                                                <i class="bi bi-x-circle text-rose-600"></i>
                                                <span>Dibatalkan</span>
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Kolom Khusus Cetak: Checklist Fisik / Paraf Kurir -->
                                <td class="py-3 px-3 align-middle text-center print-only-cell">
                                    <div style="width: 18px; height: 18px; border: 1.5px solid #475569; margin: 0 auto; border-radius: 3px;"></div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-400">
                                    <i class="bi bi-inbox text-4xl d-block mb-2 text-slate-300"></i>
                                    <div class="font-bold text-slate-600">Tidak ada pesanan ditemukan</div>
                                    <div class="text-xs text-slate-400 mt-1">Coba sesuaikan filter status atau kata kunci pencarian.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- DOKUMEN TANDA TANGAN & SERAH TERIMA MANIFEST (HANYA MUNCUL SAAT CETAK) -->
            <div class="print-only signature-section p-4 pt-5 border-t border-slate-300">
                <div class="p-2.5 bg-slate-50 border border-slate-300 text-[9.5px] text-slate-600 mb-4 leading-relaxed rounded">
                    <strong>Pernyataan Serah Terima:</strong> Paket butik jam tangan terlampir telah melalui proses Quality Control (QC), segel keamanan (security seal) butik dalam kondisi utuh, dan diserahterimakan kepada pihak kurir ekspedisi logistik untuk diteruskan ke alamat pemesan.
                </div>

                <div class="grid grid-cols-2 gap-8 text-center text-xs">
                    <!-- Kolom Pihak Menyerahkan -->
                    <div class="border border-slate-300 p-3 rounded">
                        <div class="text-[9.5px] font-bold text-slate-500 uppercase tracking-wider mb-0.5">PIHAK MENYERAHKAN</div>
                        <div class="font-extrabold text-slate-900 mb-10">A1ORA LOGISTICS & DISPATCH</div>
                        <div class="border-t border-dashed border-slate-400 pt-1.5 mx-6">
                            <div class="font-bold text-slate-900">{{ Auth::user()->nama ?? 'Staff Logistik A1ORA' }}</div>
                            <div class="text-[9px] text-slate-500">Tanda Tangan & Tanggal Serah: ............................</div>
                        </div>
                    </div>

                    <!-- Kolom Pihak Menerima -->
                    <div class="border border-slate-300 p-3 rounded">
                        <div class="text-[9.5px] font-bold text-slate-500 uppercase tracking-wider mb-0.5">PIHAK MENERIMA</div>
                        <div class="font-extrabold text-slate-900 mb-10">PETUGAS KURIR EKSPEDISI</div>
                        <div class="border-t border-dashed border-slate-400 pt-1.5 mx-6">
                            <div class="font-bold text-slate-900">( .............................................................. )</div>
                            <div class="text-[9px] text-slate-500">Nama Terang & No. Kendaraan: ............................</div>
                        </div>
                    </div>
                </div>

                <div class="text-center text-[9px] text-slate-400 mt-3">
                    Dokumen manifest resmi dicetak dari Sistem Logistik Presisi A1ORA Watch &bull; Dokumen sah serah terima pengiriman
                </div>
            </div>

            <!-- Footer Pagination (Sesuai Referensi) -->
            <div class="no-print px-6 py-4 bg-slate-50/70 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-slate-500">
                <div>
                    Menampilkan <strong>{{ $daftarPesanan->firstItem() ?? 0 }} - {{ $daftarPesanan->lastItem() ?? 0 }}</strong> dari <strong>{{ $daftarPesanan->total() }}</strong> pesanan
                </div>

                <div>
                    {{ $daftarPesanan->links() }}
                </div>
            </div>
        </div>

        <!-- SYSTEM FOOTER -->
        <div class="no-print pt-4 pb-2 flex flex-col sm:flex-row items-center justify-between gap-2 text-[11px] text-slate-400">
            <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>Sistem & Gateway Pembayaran Terhubung Normal (SSL 256-bit)</span>
            </div>
            <div>A1ORA Horology Studio &copy; 2026</div>
        </div>

    </main>
</div>


    <!-- MODAL 1: INPUT / EDIT NOMOR RESI -->
    <div id="modalInputResi" class="no-print fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-100 relative animate-in fade-in zoom-in-95 duration-200">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-lg flex-shrink-0">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900 leading-tight">Input Resi Logistik</h3>
                        <p class="text-xs text-slate-500 mt-0.5" id="modalResiOrderNo">Pesanan #...</p>
                    </div>
                </div>
                <button type="button" onclick="closeModalResi()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                    <i class="bi bi-x-lg text-xs"></i>
                </button>
            </div>

            <form id="formResi" method="POST" action="">
                @csrf
                <div class="space-y-4 text-xs">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1.5">Kurir Ekspedisi <span class="text-rose-500">*</span></label>
                        <select name="kurir" id="inputKurir" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 font-medium text-slate-800 focus:bg-white focus:border-blue-500 outline-none">
                            <option value="JNE Express">JNE Express</option>
                            <option value="JNE Express (YES)">JNE Express (YES - Yakin Esok Sampai)</option>
                            <option value="SiCepat Reguler">SiCepat Reguler</option>
                            <option value="SiCepat BEST">SiCepat BEST</option>
                            <option value="J&T Express">J&T Express</option>
                            <option value="Paxel Cargo">Paxel Cargo (Khusus Jam Mewah)</option>
                            <option value="POS Indonesia">POS Indonesia</option>
                            <option value="TIKI">TIKI</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1.5">Nomor Resi Pengiriman <span class="text-rose-500">*</span></label>
                        <input type="text" name="nomor_resi" id="inputNomorResi" required placeholder="Contoh: JNE88291049281 atau PXL-88129"
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 font-mono font-bold text-slate-900 focus:bg-white focus:border-blue-500 outline-none">
                        <span class="text-[11px] text-slate-400 mt-1 block">Pelanggan akan dapat langsung melihat resi ini di akun mereka.</span>
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center gap-2 cursor-pointer bg-sky-50 border border-sky-100 p-3 rounded-xl text-sky-800">
                            <input type="checkbox" name="otomatis_dikirim" value="1" checked class="w-4 h-4 text-blue-600 rounded">
                            <span class="text-xs font-semibold">Otomatis ubah status pesanan menjadi <strong>"Dikirim"</strong></span>
                        </label>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeModalResi()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition">
                        Simpan Resi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: RINCIAN LENGKAP PESANAN & TUJUAN PENGIRIMAN -->
    <div id="modalDetailPesanan" class="no-print fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-6 shadow-2xl border border-slate-100 relative animate-in fade-in zoom-in-95 duration-200 max-h-[90vh] flex flex-col">
            
            <!-- Modal Header -->
            <div class="flex items-start justify-between pb-4 border-b border-slate-100 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg flex-shrink-0">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-base font-black text-slate-900 leading-tight" id="detNoPesanan">Pesanan #...</h3>
                            <span id="detStatusBadge" class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase"></span>
                        </div>
                        <p class="text-xs text-slate-400 mt-0.5" id="detWaktuPesanan">-</p>
                    </div>
                </div>
                <button type="button" onclick="closeModalDetail()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                    <i class="bi bi-x-lg text-xs"></i>
                </button>
            </div>

            <!-- Modal Body (Scrollable) -->
            <div class="overflow-y-auto py-4 space-y-4 text-xs pr-1">
                
                <!-- 1. Kotak Tujuan Pengiriman & Catatan -->
                <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 space-y-2">
                    <div class="flex items-center gap-1.5 text-blue-600 font-bold uppercase tracking-wider text-[10px]">
                        <i class="bi bi-geo-alt-fill"></i>
                        <span>TUJUAN PENGIRIMAN LOGISTIK</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                        <div>
                            <span class="text-slate-400 block text-[11px]">Nama Penerima:</span>
                            <span class="font-bold text-slate-900 text-sm" id="detNamaPenerima">-</span>
                            <div class="text-slate-500 font-mono mt-0.5" id="detTeleponPenerima">-</div>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[11px]">Alamat Lengkap:</span>
                            <div class="font-medium text-slate-800 leading-relaxed" id="detAlamatPengiriman">-</div>
                            <div class="text-slate-600 font-semibold mt-0.5" id="detKotaKodePos">-</div>
                        </div>
                    </div>

                    <!-- Kotak Catatan Khusus Pembeli -->
                    <div class="pt-2 border-t border-slate-200/60 mt-2">
                        <span class="text-slate-400 block text-[11px]">Catatan Khusus dari Pembeli:</span>
                        <div class="mt-1 px-3 py-2 rounded-xl text-xs flex items-start gap-2" id="detCatatanBox">
                            <i class="bi bi-chat-quote-fill text-amber-600 flex-shrink-0 mt-0.5"></i>
                            <span id="detCatatanText">Tidak ada catatan.</span>
                        </div>
                    </div>
                </div>

                <!-- 2. Ekspedisi & Status Logistik -->
                <div class="grid grid-cols-2 gap-3 bg-slate-50/60 border border-slate-100 rounded-2xl p-3.5">
                    <div>
                        <span class="text-slate-400 block text-[10px] font-bold uppercase tracking-wider">Kurir Logistik</span>
                        <div class="font-bold text-slate-900 mt-0.5" id="detKurir">-</div>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px] font-bold uppercase tracking-wider">Nomor Resi</span>
                        <div class="font-mono font-bold text-slate-900 mt-0.5" id="detResi">-</div>
                    </div>
                </div>

                <!-- 3. Daftar Produk yang Dipesan -->
                <div>
                    <span class="text-slate-400 block text-[10px] font-bold uppercase tracking-wider mb-2">RINCIAN JAM TANGAN DIPESAN</span>
                    <div class="border border-slate-200 rounded-2xl overflow-hidden">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead class="bg-slate-50 border-b border-slate-200 text-[10px] text-slate-500 font-extrabold uppercase">
                                <tr>
                                    <th class="py-2.5 px-3">Item Jam Tangan</th>
                                    <th class="py-2.5 px-3 text-center">Qty</th>
                                    <th class="py-2.5 px-3 text-right">Harga Satuan</th>
                                    <th class="py-2.5 px-3 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="detItemsTable" class="divide-y divide-slate-100">
                                <!-- Populated by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 4. Ringkasan Pembayaran -->
                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200/80 space-y-1.5 text-xs">
                    <div class="flex justify-between text-slate-500">
                        <span>Subtotal Produk</span>
                        <span class="font-semibold text-slate-800" id="detSubtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-slate-500">
                        <span>Ongkos Kirim Flat</span>
                        <span class="font-semibold text-slate-800" id="detOngkir">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-slate-500">
                        <span>Metode Pembayaran</span>
                        <span class="font-bold text-slate-800" id="detMetodeBayar">-</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-slate-200 text-sm">
                        <span class="font-extrabold text-slate-900">Total Pembayaran</span>
                        <span class="font-black text-emerald-600 text-base" id="detTotalHarga">Rp 0</span>
                    </div>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-between pt-4 border-t border-slate-100 flex-shrink-0">
                <a href="#" id="detBtnCetak" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white shadow-sm transition">
                    <i class="bi bi-printer-fill text-emerald-400"></i>
                    <span>Cetak Kuitansi / Lembar Packing (A4)</span>
                </a>
                <button type="button" onclick="closeModalDetail()" class="px-5 py-2 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                    Tutup
                </button>
            </div>

        </div>
    </div>

    <!-- JavaScript Aksi Modal Resi & Clipboard -->
    <script>
        // Modal Input Resi
        function openModalResi(id, nomorPesanan, kurir, resi, status) {
            document.getElementById('modalResiOrderNo').textContent = `Pesanan #${nomorPesanan}`;
            document.getElementById('formResi').action = `/admin/pesanan/${id}/resi`;
            document.getElementById('inputKurir').value = kurir || 'JNE Express';
            document.getElementById('inputNomorResi').value = resi || '';
            document.getElementById('modalInputResi').classList.remove('hidden');
        }

        function closeModalResi() {
            document.getElementById('modalInputResi').classList.add('hidden');
        }

        // Modal Detail Pesanan
        function openModalDetail(id) {
            const dataElem = document.getElementById(`data-pesanan-${id}`);
            if (!dataElem) return;
            const data = JSON.parse(dataElem.textContent);

            document.getElementById('detNoPesanan').textContent = `Pesanan #${data.nomor}`;
            document.getElementById('detWaktuPesanan').textContent = `Waktu Transaksi: ${data.tanggal}`;
            
            // Badge Status
            const badge = document.getElementById('detStatusBadge');
            badge.textContent = data.status.toUpperCase().replace('_', ' ');
            if (data.status === 'dibayar') {
                badge.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-100 text-blue-700';
            } else if (data.status === 'diproses') {
                badge.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-slate-200 text-slate-800';
            } else if (data.status === 'dikirim') {
                badge.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-sky-100 text-sky-800';
            } else if (data.status === 'selesai') {
                badge.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800';
            } else if (data.status === 'dibatalkan') {
                badge.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-rose-100 text-rose-800';
            } else {
                badge.className = 'px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-100 text-amber-800';
            }

            // Alamat & Penerima
            document.getElementById('detNamaPenerima').textContent = data.nama_penerima;
            document.getElementById('detTeleponPenerima').textContent = data.telepon_penerima + (data.email && data.email !== '-' ? ` (${data.email})` : '');
            document.getElementById('detAlamatPengiriman').textContent = data.alamat;
            document.getElementById('detKotaKodePos').textContent = `${data.kota} - ${data.kode_pos}`;

            // Catatan
            const catatanText = document.getElementById('detCatatanText');
            if (data.catatan && data.catatan.trim() !== '') {
                catatanText.textContent = `"${data.catatan}"`;
                document.getElementById('detCatatanBox').className = 'mt-1 bg-amber-50 border border-amber-200 text-amber-900 px-3 py-2 rounded-xl text-xs font-medium italic flex items-start gap-2';
            } else {
                catatanText.textContent = 'Tidak ada catatan dari pembeli.';
                document.getElementById('detCatatanBox').className = 'mt-1 bg-slate-50 border border-slate-200 text-slate-400 px-3 py-2 rounded-xl text-xs font-normal flex items-start gap-2';
            }

            // Ekspedisi
            document.getElementById('detKurir').textContent = data.kurir;
            document.getElementById('detResi').textContent = data.resi;

            // Rincian Item Jam Tangan
            const tbody = document.getElementById('detItemsTable');
            tbody.innerHTML = '';
            if (data.items && data.items.length > 0) {
                data.items.forEach((item) => {
                    const tr = document.createElement('tr');
                    tr.className = 'hover:bg-slate-50/50';
                    tr.innerHTML = `
                        <td class="py-2.5 px-3">
                            <div class="font-bold text-slate-900">${item.nama_produk}</div>
                            <div class="text-[11px] text-slate-500">Varian: ${item.nama_varian} &bull; <span class="font-mono text-slate-400">SKU: ${item.kode_sku}</span></div>
                        </td>
                        <td class="py-2.5 px-3 text-center font-bold text-slate-800">${item.qty}</td>
                        <td class="py-2.5 px-3 text-right text-slate-600">${item.harga}</td>
                        <td class="py-2.5 px-3 text-right font-bold text-slate-900">${item.subtotal}</td>
                    `;
                    tbody.appendChild(tr);
                });
            }

            // Biaya & Pembayaran
            document.getElementById('detSubtotal').textContent = data.subtotal;
            document.getElementById('detOngkir').textContent = data.ongkir;
            document.getElementById('detTotalHarga').textContent = data.total;
            document.getElementById('detMetodeBayar').textContent = `${data.metode_bayar} (${data.status_bayar.toUpperCase()})`;

            // Tombol Cetak Kuitansi Resmi
            const btnCetak = document.getElementById('detBtnCetak');
            btnCetak.href = data.cetak_url;

            document.getElementById('modalDetailPesanan').classList.remove('hidden');
        }

        function closeModalDetail() {
            document.getElementById('modalDetailPesanan').classList.add('hidden');
        }

        // Copy Text Helper
        function copyText(text, btn) {
            if (!text) return;
            navigator.clipboard.writeText(text).then(() => {
                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-check2 text-emerald-600"></i>';
                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                }, 1500);
            });
        }

        // Close modal on Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModalResi();
            }
        });
    </script>

    <x-popup-login />
    <x-konfirmasi-logout />
</body>
</html>
