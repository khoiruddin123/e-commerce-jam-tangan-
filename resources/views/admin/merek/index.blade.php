<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Merek Jam Tangan | Panel Admin KRONOS</title>
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

                <!-- Kelola Merek (Active) -->
                <a href="{{ route('admin.merek.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold shadow-sm transition">
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
                <input type="text" id="filterMerekInput" onkeyup="filterMerekTable()" placeholder="Cari merek jam tangan..." 
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
        <main class="p-6 sm:p-8 space-y-6 max-w-6xl w-full mx-auto flex-1">

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

            <!-- Flash Message Error -->
            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-sm flex items-center justify-between shadow-sm animate-in fade-in duration-200">
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

            <!-- Header Halaman & Tombol Tambah Merek -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                        <i class="bi bi-tag-fill text-blue-600"></i>
                        <span>Pusat Kelola Merek Jam Tangan</span>
                    </h1>
                    <p class="text-xs text-slate-500 mt-1">
                        Daftar merek resmi horologi dunia. Merek yang didaftarkan di sini akan langsung muncul sebagai opsi pilihan saat Anda menambah atau mengubah produk.
                    </p>
                </div>
                <div>
                    <button type="button" onclick="openModalTambahMerek()" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs px-4 py-2.5 rounded-xl shadow-sm shadow-blue-500/20 transition cursor-pointer">
                        <i class="bi bi-plus-lg text-sm"></i>
                        <span>Tambah Merek Baru</span>
                    </button>
                </div>
            </div>

            <!-- Tabel Daftar Merek -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="tabelMerek">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/50 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                <th class="py-3.5 px-5">NAMA MEREK</th>
                                <th class="py-3.5 px-5">DESKRIPSI / ASAL MANUFAKTUR</th>
                                <th class="py-3.5 px-5">JUMLAH PRODUK TERDAFTAR</th>
                                <th class="py-3.5 px-5 text-right">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @forelse($daftarMerek as $merek)
                                <tr class="hover:bg-slate-50/60 transition group row-merek">
                                    <!-- Nama Merek -->
                                    <td class="py-4 px-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 font-black text-sm flex items-center justify-center border border-blue-200/60 flex-shrink-0">
                                                {{ strtoupper(substr($merek->nama_merek, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-extrabold text-slate-900 group-hover:text-blue-600 transition nama-merek-text">
                                                    {{ $merek->nama_merek }}
                                                </div>
                                                <div class="text-[10px] text-slate-400 font-mono">ID: #MRK-{{ $merek->merek_id }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Deskripsi -->
                                    <td class="py-4 px-5 text-slate-600">
                                        {{ $merek->deskripsi ?: 'Tidak ada deskripsi' }}
                                    </td>

                                    <!-- Jumlah Produk -->
                                    <td class="py-4 px-5">
                                        <a href="{{ route('admin.produk.index', ['merek_id' => $merek->merek_id]) }}" 
                                           class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $merek->produk_count > 0 ? 'bg-blue-50 text-blue-700 hover:bg-blue-100' : 'bg-slate-100 text-slate-500' }} transition">
                                            <i class="bi bi-watch"></i>
                                            <span>{{ $merek->produk_count }} Model Jam</span>
                                        </a>
                                    </td>

                                    <!-- Aksi -->
                                    <td class="py-4 px-5 text-right">
                                        <div class="inline-flex items-center gap-1.5">
                                            <!-- Tombol Edit -->
                                            <button type="button" 
                                                    onclick="openModalEditMerek('{{ $merek->merek_id }}', '{{ addslashes($merek->nama_merek) }}', '{{ addslashes($merek->deskripsi ?? '') }}')" 
                                                    class="p-2 rounded-xl text-slate-500 hover:text-slate-800 hover:bg-slate-100 border border-slate-200 transition" 
                                                    title="Ubah Merek">
                                                <i class="bi bi-pencil-square text-xs"></i>
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <button type="button" 
                                                    onclick="openModalHapusMerek('{{ $merek->merek_id }}', '{{ addslashes($merek->nama_merek) }}', {{ $merek->produk_count }})" 
                                                    class="p-2 rounded-xl text-rose-500 hover:text-rose-700 hover:bg-rose-50 border border-rose-200 transition" 
                                                    title="Hapus Merek">
                                                <i class="bi bi-trash text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 px-4 text-center">
                                        <div class="max-w-xs mx-auto text-slate-400 space-y-3">
                                            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-2xl">
                                                <i class="bi bi-tag"></i>
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-700 text-sm">Belum Ada Merek Jam Tangan</div>
                                                <div class="text-xs text-slate-400 mt-1">Tambahkan merek resmi pertama Anda sekarang agar dapat dipilih pada katalog.</div>
                                            </div>
                                            <button type="button" onclick="openModalTambahMerek()" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-4 py-2 rounded-xl transition shadow">
                                                <i class="bi bi-plus-lg"></i>
                                                <span>Tambah Merek Sekarang</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <!-- ==================== MODAL TAMBAH MEREK ==================== -->
    <div id="modalTambahMerek" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-slate-100 relative">
            <div class="flex items-start justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                        <i class="bi bi-tag-fill"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-900 leading-tight">Tambah Merek Baru</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Daftarkan nama brand manufaktur arloji.</p>
                    </div>
                </div>
                <button type="button" onclick="closeModalTambahMerek()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                    <i class="bi bi-x-lg text-xs"></i>
                </button>
            </div>

            <form action="{{ route('admin.merek.store') }}" method="POST" class="space-y-4 pt-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Merek <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_merek" required placeholder="Contoh: Rolex, Omega, Patek Philippe, Seiko..."
                           class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Singkat / Negara Asal</label>
                    <textarea name="deskripsi" rows="3" placeholder="Misal: Manufaktur horologi mewah asal Jenewa, Swiss sejak 1905."
                              class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl p-3 text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" onclick="closeModalTambahMerek()" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition">
                        Simpan Merek
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== MODAL EDIT MEREK ==================== -->
    <div id="modalEditMerek" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-slate-100 relative">
            <div class="flex items-start justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-900 leading-tight">Ubah Merek</h2>
                        <p class="text-xs text-slate-500 mt-0.5" id="editSubtitleMerek">Perbarui rincian merek arloji.</p>
                    </div>
                </div>
                <button type="button" onclick="closeModalEditMerek()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                    <i class="bi bi-x-lg text-xs"></i>
                </button>
            </div>

            <form id="formEditMerek" method="POST" action="" class="space-y-4 pt-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Merek <span class="text-rose-500">*</span></label>
                    <input type="text" id="editNamaMerek" name="nama_merek" required
                           class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Singkat / Asal</label>
                    <textarea id="editDeskripsiMerek" name="deskripsi" rows="3"
                              class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl p-3 text-slate-800 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" onclick="closeModalEditMerek()" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== MODAL HAPUS MEREK ==================== -->
    <div id="modalHapusMerek" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-sm w-full p-6 text-center shadow-2xl border border-slate-100 relative">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto text-2xl mb-3">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <h3 class="text-base font-black text-slate-900">Hapus Merek Jam Tangan?</h3>
            <p class="text-xs text-slate-500 mt-1" id="konfirmasiHapusMerekText">
                Merek ini akan dihapus dari daftar.
            </p>

            <form id="formHapusMerek" method="POST" action="" class="mt-5 flex items-center justify-center gap-2">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeModalHapusMerek()" class="flex-1 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                    Batal
                </button>
                <button type="submit" id="btnKonfirmasiHapusMerek" class="flex-1 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 shadow-sm transition">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- JAVASCRIPT LOGIC -->
    <script>
        function openModalTambahMerek() {
            document.getElementById('modalTambahMerek').classList.remove('hidden');
        }
        function closeModalTambahMerek() {
            document.getElementById('modalTambahMerek').classList.add('hidden');
        }

        function openModalEditMerek(id, nama, deskripsi) {
            document.getElementById('formEditMerek').action = `/admin/merek/${id}`;
            document.getElementById('editSubtitleMerek').textContent = `Perbarui rincian untuk ${nama}`;
            document.getElementById('editNamaMerek').value = nama;
            document.getElementById('editDeskripsiMerek').value = deskripsi;
            document.getElementById('modalEditMerek').classList.remove('hidden');
        }
        function closeModalEditMerek() {
            document.getElementById('modalEditMerek').classList.add('hidden');
        }

        function openModalHapusMerek(id, nama, produkCount) {
            document.getElementById('formHapusMerek').action = `/admin/merek/${id}`;
            const text = document.getElementById('konfirmasiHapusMerekText');
            const btn = document.getElementById('btnKonfirmasiHapusMerek');

            if (produkCount > 0) {
                text.textContent = `Merek "${nama}" masih memiliki ${produkCount} produk terkait dan tidak dapat dihapus. Hapus atau pindahkan produk terlebih dahulu.`;
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                text.textContent = `Apakah Anda yakin ingin menghapus merek "${nama}"? Tindakan ini tidak dapat dibatalkan.`;
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
            }

            document.getElementById('modalHapusMerek').classList.remove('hidden');
        }
        function closeModalHapusMerek() {
            document.getElementById('modalHapusMerek').classList.add('hidden');
        }

        // Live Filter Pencarian Tabel Merek
        function filterMerekTable() {
            const query = document.getElementById('filterMerekInput').value.toLowerCase();
            const rows = document.querySelectorAll('.row-merek');
            rows.forEach(row => {
                const nama = row.querySelector('.nama-merek-text').textContent.toLowerCase();
                if (nama.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModalTambahMerek();
                closeModalEditMerek();
                closeModalHapusMerek();
            }
        });
    </script>
</body>
</html>
