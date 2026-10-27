<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Varian, Harga & Stok | Panel Admin KRONOS</title>
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
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 transition">
                    <i class="bi bi-grid-fill text-sm"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Kelola Produk (Active) -->
                <a href="{{ route('admin.varian.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold shadow-sm transition">
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
            <div class="relative w-72 sm:w-96">
                <i class="bi bi-search absolute left-3.5 top-2.5 text-slate-400 text-xs"></i>
                <input type="text" placeholder="Cari SKU, varian, atau jam tangan..." 
                       class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-3.5 py-2 text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>

            <div class="flex items-center gap-4 sm:gap-6">
                <div class="hidden md:inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200/70 text-[11px] font-semibold px-3 py-1 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>Butik Terhubung</span>
                </div>

                <button type="button" class="relative text-slate-500 hover:text-slate-700 transition">
                    <i class="bi bi-bell text-base"></i>
                    <span class="absolute -top-0.5 -right-0.5 w-2 h-2 rounded-full bg-blue-600"></span>
                </button>

                <div class="flex items-center gap-3 pl-2 border-l border-slate-200">
                    <div class="text-right hidden sm:block">
                        <div class="text-xs font-bold text-slate-900 leading-tight">
                            {{ Auth::user()->nama ?? 'Hendrawan S.' }}
                        </div>
                        <div class="text-[10px] text-slate-400 font-medium">
                            {{ ucfirst(Auth::user()->role ?? 'Super Admin') }}
                        </div>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center shadow-sm">
                        {{ strtoupper(substr(Auth::user()->nama ?? 'Hendrawan S', 0, 2)) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Body Container -->
        <main class="p-6 sm:p-8 space-y-6 max-w-7xl w-full mx-auto flex-1">

        <!-- Flash Message Notifikasi Sukses -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl text-sm flex items-center justify-between shadow-sm animate-in fade-in duration-200">
                <div class="flex items-center gap-2.5">
                    <i class="bi bi-check-circle-fill text-emerald-600 text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif

        <!-- Flash Message Notifikasi Error / Validasi -->
        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-sm space-y-1 shadow-sm">
                @foreach($errors->all() as $error)
                    <div class="flex items-center gap-2">
                        <i class="bi bi-exclamation-circle text-rose-600"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- 1. Header & Kartu Statistik Inventaris (KPI) -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <i class="bi bi-boxes text-blue-600"></i>
                    <span>Pusat Kelola Varian, Harga & Stok</span>
                </h1>
                <p class="text-xs text-slate-500 mt-1">
                    Monitoring persediaan gudang, pembaruan harga varian, dan penyesuaian stok unit jam tangan secara real-time.
                </p>
            </div>
            <div>
                @if($daftarProduk->isNotEmpty())
                    <button type="button" onclick="openModalTambah()" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs px-4 py-2.5 rounded-xl shadow-sm shadow-blue-500/20 transition cursor-pointer">
                        <i class="bi bi-plus-lg text-sm"></i>
                        <span>Tambah Varian Baru</span>
                    </button>
                @endif
            </div>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Total SKU -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Varian / SKU</div>
                    <div class="text-2xl font-black text-slate-800 mt-1">{{ number_format($totalVarian) }}</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                    <i class="bi bi-upc-scan"></i>
                </div>
            </div>

            <!-- Total Stok Unit Fisik -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Fisik Jam (Unit)</div>
                    <div class="text-2xl font-black text-indigo-600 mt-1">{{ number_format($totalStokFisik) }}</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>

            <!-- Stok Menipis -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <div class="text-[11px] font-bold text-amber-600 uppercase tracking-wider">Stok Menipis (≤ 5)</div>
                    <div class="text-2xl font-black text-amber-600 mt-1">{{ number_format($stokMenipisCount) }}</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
            </div>

            <!-- Stok Habis -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <div class="text-[11px] font-bold text-rose-600 uppercase tracking-wider">Stok Habis (0)</div>
                    <div class="text-2xl font-black text-rose-600 mt-1">{{ number_format($stokHabisCount) }}</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg">
                    <i class="bi bi-x-circle"></i>
                </div>
            </div>
        </div>

        <!-- 2. Filter & Pencarian Bar -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
            <!-- Tabs Status Stok -->
            <div class="flex flex-wrap items-center gap-2 border-b border-slate-100 pb-3">
                <a href="{{ route('admin.varian.index', ['status_stok' => 'semua', 'produk_id' => $produkId, 'q' => $search]) }}"
                   class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $statusStok === 'semua' ? 'bg-slate-900 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Semua Varian ({{ $totalVarian }})
                </a>
                <a href="{{ route('admin.varian.index', ['status_stok' => 'aman', 'produk_id' => $produkId, 'q' => $search]) }}"
                   class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $statusStok === 'aman' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Stok Aman (&gt; 5)
                </a>
                <a href="{{ route('admin.varian.index', ['status_stok' => 'menipis', 'produk_id' => $produkId, 'q' => $search]) }}"
                   class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $statusStok === 'menipis' ? 'bg-amber-500 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Stok Menipis ({{ $stokMenipisCount }})
                </a>
                <a href="{{ route('admin.varian.index', ['status_stok' => 'habis', 'produk_id' => $produkId, 'q' => $search]) }}"
                   class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $statusStok === 'habis' ? 'bg-rose-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Stok Habis ({{ $stokHabisCount }})
                </a>
            </div>

            <!-- Form Filter Dropdown & Search -->
            <form method="GET" action="{{ route('admin.varian.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
                <input type="hidden" name="status_stok" value="{{ $statusStok }}">

                <!-- Filter Produk -->
                <div class="md:col-span-5">
                    <select name="produk_id" onchange="this.form.submit()" class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Semua Model Jam Tangan --</option>
                        @foreach($daftarProduk as $p)
                            <option value="{{ $p->produk_id }}" {{ (string)$produkId === (string)$p->produk_id ? 'selected' : '' }}>
                                {{ $p->nama_produk }} ({{ $p->merek->nama_merek ?? 'Tanpa Merek' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Input Pencarian -->
                <div class="md:col-span-5">
                    <div class="relative">
                        <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama varian, kode SKU, atau jam tangan..."
                               class="w-full text-xs pl-9 pr-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class="bi bi-search absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                    </div>
                </div>

                <!-- Tombol Submit & Reset -->
                <div class="md:col-span-2 flex items-center gap-2">
                    <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-semibold text-xs py-2.5 px-3 rounded-xl transition">
                        Cari
                    </button>
                    @if($search || $produkId || $statusStok !== 'semua')
                        <a href="{{ route('admin.varian.index') }}" title="Reset Filter" class="bg-slate-100 hover:bg-slate-200 text-slate-600 p-2.5 rounded-xl transition flex items-center justify-center">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- 3. Tabel Daftar Varian & Stok -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            @if($daftarProduk->isEmpty())
                <!-- State Jika Belum Ada Produk Master -->
                <div class="text-center py-16 px-4">
                    <div class="w-16 h-16 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-800">Belum Ada Produk Jam Tangan</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto mt-1 mb-4 leading-relaxed">
                        Varian, harga, dan stok harus terhubung ke master data produk jam tangan. Silakan buat produk jam tangan terlebih dahulu sebelum menambahkan varian.
                    </p>
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs px-4 py-2.5 rounded-xl transition">
                        <i class="bi bi-speedometer2"></i>
                        <span>Kembali ke Dashboard</span>
                    </a>
                </div>
            @elseif($daftarVarian->isEmpty())
                <!-- State Jika Tidak Ada Varian yang Cocok -->
                <div class="text-center py-16 px-4">
                    <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                        <i class="bi bi-boxes"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-800">Tidak Ada Varian Ditemukan</h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 mb-6">
                        Belum ada varian produk yang sesuai dengan kriteria filter atau pencarian Anda.
                    </p>
                    <button type="button" onclick="openModalTambah()" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs px-4 py-2.5 rounded-xl transition">
                        <i class="bi bi-plus-lg"></i>
                        <span>Tambah Varian Pertama</span>
                    </button>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                <th class="py-3.5 px-6">Produk Jam Tangan</th>
                                <th class="py-3.5 px-6">Varian & Spesifikasi</th>
                                <th class="py-3.5 px-6">Kode SKU</th>
                                <th class="py-3.5 px-6 text-right">Harga Satuan</th>
                                <th class="py-3.5 px-6 text-center">Status Stok</th>
                                <th class="py-3.5 px-6 text-center">Status</th>
                                <th class="py-3.5 px-6 text-right w-48">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @foreach($daftarVarian as $varian)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <!-- Produk -->
                                    <td class="py-4 px-6">
                                        <div class="font-bold text-slate-900 text-sm">
                                            {{ $varian->produk->nama_produk ?? 'Produk Tidak Ditemukan' }}
                                        </div>
                                        <div class="text-[11px] text-slate-500 flex items-center gap-2 mt-0.5">
                                            <span class="bg-slate-100 px-1.5 py-0.5 rounded text-slate-600 font-medium">
                                                {{ $varian->produk->merek->nama_merek ?? '-' }}
                                            </span>
                                            <span>&bull;</span>
                                            <span>{{ $varian->produk->kategori->nama_kategori ?? '-' }}</span>
                                        </div>
                                    </td>

                                    <!-- Varian & Spek -->
                                    <td class="py-4 px-6">
                                        <div class="font-semibold text-slate-800">
                                            {{ $varian->nama_varian }}
                                        </div>
                                        <div class="text-[11px] text-slate-500 flex items-center gap-2 mt-0.5">
                                            @if($varian->warna)
                                                <span>Warna: <strong class="text-slate-700">{{ $varian->warna }}</strong></span>
                                            @endif
                                            @if($varian->bahan_tali)
                                                <span>&bull;</span>
                                                <span>Tali: <strong class="text-slate-700">{{ $varian->bahan_tali }}</strong></span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Kode SKU -->
                                    <td class="py-4 px-6">
                                        <span class="font-mono bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md text-[11px] border border-slate-200">
                                            {{ $varian->kode_sku }}
                                        </span>
                                    </td>

                                    <!-- Harga -->
                                    <td class="py-4 px-6 text-right font-bold text-slate-900">
                                        Rp {{ number_format($varian->harga_varian, 0, ',', '.') }}
                                    </td>

                                    <!-- Stok Badge -->
                                    <td class="py-4 px-6 text-center">
                                        @if($varian->stok <= 0)
                                            <span class="inline-flex items-center gap-1 bg-rose-50 border border-rose-200 text-rose-700 font-bold px-2.5 py-1 rounded-full text-[11px]">
                                                <i class="bi bi-x-circle-fill"></i> Habis (0)
                                            </span>
                                        @elseif($varian->stok <= 5)
                                            <span class="inline-flex items-center gap-1 bg-amber-50 border border-amber-200 text-amber-700 font-bold px-2.5 py-1 rounded-full text-[11px]">
                                                <i class="bi bi-exclamation-triangle-fill"></i> Sisa {{ $varian->stok }} Unit
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold px-2.5 py-1 rounded-full text-[11px]">
                                                <i class="bi bi-check-circle-fill"></i> {{ $varian->stok }} Unit
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Status Varian -->
                                    <td class="py-4 px-6 text-center">
                                        @if($varian->status_varian === 'aktif')
                                            <span class="bg-blue-50 text-blue-700 font-semibold text-[10px] uppercase tracking-wider px-2 py-0.5 rounded-full border border-blue-200">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="bg-slate-100 text-slate-500 font-semibold text-[10px] uppercase tracking-wider px-2 py-0.5 rounded-full">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Aksi -->
                                    <td class="py-4 px-6 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <!-- Tombol Quick Edit Stok & Harga -->
                                            <button type="button" 
                                                onclick="openModalQuickUpdate({{ $varian->varian_id }}, '{{ addslashes($varian->nama_varian) }}', '{{ $varian->kode_sku }}', {{ $varian->harga_varian }}, {{ $varian->stok }})"
                                                title="Ubah Cepat Stok & Harga"
                                                class="inline-flex items-center gap-1 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 text-xs font-semibold px-2.5 py-1.5 rounded-lg transition cursor-pointer">
                                                <i class="bi bi-lightning-charge"></i>
                                                <span>Stok/Harga</span>
                                            </button>

                                            <!-- Tombol Edit Lengkap -->
                                            <button type="button"
                                                onclick="openModalEdit({{ $varian->varian_id }}, '{{ addslashes($varian->nama_varian) }}', '{{ $varian->kode_sku }}', '{{ addslashes($varian->warna ?? '') }}', '{{ addslashes($varian->bahan_tali ?? '') }}', {{ $varian->harga_varian }}, {{ $varian->stok }}, '{{ $varian->status_varian }}')"
                                                title="Edit Informasi Lengkap"
                                                class="inline-flex items-center gap-1 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold px-2.5 py-1.5 rounded-lg transition cursor-pointer">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('admin.varian.destroy', $varian->varian_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus varian {{ addslashes($varian->nama_varian) }}?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Hapus Varian" class="inline-flex items-center text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 border border-rose-200 p-1.5 rounded-lg transition cursor-pointer">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($daftarVarian->hasPages())
                    <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $daftarVarian->links() }}
                    </div>
                @endif
            @endif
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

    <!-- Modal 1: Tambah Varian Baru -->
    <div id="modalTambah" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xl max-w-lg w-full overflow-hidden animate-in fade-in zoom-in-95 duration-150">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i class="bi bi-plus-circle"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm">Tambah Varian Jam Tangan</h3>
                </div>
                <button type="button" onclick="closeModalTambah()" class="text-slate-400 hover:text-slate-600">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.varian.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <!-- Pilih Produk -->
                <div>
                    <label for="produk_id" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Model Jam Tangan <span class="text-rose-500">*</span>
                    </label>
                    <select id="produk_id" name="produk_id" required class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih Model Jam Tangan --</option>
                        @foreach($daftarProduk as $p)
                            <option value="{{ $p->produk_id }}" {{ (string)$produkId === (string)$p->produk_id ? 'selected' : '' }}>
                                {{ $p->nama_produk }} ({{ $p->merek->nama_merek ?? 'Tanpa Merek' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="nama_varian" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Nama Varian <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="nama_varian" name="nama_varian" required placeholder="Contoh: Dial Hitam - Rantai Baja"
                            class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="kode_sku" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Kode SKU Unik <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="kode_sku" name="kode_sku" required placeholder="Contoh: SKX007-BLK-SS"
                            class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="warna" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Warna Dial/Bezel
                        </label>
                        <input type="text" id="warna" name="warna" placeholder="Contoh: Hitam / Silver"
                            class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="bahan_tali" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Bahan Tali (Strap)
                        </label>
                        <input type="text" id="bahan_tali" name="bahan_tali" placeholder="Contoh: Stainless Steel / Kulit"
                            class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="harga_varian" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Harga Satuan (Rp) <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" id="harga_varian" name="harga_varian" min="0" required placeholder="Contoh: 3500000"
                            class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="stok" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Jumlah Stok Gudang <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" id="stok" name="stok" min="0" required placeholder="Contoh: 20"
                            class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label for="status_varian" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Status Ketersediaan <span class="text-rose-500">*</span>
                    </label>
                    <select id="status_varian" name="status_varian" required class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="aktif">Aktif (Tampil & Dapat Dipesan)</option>
                        <option value="nonaktif">Nonaktif (Disembunyikan)</option>
                    </select>
                </div>

                <div class="pt-2 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeModalTambah()" class="text-xs font-semibold text-slate-600 hover:bg-slate-100 px-4 py-2 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs px-4 py-2 rounded-xl transition shadow-sm shadow-blue-500/20">
                        Simpan Varian
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 2: Quick Update Stok & Harga -->
    <div id="modalQuickUpdate" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xl max-w-sm w-full overflow-hidden animate-in fade-in zoom-in-95 duration-150">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-blue-50/50">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center">
                        <i class="bi bi-lightning-charge-fill"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">Pembaruan Cepat</h3>
                        <div id="quick_info_varian" class="text-[11px] text-slate-500"></div>
                    </div>
                </div>
                <button type="button" onclick="closeModalQuickUpdate()" class="text-slate-400 hover:text-slate-600">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <form id="formQuickUpdate" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label for="quick_harga" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Harga Varian (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" id="quick_harga" name="harga_varian" min="0" required
                        class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="quick_stok" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Persediaan Stok Gudang <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" id="quick_stok" name="stok" min="0" required
                        class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="pt-2 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeModalQuickUpdate()" class="text-xs font-semibold text-slate-600 hover:bg-slate-100 px-4 py-2 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs px-4 py-2 rounded-xl transition shadow-sm">
                        Perbarui Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 3: Edit Lengkap Varian -->
    <div id="modalEdit" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xl max-w-lg w-full overflow-hidden animate-in fade-in zoom-in-95 duration-150">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-amber-50/50">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm">Ubah Lengkap Varian Produk</h3>
                </div>
                <button type="button" onclick="closeModalEdit()" class="text-slate-400 hover:text-slate-600">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <form id="formEditVarian" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="edit_nama_varian" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Nama Varian <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="edit_nama_varian" name="nama_varian" required
                            class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div>
                        <label for="edit_kode_sku" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Kode SKU Unik <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="edit_kode_sku" name="kode_sku" required
                            class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="edit_warna" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Warna
                        </label>
                        <input type="text" id="edit_warna" name="warna"
                            class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div>
                        <label for="edit_bahan_tali" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Bahan Tali (Strap)
                        </label>
                        <input type="text" id="edit_bahan_tali" name="bahan_tali"
                            class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label for="edit_harga_varian" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Harga Satuan (Rp) <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" id="edit_harga_varian" name="harga_varian" min="0" required
                            class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div>
                        <label for="edit_stok" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Jumlah Stok Gudang <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" id="edit_stok" name="stok" min="0" required
                            class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                <div>
                    <label for="edit_status_varian" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Status Ketersediaan <span class="text-rose-500">*</span>
                    </label>
                    <select id="edit_status_varian" name="status_varian" required class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <option value="aktif">Aktif (Tampil & Dapat Dipesan)</option>
                        <option value="nonaktif">Nonaktif (Disembunyikan)</option>
                    </select>
                </div>

                <div class="pt-2 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeModalEdit()" class="text-xs font-semibold text-slate-600 hover:bg-slate-100 px-4 py-2 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-semibold text-xs px-4 py-2 rounded-xl transition shadow-sm">
                        Perbarui Varian
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript Interaksi Modal -->
    <script>
        function openModalTambah() {
            document.getElementById('modalTambah').classList.remove('hidden');
        }

        function closeModalTambah() {
            document.getElementById('modalTambah').classList.add('hidden');
        }

        function openModalQuickUpdate(id, nama, sku, harga, stok) {
            const form = document.getElementById('formQuickUpdate');
            form.action = "{{ url('admin/varian') }}/" + id + "/stok-harga";
            document.getElementById('quick_info_varian').innerText = nama + ' (' + sku + ')';
            document.getElementById('quick_harga').value = harga;
            document.getElementById('quick_stok').value = stok;
            document.getElementById('modalQuickUpdate').classList.remove('hidden');
            document.getElementById('quick_stok').focus();
        }

        function closeModalQuickUpdate() {
            document.getElementById('modalQuickUpdate').classList.add('hidden');
        }

        function openModalEdit(id, nama, sku, warna, tali, harga, stok, status) {
            const form = document.getElementById('formEditVarian');
            form.action = "{{ url('admin/varian') }}/" + id;
            document.getElementById('edit_nama_varian').value = nama;
            document.getElementById('edit_kode_sku').value = sku;
            document.getElementById('edit_warna').value = warna;
            document.getElementById('edit_bahan_tali').value = tali;
            document.getElementById('edit_harga_varian').value = harga;
            document.getElementById('edit_stok').value = stok;
            document.getElementById('edit_status_varian').value = status;
            document.getElementById('modalEdit').classList.remove('hidden');
        }

        function closeModalEdit() {
            document.getElementById('modalEdit').classList.add('hidden');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModalTambah();
                closeModalQuickUpdate();
                closeModalEdit();
            }
        });
    </script>
</body>
</html>
