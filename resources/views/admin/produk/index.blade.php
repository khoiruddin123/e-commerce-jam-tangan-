<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk & Galeri Horologi | Panel Admin KRONOS</title>
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

    <!-- 1. SIDEBAR NAVIGASI HITAM PEKAT / DARK NAVY -->
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
                <a href="{{ route('admin.produk.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold shadow-sm transition">
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
            <form action="{{ route('admin.produk.index') }}" method="GET" class="relative w-72 sm:w-96">
                <i class="bi bi-search absolute left-3.5 top-2.5 text-slate-400 text-xs"></i>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama jam, kode SKU, atau merek..." 
                       class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-3.5 py-2 text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            </form>

            <div class="flex items-center gap-4 sm:gap-6">
                <div class="hidden md:inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200/70 text-[11px] font-semibold px-3 py-1 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>Butik Terhubung</span>
                </div>

                <div class="flex items-center gap-3 pl-2 border-l border-slate-200">
                    <div class="text-right hidden sm:block">
                        <div class="text-xs font-bold text-slate-900 leading-tight">
                            {{ Auth::user()->nama ?? 'Admin Toko' }}
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

            <!-- Flash Message Error / Validasi -->
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

            <!-- 1. Header & Tombol Tambah Produk -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                        <i class="bi bi-watch text-blue-600"></i>
                        <span>Pusat Kelola Produk & Horologi</span>
                    </h1>
                    <p class="text-xs text-slate-500 mt-1">
                        Katalog mahakarya penunjuk waktu, upload galeri foto, spesifikasi teknis, serta pengelolaan status penjualan.
                    </p>
                </div>
                <div>
                    <button type="button" onclick="openModalTambahProduk()" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs px-4 py-2.5 rounded-xl shadow-sm shadow-blue-500/20 transition cursor-pointer">
                        <i class="bi bi-plus-lg text-sm"></i>
                        <span>Tambah Produk Baru</span>
                    </button>
                </div>
            </div>

            <!-- 2. Metric Cards (KPI) -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Total Produk -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                    <div>
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Model Jam</div>
                        <div class="text-2xl font-black text-slate-800 mt-1">{{ number_format($totalProduk) }}</div>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                        <i class="bi bi-watch"></i>
                    </div>
                </div>

                <!-- Produk Aktif -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                    <div>
                        <div class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider">Aktif di Etalase</div>
                        <div class="text-2xl font-black text-emerald-600 mt-1">{{ number_format($produkAktif) }}</div>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                </div>

                <!-- Produk Draf / Nonaktif -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                    <div>
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Draf / Diarsipkan</div>
                        <div class="text-2xl font-black text-slate-600 mt-1">{{ number_format($produkDraf) }}</div>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center text-lg">
                        <i class="bi bi-archive"></i>
                    </div>
                </div>

                <!-- Total Foto Galeri -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                    <div>
                        <div class="text-[11px] font-bold text-indigo-600 uppercase tracking-wider">Foto Galeri Terunggah</div>
                        <div class="text-2xl font-black text-indigo-600 mt-1">{{ number_format($totalFoto) }}</div>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
                        <i class="bi bi-images"></i>
                    </div>
                </div>
            </div>

            <!-- 3. Filter & Pencarian Bar -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-4">
                <!-- Tabs Status -->
                <div class="flex flex-wrap items-center gap-2 border-b border-slate-100 pb-3">
                    <a href="{{ route('admin.produk.index', ['status' => 'semua', 'kategori_id' => $kategoriId, 'merek_id' => $merekId, 'q' => $search]) }}"
                       class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $status === 'semua' ? 'bg-slate-900 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        Semua Produk ({{ $totalProduk }})
                    </a>
                    <a href="{{ route('admin.produk.index', ['status' => 'aktif', 'kategori_id' => $kategoriId, 'merek_id' => $merekId, 'q' => $search]) }}"
                       class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $status === 'aktif' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        Aktif ({{ $produkAktif }})
                    </a>
                    <a href="{{ route('admin.produk.index', ['status' => 'nonaktif', 'kategori_id' => $kategoriId, 'merek_id' => $merekId, 'q' => $search]) }}"
                       class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $status === 'nonaktif' ? 'bg-slate-700 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        Draf / Nonaktif ({{ $produkDraf }})
                    </a>
                </div>

                <!-- Dropdown Kategori & Merek Filter Form -->
                <form action="{{ route('admin.produk.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                    <input type="hidden" name="status" value="{{ $status }}">

                    <!-- Filter Kategori -->
                    <div class="sm:col-span-4">
                        <select name="kategori_id" onchange="this.form.submit()" 
                                class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Semua Kategori --</option>
                            @foreach($daftarKategori as $kat)
                                <option value="{{ $kat->kategori_id }}" {{ $kategoriId == $kat->kategori_id ? 'selected' : '' }}>
                                    Kategori: {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Merek -->
                    <div class="sm:col-span-4">
                        <select name="merek_id" onchange="this.form.submit()" 
                                class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Semua Merek --</option>
                            @foreach($daftarMerek as $mrk)
                                <option value="{{ $mrk->merek_id }}" {{ $merekId == $mrk->merek_id ? 'selected' : '' }}>
                                    Merek: {{ $mrk->nama_merek }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Input Pencarian -->
                    <div class="sm:col-span-4 flex items-center gap-2">
                        <div class="relative flex-1">
                            <i class="bi bi-search absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                            <input type="text" name="q" value="{{ $search }}" placeholder="Ketik kata kunci..." 
                                   class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl pl-8 pr-3 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white text-xs px-3.5 py-2 rounded-xl transition">
                            Cari
                        </button>
                        @if($search || $kategoriId || $merekId || $status !== 'semua')
                            <a href="{{ route('admin.produk.index') }}" class="p-2 rounded-xl bg-slate-100 text-slate-500 hover:text-slate-800 transition" title="Reset Filter">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- 4. Tabel Daftar Produk -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                <th class="py-3 px-4">PRODUK & FOTO</th>
                                <th class="py-3 px-4">KODE / SKU</th>
                                <th class="py-3 px-4">MEREK & KATEGORI</th>
                                <th class="py-3 px-4">VARIAN & STOK</th>
                                <th class="py-3 px-4">RENTANG HARGA</th>
                                <th class="py-3 px-4">STATUS</th>
                                <th class="py-3 px-4 text-right">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @forelse($daftarProduk as $produk)
                                @php
                                    $fotoUtama = $produk->galeri->where('foto_utama', 1)->first() ?? $produk->galeri->first();
                                    $urlFoto = $fotoUtama ? asset('storage/' . $fotoUtama->foto) : null;
                                    $jumlahVarian = $produk->varian->count();
                                    $totalStok = $produk->varian->sum('stok');
                                    $hargaMin = $produk->varian->min('harga_varian');
                                    $hargaMax = $produk->varian->max('harga_varian');
                                @endphp
                                <tr class="hover:bg-slate-50/60 transition group">
                                    <!-- Foto & Nama Produk -->
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-14 h-14 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center relative flex-shrink-0">
                                                @if($urlFoto)
                                                    <img src="{{ $urlFoto }}" alt="{{ $produk->nama_produk }}" class="w-full h-full object-cover">
                                                @else
                                                    <i class="bi bi-watch text-2xl text-slate-300"></i>
                                                @endif
                                                @if($produk->galeri->count() > 1)
                                                    <span class="absolute bottom-0.5 right-0.5 bg-black/70 text-white font-bold text-[9px] px-1 py-0.2 rounded">
                                                        +{{ $produk->galeri->count() - 1 }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900 group-hover:text-blue-600 transition">
                                                    {{ $produk->nama_produk }}
                                                </div>
                                                <div class="text-[11px] text-slate-400 line-clamp-1 mt-0.5">
                                                    {{ $produk->spesifikasi ?: ($produk->deskripsi ?: 'Tidak ada deskripsi singkat') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Kode Produk -->
                                    <td class="py-3.5 px-4 font-mono font-bold text-slate-800">
                                        {{ $produk->kode_produk }}
                                    </td>

                                    <!-- Merek & Kategori -->
                                    <td class="py-3.5 px-4 space-y-1">
                                        <div>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-blue-50 text-blue-700 border border-blue-200">
                                                <i class="bi bi-tag-fill"></i>
                                                {{ $produk->merek->nama_merek ?? 'Kronos' }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                                <i class="bi bi-collection"></i>
                                                {{ $produk->kategori->nama_kategori ?? 'Umum' }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Varian & Stok Unit -->
                                    <td class="py-3.5 px-4">
                                        <div class="font-semibold text-slate-800">
                                            {{ $jumlahVarian }} Varian
                                        </div>
                                        <div class="mt-0.5">
                                            @if($totalStok > 5)
                                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    {{ $totalStok }} Unit (Aman)
                                                </span>
                                            @elseif($totalStok > 0)
                                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-amber-600">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                                    {{ $totalStok }} Unit (Menipis)
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-rose-600">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                    Habis (0 Unit)
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Rentang Harga -->
                                    <td class="py-3.5 px-4 font-semibold text-slate-800">
                                        @if($hargaMin)
                                            @if($hargaMin == $hargaMax)
                                                Rp {{ number_format($hargaMin, 0, ',', '.') }}
                                            @else
                                                Rp {{ number_format($hargaMin, 0, ',', '.') }} - {{ number_format($hargaMax, 0, ',', '.') }}
                                            @endif
                                        @else
                                            <span class="text-slate-400 italic text-[11px]">Belum ada varian</span>
                                        @endif
                                    </td>

                                    <!-- Status Produk -->
                                    <td class="py-3.5 px-4">
                                        @if($produk->status_produk === 'aktif')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                Draf / Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Aksi -->
                                    <td class="py-3.5 px-4 text-right">
                                        <div class="inline-flex items-center gap-1.5">
                                            <!-- Tombol Kelola Foto -->
                                            <button type="button" 
                                                    onclick="openModalFoto('{{ $produk->produk_id }}', '{{ addslashes($produk->nama_produk) }}', {{ json_encode($produk->galeri->map(function($g) { return ['galeri_id' => $g->galeri_id, 'foto' => asset('storage/' . $g->foto), 'foto_utama' => (bool)$g->foto_utama, 'keterangan' => $g->keterangan]; })) }})" 
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 transition" 
                                                    title="Kelola Galeri Foto">
                                                <i class="bi bi-images text-xs"></i>
                                                <span>Foto ({{ $produk->galeri->count() }})</span>
                                            </button>

                                            <!-- Tombol Kelola Varian & Stok -->
                                            <a href="{{ route('admin.varian.index', ['produk_id' => $produk->produk_id]) }}" 
                                               class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 transition" 
                                               title="Kelola Varian & Stok">
                                                <i class="bi bi-boxes text-xs"></i>
                                                <span>Varian</span>
                                            </a>

                                            <!-- Tombol Edit Data Produk -->
                                            <button type="button" 
                                                    onclick="openModalEditProduk('{{ $produk->produk_id }}', '{{ addslashes($produk->nama_produk) }}', '{{ addslashes($produk->kode_produk) }}', '{{ $produk->kategori_id }}', '{{ $produk->merek_id }}', '{{ addslashes($produk->status_produk) }}', '{{ addslashes($produk->spesifikasi ?? '') }}', '{{ addslashes($produk->deskripsi ?? '') }}')" 
                                                    class="p-1.5 rounded-lg text-slate-500 hover:text-slate-800 hover:bg-slate-100 border border-slate-200 transition" 
                                                    title="Edit Data Produk">
                                                <i class="bi bi-pencil-square text-xs"></i>
                                            </button>

                                            <!-- Tombol Hapus Produk -->
                                            <button type="button" 
                                                    onclick="openModalHapusProduk('{{ $produk->produk_id }}', '{{ addslashes($produk->nama_produk) }}', '{{ $produk->kode_produk }}')" 
                                                    class="p-1.5 rounded-lg text-rose-500 hover:text-rose-700 hover:bg-rose-50 border border-rose-200 transition" 
                                                    title="Hapus Produk">
                                                <i class="bi bi-trash text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 px-4 text-center">
                                        <div class="max-w-xs mx-auto text-slate-400 space-y-3">
                                            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-2xl">
                                                <i class="bi bi-watch"></i>
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-700 text-sm">Belum Ada Produk Terdaftar</div>
                                                <div class="text-xs text-slate-400 mt-1">Mulai tambahkan mahakarya jam tangan pertama Anda ke katalog.</div>
                                            </div>
                                            <button type="button" onclick="openModalTambahProduk()" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-4 py-2 rounded-xl transition shadow">
                                                <i class="bi bi-plus-lg"></i>
                                                <span>Tambah Produk Sekarang</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($daftarProduk->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $daftarProduk->links() }}
                    </div>
                @endif
            </div>

        </main>
    </div>

    <!-- ==================== MODAL TAMBAH PRODUK ==================== -->
    <div id="modalTambahProduk" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-7 shadow-2xl border border-slate-100 relative max-h-[90vh] overflow-y-auto">
            <div class="flex items-start justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                        <i class="bi bi-plus-circle-fill"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-900 leading-tight">Tambah Produk Jam Tangan</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Daftarkan arloji baru, upload foto, dan konfigurasikan varian awal.</p>
                    </div>
                </div>
                <button type="button" onclick="closeModalTambahProduk()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                    <i class="bi bi-x-lg text-xs"></i>
                </button>
            </div>

            <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5 pt-4">
                @csrf

                <!-- 1. Identitas Produk -->
                <div>
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                        <i class="bi bi-info-circle text-blue-600"></i> Informasi Utama Arloji
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Nama Produk -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Produk Jam Tangan <span class="text-rose-500">*</span></label>
                            <input type="text" name="nama_produk" required placeholder="Contoh: Rolex Submariner Date 41mm"
                                   class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Kode Produk -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="text-xs font-bold text-slate-700">Kode Produk</label>
                                <button type="button" onclick="generateKodeProduk()" class="text-[10px] text-blue-600 font-bold hover:underline">
                                    Generate Otomatis
                                </button>
                            </div>
                            <input type="text" id="inputKodeProduk" name="kode_produk" placeholder="Misal: KW-RLX-01"
                                   class="w-full text-xs font-mono font-bold bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Status Produk -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Status Publikasi <span class="text-rose-500">*</span></label>
                            <select name="status_produk" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500">
                                <option value="aktif">Aktif (Tampil di Katalog Toko)</option>
                                <option value="nonaktif">Draf / Nonaktif (Disembunyikan)</option>
                            </select>
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Kategori Horologi <span class="text-rose-500">*</span></label>
                            <select name="kategori_id" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($daftarKategori as $kat)
                                    <option value="{{ $kat->kategori_id }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Merek -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="text-xs font-bold text-slate-700">Merek Jam Tangan <span class="text-rose-500">*</span></label>
                                <a href="{{ route('admin.merek.index') }}" target="_blank" class="text-[10px] text-blue-600 font-bold hover:underline" title="Buka menu Kelola Merek">
                                    + Kelola Merek
                                </a>
                            </div>
                            <select name="merek_id" id="selectMerekTambah" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Pilih Merek Terdaftar --</option>
                                @foreach($daftarMerek as $mrk)
                                    <option value="{{ $mrk->merek_id }}">{{ $mrk->nama_merek }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Spesifikasi Teknis -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1">Spesifikasi Singkat / Teknis</label>
                            <textarea name="spesifikasi" rows="2" placeholder="Misal: Case 41mm Oystersteel, Bezel Cerachrom Hitam, Kaliber 3235 Automatic, Water Resistant 300m"
                                      class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl p-3 text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>

                        <!-- Deskripsi Lengkap -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Lengkap & Sejarah Horologi</label>
                            <textarea name="deskripsi" rows="3" placeholder="Ceritakan keistimewaan arloji, garansi butik, keaslian dokumen box & paper..."
                                      class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl p-3 text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                    </div>
                </div>

                <!-- 2. Unggah Foto Produk -->
                <div class="pt-3 border-t border-slate-100">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                        <i class="bi bi-images text-blue-600"></i> Galeri Foto Produk (Bisa Pilih Beberapa)
                    </h3>
                    <p class="text-[11px] text-slate-400 mb-3">Foto pertama otomatis dijadikan foto utama. Format: JPG, PNG, WEBP (maks. 5MB per foto).</p>
                    
                    <div class="border-2 border-dashed border-slate-200 rounded-2xl p-4 text-center hover:border-blue-500 transition bg-slate-50/50">
                        <input type="file" name="foto[]" id="inputFotoTambah" multiple accept="image/*" onchange="previewFotoTambah(this)" class="hidden">
                        <label for="inputFotoTambah" class="cursor-pointer flex flex-col items-center">
                            <i class="bi bi-cloud-arrow-up text-3xl text-blue-500 mb-1"></i>
                            <span class="text-xs font-bold text-slate-700">Klik untuk memilih foto produk</span>
                            <span class="text-[10px] text-slate-400 mt-0.5">Dapat memilih lebih dari 1 file gambar sekaligus</span>
                        </label>
                    </div>

                    <!-- Container Preview Foto -->
                    <div id="containerPreviewFotoTambah" class="grid grid-cols-4 sm:grid-cols-6 gap-2 mt-3 hidden"></div>
                </div>

                <!-- 3. Konfigurasi Varian Awal (Harga & Stok) -->
                <div class="pt-3 border-t border-slate-100 bg-slate-50/70 p-4 rounded-2xl border border-slate-200/80">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                                <i class="bi bi-box-seam text-blue-600"></i> Varian & Stok Awal
                            </h3>
                            <p class="text-[11px] text-slate-400">Atur harga jual dan stok awal agar produk langsung dapat dibeli di etalase.</p>
                        </div>
                        <span class="text-[10px] font-bold text-blue-700 bg-blue-100/70 px-2 py-0.5 rounded-md">Varian #1</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Varian</label>
                            <input type="text" name="nama_varian" value="Standard Edition" placeholder="Misal: Standard Edition, Black Dial..."
                                   class="w-full text-xs bg-white border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Harga Jual (Rp) <span class="text-rose-500">*</span></label>
                            <input type="number" name="harga_varian" min="0" placeholder="Contoh: 185000000"
                                   class="w-full text-xs font-bold bg-white border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Jumlah Stok Fisik (Unit) <span class="text-rose-500">*</span></label>
                            <input type="number" name="stok" min="0" value="1"
                                   class="w-full text-xs bg-white border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Bahan Tali / Strap</label>
                            <input type="text" name="bahan_tali" value="Stainless Steel" placeholder="Misal: Oystersteel, Leather Strap..."
                                   class="w-full text-xs bg-white border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Footer Modal -->
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" onclick="closeModalTambahProduk()" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== MODAL UBAH PRODUK ==================== -->
    <div id="modalEditProduk" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-7 shadow-2xl border border-slate-100 relative max-h-[90vh] overflow-y-auto">
            <div class="flex items-start justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-900 leading-tight">Ubah Informasi Produk</h2>
                        <p class="text-xs text-slate-500 mt-0.5" id="editSubtitleProduk">Perbarui data arloji.</p>
                    </div>
                </div>
                <button type="button" onclick="closeModalEditProduk()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                    <i class="bi bi-x-lg text-xs"></i>
                </button>
            </div>

            <form id="formEditProduk" method="POST" action="" class="space-y-4 pt-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Produk Jam Tangan <span class="text-rose-500">*</span></label>
                    <input type="text" id="editNamaProduk" name="nama_produk" required
                           class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kode Produk <span class="text-rose-500">*</span></label>
                        <input type="text" id="editKodeProduk" name="kode_produk" required
                               class="w-full text-xs font-mono font-bold bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Status Publikasi <span class="text-rose-500">*</span></label>
                        <select id="editStatusProduk" name="status_produk" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500">
                            <option value="aktif">Aktif (Tampil di Katalog)</option>
                            <option value="nonaktif">Draf / Nonaktif (Disembunyikan)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kategori Horologi <span class="text-rose-500">*</span></label>
                        <select id="editKategoriProduk" name="kategori_id" required class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500">
                            @foreach($daftarKategori as $kat)
                                <option value="{{ $kat->kategori_id }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Merek Jam Tangan</label>
                        <select id="editMerekProduk" name="merek_id" class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500">
                            @foreach($daftarMerek as $mrk)
                                <option value="{{ $mrk->merek_id }}">{{ $mrk->nama_merek }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Spesifikasi Teknis</label>
                    <textarea id="editSpesifikasiProduk" name="spesifikasi" rows="2"
                              class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl p-3 text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Produk</label>
                    <textarea id="editDeskripsiProduk" name="deskripsi" rows="3"
                              class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl p-3 text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <!-- Footer Modal -->
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" onclick="closeModalEditProduk()" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== MODAL KELOLA GALERI FOTO ==================== -->
    <div id="modalKelolaFoto" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-7 shadow-2xl border border-slate-100 relative max-h-[90vh] overflow-y-auto">
            <div class="flex items-start justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
                        <i class="bi bi-images"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-900 leading-tight">Galeri Foto Produk</h2>
                        <p class="text-xs text-slate-500 mt-0.5" id="modalFotoNamaProduk">Nama Produk Jam Tangan</p>
                    </div>
                </div>
                <button type="button" onclick="closeModalFoto()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                    <i class="bi bi-x-lg text-xs"></i>
                </button>
            </div>

            <!-- Form Upload Foto Baru -->
            <form id="formUploadFotoProduk" method="POST" action="" enctype="multipart/form-data" class="pt-4 pb-4 border-b border-slate-100 space-y-3">
                @csrf
                <div class="flex flex-col sm:flex-row items-center gap-2">
                    <input type="file" name="foto[]" id="fileInputUploadBaru" multiple accept="image/*" required
                           class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition whitespace-nowrap">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <span>Unggah Foto</span>
                    </button>
                </div>
                <p class="text-[10px] text-slate-400">Pilih satu atau lebih file foto (JPG, PNG, WEBP maks. 5MB).</p>
            </form>

            <!-- Grid Foto yang Tersedia -->
            <div class="pt-4">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-3">Foto Terdaftar Saat Ini</h3>
                <div id="gridFotoTersedia" class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <!-- Diisi lewat JS saat modal dibuka -->
                </div>
                <div id="emptyFotoNotice" class="text-center py-8 text-slate-400 hidden">
                    <i class="bi bi-image text-3xl text-slate-300 block mb-1"></i>
                    <span class="text-xs">Belum ada foto untuk produk ini. Unggah foto pertama di atas.</span>
                </div>
            </div>

            <!-- Form Hidden untuk Hapus & Set Utama -->
            <form id="formActionHapusFoto" method="POST" action="" class="hidden">
                @csrf
                @method('DELETE')
            </form>
            <form id="formActionSetUtama" method="POST" action="" class="hidden">
                @csrf
                @method('PATCH')
            </form>

            <div class="flex justify-end pt-4 border-t border-slate-100 mt-4">
                <button type="button" onclick="closeModalFoto()" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                    Selesai
                </button>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL HAPUS PRODUK ==================== -->
    <div id="modalHapusProduk" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-sm w-full p-6 text-center shadow-2xl border border-slate-100 relative">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto text-2xl mb-3">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <h3 class="text-base font-black text-slate-900">Hapus Produk Arloji?</h3>
            <p class="text-xs text-slate-500 mt-1" id="konfirmasiHapusText">
                Produk beserta galeri foto dan varian terkait akan dihapus secara permanen.
            </p>

            <form id="formHapusProduk" method="POST" action="" class="mt-5 flex items-center justify-center gap-2">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeModalHapusProduk()" class="flex-1 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-sm transition">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- JAVASCRIPT LOGIC -->
    <script>
        // Modal Tambah
        function openModalTambahProduk() {
            document.getElementById('modalTambahProduk').classList.remove('hidden');
        }
        function closeModalTambahProduk() {
            document.getElementById('modalTambahProduk').classList.add('hidden');
        }

        // Generate Kode Produk Otomatis
        function generateKodeProduk() {
            const randomStr = Math.random().toString(36).substring(2, 8).toUpperCase();
            document.getElementById('inputKodeProduk').value = 'KW-' + randomStr;
        }

        // Preview Foto Tambah
        function previewFotoTambah(input) {
            const container = document.getElementById('containerPreviewFotoTambah');
            container.innerHTML = '';
            if (input.files && input.files.length > 0) {
                container.classList.remove('hidden');
                Array.from(input.files).forEach((file, idx) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative w-full aspect-square rounded-xl overflow-hidden border border-slate-200 bg-slate-100';
                        div.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-full object-cover">
                            ${idx === 0 ? '<span class="absolute top-1 left-1 bg-blue-600 text-white text-[8px] font-bold px-1 rounded shadow">Utama</span>' : ''}
                        `;
                        container.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                });
            } else {
                container.classList.add('hidden');
            }
        }

        // Modal Edit
        function openModalEditProduk(id, nama, kode, kategoriId, merekId, status, spesifikasi, deskripsi) {
            document.getElementById('formEditProduk').action = `/admin/produk/${id}`;
            document.getElementById('editSubtitleProduk').textContent = `Perbarui rincian untuk ${nama} (${kode})`;
            document.getElementById('editNamaProduk').value = nama;
            document.getElementById('editKodeProduk').value = kode;
            document.getElementById('editKategoriProduk').value = kategoriId;
            document.getElementById('editMerekProduk').value = merekId;
            document.getElementById('editStatusProduk').value = status;
            document.getElementById('editSpesifikasiProduk').value = spesifikasi;
            document.getElementById('editDeskripsiProduk').value = deskripsi;
            document.getElementById('modalEditProduk').classList.remove('hidden');
        }
        function closeModalEditProduk() {
            document.getElementById('modalEditProduk').classList.add('hidden');
        }

        // Modal Kelola Foto
        let currentProdukFotoId = null;
        function openModalFoto(produkId, namaProduk, daftarFoto) {
            currentProdukFotoId = produkId;
            document.getElementById('modalFotoNamaProduk').textContent = `Koleksi galeri arloji: ${namaProduk}`;
            document.getElementById('formUploadFotoProduk').action = `/admin/produk/${produkId}/foto`;

            const grid = document.getElementById('gridFotoTersedia');
            const notice = document.getElementById('emptyFotoNotice');
            grid.innerHTML = '';

            if (!daftarFoto || daftarFoto.length === 0) {
                notice.classList.remove('hidden');
            } else {
                notice.classList.add('hidden');
                daftarFoto.forEach(foto => {
                    const card = document.createElement('div');
                    card.className = 'border border-slate-200 rounded-2xl overflow-hidden bg-white shadow-sm flex flex-col justify-between';
                    card.innerHTML = `
                        <div class="relative w-full aspect-square bg-slate-100 overflow-hidden">
                            <img src="${foto.foto}" class="w-full h-full object-cover">
                            ${foto.foto_utama ? `
                                <span class="absolute top-2 left-2 bg-emerald-600 text-white text-[9px] font-extrabold px-2 py-0.5 rounded-full shadow flex items-center gap-1">
                                    <i class="bi bi-star-fill text-[8px]"></i> UTAMA
                                </span>
                            ` : ''}
                        </div>
                        <div class="p-2.5 bg-slate-50 flex items-center justify-between gap-1 border-t border-slate-100">
                            ${!foto.foto_utama ? `
                                <button type="button" onclick="actionSetFotoUtama(${foto.galeri_id})" 
                                        class="text-[10px] font-bold text-indigo-600 hover:text-indigo-800 bg-white hover:bg-indigo-50 border border-indigo-200 px-2 py-1 rounded-lg transition flex items-center gap-1">
                                    <i class="bi bi-star"></i> Set Utama
                                </button>
                            ` : `
                                <span class="text-[10px] text-emerald-700 font-bold flex items-center gap-1">
                                    <i class="bi bi-check2"></i> Foto Utama
                                </span>
                            `}
                            <button type="button" onclick="actionHapusFoto(${foto.galeri_id})" 
                                    class="text-[10px] font-bold text-rose-600 hover:text-rose-800 bg-white hover:bg-rose-50 border border-rose-200 p-1 rounded-lg transition" title="Hapus Foto">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    `;
                    grid.appendChild(card);
                });
            }

            document.getElementById('modalKelolaFoto').classList.remove('hidden');
        }
        function closeModalFoto() {
            document.getElementById('modalKelolaFoto').classList.add('hidden');
        }

        function actionSetFotoUtama(fotoId) {
            const form = document.getElementById('formActionSetUtama');
            form.action = `/admin/produk/foto/${fotoId}/utama`;
            form.submit();
        }

        function actionHapusFoto(fotoId) {
            if (confirm('Apakah Anda yakin ingin menghapus foto ini dari galeri produk?')) {
                const form = document.getElementById('formActionHapusFoto');
                form.action = `/admin/produk/foto/${fotoId}`;
                form.submit();
            }
        }

        // Modal Hapus Produk
        function openModalHapusProduk(id, nama, kode) {
            document.getElementById('formHapusProduk').action = `/admin/produk/${id}`;
            document.getElementById('konfirmasiHapusText').textContent = `Produk "${nama}" (${kode}) beserta varian dan galeri fotonya akan dihapus.`;
            document.getElementById('modalHapusProduk').classList.remove('hidden');
        }
        function closeModalHapusProduk() {
            document.getElementById('modalHapusProduk').classList.add('hidden');
        }

        // Close on Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModalTambahProduk();
                closeModalEditProduk();
                closeModalFoto();
                closeModalHapusProduk();
            }
        });
    </script>

    <x-popup-login />
    <x-konfirmasi-logout />
</body>
</html>
