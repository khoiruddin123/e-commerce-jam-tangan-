<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori - A1ORA Watch</title>
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

            <!-- Nav Links List -->
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

                <!-- Kelola Kategori (Active) -->
                <a href="{{ route('admin.kategori.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold shadow-sm transition">
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
            <div class="relative w-72 sm:w-96">
                <i class="bi bi-search absolute left-3.5 top-2.5 text-slate-400 text-xs"></i>
                <input type="text" placeholder="Cari kategori atau seri jam..." 
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
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl text-sm flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2.5">
                        <i class="bi bi-check-circle-fill text-emerald-600 text-lg"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            @endif

            <!-- Flash Message Notifikasi Error -->
            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-sm flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2.5">
                        <i class="bi bi-exclamation-triangle-fill text-rose-600 text-lg"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            @endif

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

            <!-- Header Bar & Tombol Tambah -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                        <i class="bi bi-collection text-blue-600"></i>
                        <span>Kelola Kategori Jam Tangan</span>
                    </h1>
                    <p class="text-xs text-slate-500 mt-1">
                        Pengelompokan seri produk butik (contoh: Chronograph, Diver Professional, Dress Classic, Automatic).
                    </p>
                </div>
                <div>
                    <button type="button" onclick="openModalTambah()" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs px-4 py-2.5 rounded-xl shadow-sm shadow-blue-500/20 transition cursor-pointer">
                        <i class="bi bi-plus-lg text-sm"></i>
                        <span>Tambah Kategori Baru</span>
                    </button>
                </div>
            </div>

            <!-- Tabel Daftar Kategori -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                @if($daftarKategori->isEmpty())
                    <!-- State Jika Belum Ada Kategori -->
                    <div class="text-center py-16 px-4">
                        <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                            <i class="bi bi-collection"></i>
                        </div>
                        <h3 class="text-base font-bold text-slate-800">Belum Ada Kategori Produk</h3>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 mb-6">
                            Buat kategori pertama Anda agar jam tangan dapat dikelompokkan dengan rapi pada katalog.
                        </p>
                        <button type="button" onclick="openModalTambah()" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs px-4 py-2.5 rounded-xl transition cursor-pointer">
                            <i class="bi bi-plus-lg"></i>
                            <span>Tambah Kategori Sekarang</span>
                        </button>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                    <th class="py-3.5 px-6 w-16">NO</th>
                                    <th class="py-3.5 px-6">NAMA KATEGORI</th>
                                    <th class="py-3.5 px-6">DESKRIPSI</th>
                                    <th class="py-3.5 px-6 text-center w-36">JUMLAH PRODUK</th>
                                    <th class="py-3.5 px-6 text-right w-44">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs">
                                @foreach($daftarKategori as $index => $kategori)
                                    <tr class="hover:bg-slate-50/60 transition">
                                        <td class="py-4 px-6 text-slate-400 font-medium">{{ $index + 1 }}</td>
                                        <td class="py-4 px-6">
                                            <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                                                <i class="bi bi-tag text-blue-500"></i>
                                                <span>{{ $kategori->nama_kategori }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-slate-600 max-w-md">
                                            {{ $kategori->deskripsi ?? '-' }}
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <span class="inline-flex items-center gap-1 font-semibold text-[11px] px-2.5 py-1 rounded-full {{ $kategori->produk_count > 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500' }}">
                                                <i class="bi bi-box-seam"></i>
                                                {{ $kategori->produk_count }} Produk
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <!-- Tombol Edit -->
                                                <button type="button" 
                                                    onclick="openModalEdit({{ $kategori->kategori_id }}, '{{ addslashes($kategori->nama_kategori) }}', '{{ addslashes($kategori->deskripsi ?? '') }}')"
                                                    class="inline-flex items-center gap-1 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 text-xs font-semibold px-2.5 py-1.5 rounded-lg transition cursor-pointer">
                                                    <i class="bi bi-pencil-square"></i>
                                                    <span>Ubah</span>
                                                </button>

                                                <!-- Tombol Hapus -->
                                                <form action="{{ route('admin.kategori.destroy', $kategori->kategori_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ addslashes($kategori->nama_kategori) }}?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                        class="inline-flex items-center gap-1 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-semibold px-2.5 py-1.5 rounded-lg transition cursor-pointer">
                                                        <i class="bi bi-trash"></i>
                                                        <span>Hapus</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
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

    <!-- Modal Tambah Kategori -->
    <div id="modalTambah" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xl max-w-md w-full overflow-hidden animate-in fade-in zoom-in-95 duration-150">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i class="bi bi-folder-plus"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm">Tambah Kategori Baru</h3>
                </div>
                <button type="button" onclick="closeModalTambah()" class="text-slate-400 hover:text-slate-600">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.kategori.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label for="nama_kategori" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Nama Kategori <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="nama_kategori" name="nama_kategori" required placeholder="Contoh: Chronograph, Diver Watch"
                        class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="deskripsi" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Deskripsi Singkat (Opsional)
                    </label>
                    <textarea id="deskripsi" name="deskripsi" rows="3" placeholder="Penjelasan singkat mengenai kategori jam tangan ini..."
                        class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>

                <div class="pt-2 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeModalTambah()" class="text-xs font-semibold text-slate-600 hover:bg-slate-100 px-4 py-2 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs px-4 py-2 rounded-xl transition shadow-sm shadow-blue-500/20">
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div id="modalEdit" class="fixed inset-0 z-50 hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xl max-w-md w-full overflow-hidden animate-in fade-in zoom-in-95 duration-150">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm">Ubah Kategori Produk</h3>
                </div>
                <button type="button" onclick="closeModalEdit()" class="text-slate-400 hover:text-slate-600">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <form id="formEditKategori" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="edit_nama_kategori" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Nama Kategori <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="edit_nama_kategori" name="nama_kategori" required
                        class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>

                <div>
                    <label for="edit_deskripsi" class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Deskripsi Singkat (Opsional)
                    </label>
                    <textarea id="edit_deskripsi" name="deskripsi" rows="3"
                        class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500"></textarea>
                </div>

                <div class="pt-2 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeModalEdit()" class="text-xs font-semibold text-slate-600 hover:bg-slate-100 px-4 py-2 rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-semibold text-xs px-4 py-2 rounded-xl transition shadow-sm shadow-amber-500/20">
                        Perbarui Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript Interaksi Modal -->
    <script>
        function openModalTambah() {
            document.getElementById('modalTambah').classList.remove('hidden');
            document.getElementById('nama_kategori').focus();
        }

        function closeModalTambah() {
            document.getElementById('modalTambah').classList.add('hidden');
        }

        function openModalEdit(id, nama, deskripsi) {
            const form = document.getElementById('formEditKategori');
            form.action = "{{ url('admin/kategori') }}/" + id;
            document.getElementById('edit_nama_kategori').value = nama;
            document.getElementById('edit_deskripsi').value = deskripsi;
            document.getElementById('modalEdit').classList.remove('hidden');
            document.getElementById('edit_nama_kategori').focus();
        }

        function closeModalEdit() {
            document.getElementById('modalEdit').classList.add('hidden');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModalTambah();
                closeModalEdit();
            }
        });
    </script>

    <x-popup-login />
    <x-konfirmasi-logout />
</body>
</html>
