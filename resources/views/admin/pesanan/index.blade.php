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
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 antialiased flex min-h-screen">

    <!-- 1. SIDEBAR NAVIGASI HITAM PEKAT / DARK NAVY (SESUAI MOCKUP) -->
    <aside class="w-64 bg-[#0B1120] text-slate-300 flex flex-col justify-between shrink-0 min-h-screen border-r border-slate-900 sticky top-0 h-screen overflow-y-auto">
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
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        <!-- Top Header Bar -->
        <header class="bg-white border-b border-slate-200/80 sticky top-0 z-30 px-6 py-3.5 flex items-center justify-between gap-4">
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

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-sm space-y-1 shadow-sm">
                @foreach($errors->all() as $error)
                    <div class="flex items-center gap-2">
                        <i class="bi bi-exclamation-circle-fill text-rose-600"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Header Judul & Action Buttons (Sesuai Referensi) -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
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
        <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-200/90 shadow-sm space-y-4">
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

        <!-- Table Card (Sesuai Kolom & Desain Referensi) -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-extrabold uppercase tracking-wider text-slate-500">
                            <th class="py-4 px-6">NO. PESANAN</th>
                            <th class="py-4 px-6">PELANGGAN</th>
                            <th class="py-4 px-6">TANGGAL TRANSAKSI</th>
                            <th class="py-4 px-6">TOTAL & JUMLAH</th>
                            <th class="py-4 px-6">STATUS & RESI</th>
                            <th class="py-4 px-6 text-center">AKSI LOGISTIK</th>
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
                                                class="text-slate-400 hover:text-blue-600 transition" title="Salin No. Pesanan">
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
                                        <div class="w-8 h-8 rounded-full {{ $colorClass }} font-black text-xs flex items-center justify-center flex-shrink-0 mt-0.5">
                                            {{ $initials ?: 'CU' }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900 text-xs">{{ $namaPelanggan }}</div>
                                            <div class="text-[11px] text-slate-400 mt-0.5">{{ $emailPelanggan }}</div>
                                            <div class="text-[11px] text-slate-400 font-mono">{{ $teleponPelanggan }}</div>
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
                                    <div class="text-[11px] text-slate-500 mt-0.5 line-clamp-1">
                                        {{ $pesanan->detail->count() }} Item 
                                        @if($pesanan->detail->isNotEmpty())
                                            ({{ $pesanan->detail->first()->nama_produk }})
                                        @endif
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
                                                    <button type="button" onclick="copyText('{{ $nomorResi }}', this)" class="text-slate-400 hover:text-blue-600" title="Salin Resi">
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
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>
                                                {{ ucfirst($pesanan->status_pesanan) }}
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Kolom 6: Aksi Cepat (Input Resi & Ubah Status) -->
                                <td class="py-4 px-6 align-top text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Tombol Input / Edit Resi -->
                                        <button type="button" 
                                                onclick="openModalResi('{{ $pesanan->pesanan_id }}', '{{ $pesanan->nomor_pesanan }}', '{{ addslashes($namaKurir ?? 'JNE Express') }}', '{{ addslashes($nomorResi ?? '') }}', '{{ $pesanan->status_pesanan }}')"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-bold bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white border border-blue-200 transition"
                                                title="Input / Update Resi Pengiriman">
                                            <i class="bi bi-truck"></i>
                                            <span>{{ $nomorResi ? 'Ubah Resi' : 'Input Resi' }}</span>
                                        </button>

                                        <!-- Tombol Ubah Status -->
                                        <button type="button" 
                                                onclick="openModalStatus('{{ $pesanan->pesanan_id }}', '{{ $pesanan->nomor_pesanan }}', '{{ $pesanan->status_pesanan }}', '{{ addslashes($pesanan->catatan ?? '') }}')"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-200 transition"
                                                title="Perbarui Status Pesanan">
                                            <i class="bi bi-arrow-repeat"></i>
                                            <span>Status</span>
                                        </button>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400">
                                    <i class="bi bi-inbox text-4xl d-block mb-2 text-slate-300"></i>
                                    <div class="font-bold text-slate-600">Tidak ada pesanan ditemukan</div>
                                    <div class="text-xs text-slate-400 mt-1">Coba sesuaikan filter status atau kata kunci pencarian.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Pagination (Sesuai Referensi) -->
            <div class="px-6 py-4 bg-slate-50/70 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-slate-500">
                <div>
                    Menampilkan <strong>{{ $daftarPesanan->firstItem() ?? 0 }} - {{ $daftarPesanan->lastItem() ?? 0 }}</strong> dari <strong>{{ $daftarPesanan->total() }}</strong> pesanan
                </div>

                <div>
                    {{ $daftarPesanan->links() }}
                </div>
            </div>
        </div>

        <!-- SYSTEM FOOTER -->
        <div class="pt-4 pb-2 flex flex-col sm:flex-row items-center justify-between gap-2 text-[11px] text-slate-400">
            <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>Sistem & Gateway Pembayaran Terhubung Normal (SSL 256-bit)</span>
            </div>
            <div>A1ORA Horology Studio &copy; 2026</div>
        </div>

    </main>
</div>


    <!-- MODAL 1: INPUT / EDIT NOMOR RESI -->
    <div id="modalInputResi" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
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


    <!-- MODAL 2: UBAH STATUS PESANAN -->
    <div id="modalStatusPesanan" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-100 relative animate-in fade-in zoom-in-95 duration-200">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg flex-shrink-0">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900 leading-tight">Ubah Status Pesanan</h3>
                        <p class="text-xs text-slate-500 mt-0.5" id="modalStatusOrderNo">Pesanan #...</p>
                    </div>
                </div>
                <button type="button" onclick="closeModalStatus()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                    <i class="bi bi-x-lg text-xs"></i>
                </button>
            </div>

            <form id="formStatus" method="POST" action="">
                @csrf
                <div class="space-y-4 text-xs">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1.5">Pilih Status Baru <span class="text-rose-500">*</span></label>
                        <select name="status_pesanan" id="selectStatusPesanan" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 font-bold text-slate-800 focus:bg-white focus:border-blue-500 outline-none">
                            <option value="menunggu_pembayaran">Menunggu Pembayaran</option>
                            <option value="dibayar">Dibayar (Verifikasi Vault)</option>
                            <option value="diproses">Diproses (QC & Packing Butik)</option>
                            <option value="dikirim">Dikirim (Diserahkan ke Kurir)</option>
                            <option value="selesai">Selesai (Diterima Pelanggan)</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1.5">Catatan Pemrosesan (Opsional)</label>
                        <textarea name="catatan" id="inputCatatanStatus" rows="3" placeholder="Contoh: QC Lulus, kartu garansi dimasukkan, paket disegel aman..."
                                  class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:bg-white focus:border-blue-500 outline-none resize-none"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeModalStatus()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition">
                        Perbarui Status
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- JavaScript Aksi Modal & Clipboard -->
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

        // Modal Ubah Status
        function openModalStatus(id, nomorPesanan, status, catatan) {
            document.getElementById('modalStatusOrderNo').textContent = `Pesanan #${nomorPesanan}`;
            document.getElementById('formStatus').action = `/admin/pesanan/${id}/status`;
            document.getElementById('selectStatusPesanan').value = status;
            document.getElementById('inputCatatanStatus').value = catatan || '';
            document.getElementById('modalStatusPesanan').classList.remove('hidden');
        }

        function closeModalStatus() {
            document.getElementById('modalStatusPesanan').classList.add('hidden');
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
                closeModalStatus();
            }
        });
    </script>

    <x-popup-login />
    <x-konfirmasi-logout />
</body>
</html>
