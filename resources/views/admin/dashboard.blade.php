<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - E-Commerce Jam Tangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen">
    <header class="bg-slate-900 text-white px-6 py-4 flex justify-between items-center shadow">
        <div class="font-bold text-lg tracking-wide">PANEL ADMIN | TOKO JAM TANGAN</div>
        <div class="flex items-center gap-4">
            <span class="text-sm text-slate-300">{{ Auth::user()->nama }} ({{ ucfirst(Auth::user()->role) }})</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-xs font-semibold px-3 py-1.5 rounded transition">
                    Logout
                </button>
            </form>
        </div>
    </header>

    <main class="max-w-6xl mx-auto p-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 mb-6">
            <h2 class="text-xl font-bold text-slate-800">Selamat datang, {{ Auth::user()->nama }}!</h2>
            <p class="text-sm text-slate-500 mt-1">Anda masuk dengan hak akses Admin.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Kategori Produk (Aktif) -->
            <a href="{{ route('admin.kategori.index') }}" class="block bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:shadow-md hover:border-amber-400 transition group cursor-pointer">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-bold text-slate-800 group-hover:text-amber-600 transition">Kategori Produk</h3>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-amber-100 text-amber-700">Aktif</span>
                </div>
                <p class="text-xs text-slate-500">Kelola master kategori jam tangan (Automatic, Diver, Chronograph, dll).</p>
                <div class="mt-4 flex items-center text-xs font-semibold text-amber-600 group-hover:translate-x-1 transition duration-150">
                    Buka Kategori &rarr;
                </div>
            </a>

            <!-- Katalog & Stok Produk (Tahap Berikutnya) -->
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-bold text-slate-700">Katalog & Stok Produk</h3>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-500">Tahap 2</span>
                </div>
                <p class="text-xs text-slate-500">Kelola data jam tangan, varian harga/stok, dan galeri foto.</p>
                <div class="mt-4 text-xs font-semibold text-slate-400">
                    Dalam Pengembangan
                </div>
            </div>
            <a href="{{ route('admin.pesanan.index') }}" class="block bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-400 transition group cursor-pointer">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-bold text-slate-800 group-hover:text-blue-600 transition">Pesanan & Pengiriman</h3>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-blue-100 text-blue-700">Aktif</span>
                </div>
                <p class="text-xs text-slate-500">Kelola verifikasi transaksi, status pemrosesan jam, dan input nomor resi kurir.</p>
                <div class="mt-4 flex items-center text-xs font-semibold text-blue-600 group-hover:translate-x-1 transition duration-150">
                    Buka Logistik & Pesanan &rarr;
                </div>
            </a>
            <a href="{{ route('admin.laporan.omzet') }}" class="block bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:shadow-md hover:border-indigo-400 transition group cursor-pointer">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="font-bold text-slate-800 group-hover:text-indigo-600 transition">Laporan Omzet Bulanan</h3>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700">Aktif</span>
                </div>
                <p class="text-xs text-slate-500">Lihat rekapitulasi omzet penjualan, filter bulan/tahun, dan cetak laporan.</p>
                <div class="mt-4 flex items-center text-xs font-semibold text-indigo-600 group-hover:translate-x-1 transition duration-150">
                    Buka Laporan Omzet &rarr;
                </div>
            </a>
        </div>
    </main>
</body>
</html>