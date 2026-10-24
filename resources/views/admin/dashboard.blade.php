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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
                <h3 class="font-bold text-slate-700">Katalog & Stok Produk</h3>
                <p class="text-xs text-slate-500 mt-1">Kelola data jam tangan, varian, dan galeri.</p>
            </div>
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
                <h3 class="font-bold text-slate-700">Pesanan & Pengiriman</h3>
                <p class="text-xs text-slate-500 mt-1">Proses pesanan dibayar dan input nomor resi pengiriman.</p>
            </div>
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
                <h3 class="font-bold text-slate-700">Laporan Omzet Bulanan</h3>
                <p class="text-xs text-slate-500 mt-1">Lihat rekapitulasi penjualan dan cetak laporan bulanan.</p>
            </div>
        </div>
    </main>
</body>
</html>