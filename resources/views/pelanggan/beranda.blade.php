<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Pelanggan - Toko Jam Tangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen">
    <header class="bg-white border-b border-slate-200 px-6 py-4 flex justify-between items-center shadow-sm">
        <div class="font-bold text-lg text-slate-800">Koleksi Jam Tangan</div>
        <div class="flex items-center gap-4">
            <span class="text-sm text-slate-600">Hai, <strong>{{ Auth::user()->nama }}</strong></span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-semibold px-3 py-1.5 rounded transition">
                    Logout
                </button>
            </form>
        </div>
    </header>

    <main class="max-w-6xl mx-auto p-6">
        <div class="bg-indigo-600 rounded-2xl text-white p-8 mb-6 shadow">
            <h1 class="text-2xl font-bold">Katalog Toko Online Jam Tangan</h1>
            <p class="text-indigo-100 text-sm mt-1">Jelajahi berbagai pilihan jam tangan original dan varian terbaik.</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-8 text-center text-slate-500">
            Daftar produk dan keranjang belanja akan tampil di sini sesuai alur transaksi.
        </div>
    </main>
</body>
</html>