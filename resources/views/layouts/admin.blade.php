<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Admin - Kronos Watch')</title>
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
    @stack('styles')
</head>
<body class="bg-[#f8fafc] text-slate-800 antialiased flex min-h-screen">

    <!-- SIDEBAR NAVIGASI ADMIN -->
    <aside class="w-64 bg-[#0B1120] text-slate-300 flex flex-col justify-between shrink-0 min-h-screen border-r border-slate-900 sticky top-0 h-screen overflow-y-auto">
        <div class="p-5">
            <div class="flex items-center gap-3 mb-8 px-1">
                <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center text-white text-lg shadow-sm shadow-blue-500/30">
                    <i class="bi bi-watch"></i>
                </div>
                <div>
                    <div class="text-sm font-extrabold tracking-widest text-white">KRONOS</div>
                    <div class="text-[10px] tracking-widest text-slate-400 font-semibold uppercase">ADMIN PORTAL</div>
                </div>
            </div>

            <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3 mb-3">
                MENU NAVIGASI
            </div>

            <nav class="space-y-1 text-xs font-semibold">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }} transition">
                    <i class="bi bi-grid-fill text-sm"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.produk.index') }}"
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('admin.produk.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }} transition">
                    <i class="bi bi-watch text-sm"></i>
                    <span>Kelola Produk</span>
                </a>
                <a href="{{ route('admin.varian.index') }}"
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('admin.varian.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }} transition">
                    <i class="bi bi-boxes text-sm"></i>
                    <span>Varian & Stok</span>
                </a>
                <a href="{{ route('admin.kategori.index') }}"
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('admin.kategori.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }} transition">
                    <i class="bi bi-collection text-sm"></i>
                    <span>Kelola Kategori</span>
                </a>
                <a href="{{ route('admin.merek.index') }}"
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('admin.merek.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }} transition">
                    <i class="bi bi-tag-fill text-sm"></i>
                    <span>Kelola Merek</span>
                </a>
                <a href="{{ route('admin.pesanan.index') }}"
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl {{ request()->routeIs('admin.pesanan.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }} transition">
                    <i class="bi bi-truck text-sm"></i>
                    <span>Pesanan & Pengiriman</span>
                </a>
            </nav>
        </div>

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

            <button type="button"
                    data-logout-trigger
                    class="w-full flex items-center gap-2.5 text-slate-400 hover:text-rose-400 hover:bg-slate-800/40 px-3 py-2 rounded-xl text-xs font-semibold transition cursor-pointer">
                <i class="bi bi-box-arrow-left text-sm"></i>
                <span>Keluar</span>
            </button>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        @yield('content')
    </div>

    @stack('scripts')
    <x-popup-login />
    <x-konfirmasi-logout />
</body>
</html>

