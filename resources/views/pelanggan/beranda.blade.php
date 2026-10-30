@extends('layouts.app')

@section('title', 'Riwayat Pesanan Saya - A1ORA Watch')

@section('content')

<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        corePlugins: {
            preflight: false,
            container: false,
        }
    }
</script>
<style>
    .riwayat-wrapper {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .riwayat-wrapper a {
        text-decoration: none;
    }
    .riwayat-wrapper button {
        border-style: none;
    }
</style>

<div class="container py-4">
    <div class="riwayat-wrapper space-y-6">


        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl text-sm flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="bi bi-check-circle-fill text-emerald-600 text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-sm flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="bi bi-exclamation-triangle-fill text-rose-600 text-lg"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif

        <!-- Breadcrumb & Judul Halaman -->
        <div>
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                <a href="{{ route('produk.index') }}" class="hover:text-blue-600">Beranda</a>
                <span>/</span>
                <span>Akun</span>
                <span>/</span>
                <span class="text-slate-700 font-semibold">Riwayat Pesanan</span>
            </nav>
            <div class="text-[11px] font-extrabold uppercase tracking-widest text-blue-600 mb-1">
                AKTIVITAS TRANSAKSI KOLEKTOR
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                Riwayat Pesanan Saya
            </h1>
        </div>

        <!-- Filter Tab (Semua, Berjalan, Selesai) -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-200 pb-4">
            <div class="flex items-center gap-2">
                <a href="{{ route('pelanggan.beranda', ['tab' => 'semua']) }}" 
                   class="px-4 py-2 rounded-full text-xs font-bold transition {{ $tab === 'semua' ? 'bg-slate-900 text-white shadow' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                    Semua ({{ $totalSemua }})
                </a>
                <a href="{{ route('pelanggan.beranda', ['tab' => 'berjalan']) }}" 
                   class="px-4 py-2 rounded-full text-xs font-bold transition {{ $tab === 'berjalan' ? 'bg-slate-900 text-white shadow' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                    Berjalan ({{ $totalBerjalan }})
                </a>
                <a href="{{ route('pelanggan.beranda', ['tab' => 'selesai']) }}" 
                   class="px-4 py-2 rounded-full text-xs font-bold transition {{ $tab === 'selesai' ? 'bg-blue-600 text-white shadow' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                    Selesai ({{ $totalSelesai }})
                </a>
            </div>

            <div class="text-xs text-slate-500 font-medium">
                Total: <strong class="text-slate-800">{{ $totalSelesai }} Transaksi Selesai</strong>
            </div>
        </div>

        <!-- Daftar Kartu Pesanan -->
        <div class="space-y-5">
            @forelse($daftarPesanan as $pesanan)
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden">
                    <!-- Header Kartu Pesanan -->
                    <div class="px-6 py-4 bg-slate-50/70 border-b border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs">
                        <div class="flex items-center gap-3">
                            <span class="font-bold text-blue-600 font-mono text-sm">{{ $pesanan->nomor_pesanan }}</span>
                            <span class="text-slate-300">|</span>
                            <span class="text-slate-500 font-medium">
                                {{ $pesanan->tanggal_pesanan ? $pesanan->tanggal_pesanan->translatedFormat('d F Y') : '-' }}
                            </span>
                        </div>

                                   <!-- Status Pesanan Badge & Tombol Bayar Sekarang (F9) -->
                        <div class="flex items-center gap-2">
                            @if($pesanan->status_pesanan === 'selesai')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                    <i class="bi bi-check-circle-fill text-blue-600"></i>
                                    Pesanan Selesai / Terkirim
                                </span>
                            @elseif($pesanan->status_pesanan === 'dikirim')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                    <i class="bi bi-truck text-sky-600"></i>
                                    Dalam Pengiriman
                                </span>
                            @elseif($pesanan->status_pesanan === 'menunggu_pembayaran')
                                <a href="{{ route('pembayaran.show', $pesanan->pesanan_id) }}" 
                                   class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-bold bg-amber-500 hover:bg-amber-600 text-white shadow-sm transition active:scale-95">
                                    <i class="bi bi-credit-card-2-front"></i>
                                    <span>Bayar Sekarang &rarr;</span>
                                </a>
                            @elseif($pesanan->status_pesanan === 'dibayar')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <i class="bi bi-patch-check-fill text-emerald-600"></i>
                                    Dibayar & Lunas
                                </span>
                            @elseif($pesanan->status_pesanan === 'dibatalkan')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                    <i class="bi bi-x-circle text-rose-600"></i>
                                    Dibatalkan
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    <i class="bi bi-clock-history"></i>
                                    {{ ucfirst(str_replace('_', ' ', $pesanan->status_pesanan)) }}
                                </span>
                            @endif
                        </div>

                    <!-- Informasi Pengiriman & Nomor Resi (Khusus Pelanggan) -->
                    @php
                        $infoPengiriman = $pesanan->pengiriman;
                        $nomorResiPelanggan = $infoPengiriman?->nomor_resi;
                        $kurirPelanggan = $infoPengiriman?->nama_kurir;
                    @endphp
                    @if($nomorResiPelanggan)
                        <div class="px-6 py-3.5 bg-gradient-to-r from-sky-50/90 via-blue-50/40 to-slate-50 border-b border-sky-100 flex flex-wrap items-center justify-between gap-3 text-xs">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-2xl bg-sky-600 text-white flex items-center justify-center flex-shrink-0 shadow-sm shadow-sky-200">
                                    <i class="bi bi-box-seam-fill text-sm"></i>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Ekspedisi:</span>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-[11px] font-extrabold bg-white text-slate-800 border border-slate-200 shadow-2xs">
                                            <i class="bi bi-truck text-sky-600"></i>
                                            {{ $kurirPelanggan ?? 'JNE Express' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[11px] text-slate-400">Nomor Resi:</span>
                                        <span class="font-mono font-bold text-slate-900 tracking-wider text-xs bg-sky-100/70 px-2.5 py-0.5 rounded border border-sky-200">
                                            {{ $nomorResiPelanggan }}
                                        </span>
                                        <button type="button" 
                                                onclick="copyNomorResi('{{ $nomorResiPelanggan }}', this)" 
                                                class="inline-flex items-center gap-1 text-[11px] font-bold text-sky-700 bg-white hover:bg-sky-50 px-2.5 py-0.5 rounded-full border border-sky-200 shadow-2xs transition active:scale-95"
                                                title="Salin Nomor Resi">
                                            <i class="bi bi-clipboard"></i>
                                            <span>Salin Resi</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Lacak Pesanan & Konfirmasi Terima -->
                            <div class="flex items-center gap-2">
                                <button type="button" 
                                        onclick="openModalLacak('{{ $pesanan->nomor_pesanan }}', '{{ $kurirPelanggan ?? 'Ekspedisi' }}', '{{ $nomorResiPelanggan }}', '{{ $pesanan->status_pesanan }}', '{{ addslashes($pesanan->nama_penerima ?? $user->nama) }}', '{{ addslashes($pesanan->alamat_pengiriman ?? '-') }}', '{{ addslashes($pesanan->kota ?? '-') }}')" 
                                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold bg-white hover:bg-sky-600 text-sky-700 hover:text-white border border-sky-200 hover:border-sky-600 shadow-2xs hover:shadow transition duration-150">
                                    <i class="bi bi-geo-alt-fill text-sky-600 group-hover:text-white"></i>
                                    <span>Lacak Pengiriman</span>
                                </button>

                                @if($pesanan->status_pesanan === 'dikirim')
                                    <button type="button" 
                                            onclick="openModalKonfirmasiTerima('{{ $pesanan->pesanan_id }}', '{{ $pesanan->nomor_pesanan }}', '{{ addslashes($kurirPelanggan ?? 'Ekspedisi') }}', '{{ addslashes($nomorResiPelanggan ?? '-') }}')" 
                                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-black bg-emerald-600 hover:bg-emerald-700 text-white shadow-2xs hover:shadow transition active:scale-95 cursor-pointer"
                                            title="Konfirmasi bahwa barang pesanan telah diterima (F10-07)">
                                        <i class="bi bi-check2-circle text-sm"></i>
                                        <span>Pesanan Diterima</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @elseif(in_array($pesanan->status_pesanan, ['diproses', 'dikirim']))
                        <div class="px-6 py-3 bg-amber-50/70 border-b border-amber-100/70 flex items-center justify-between text-xs text-amber-800">
                            <div class="flex items-center gap-2.5">
                                <i class="bi bi-hourglass-split text-amber-600 text-sm"></i>
                                <div>
                                    <span class="font-bold">Menunggu Resi Pengiriman</span> &bull; 
                                    <span class="text-amber-700 text-[11px]">Paket jam tangan sedang disiapkan & diperiksa keasliannya. Resi pengiriman akan terbit otomatis saat paket diserahkan ke kurir.</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Daftar Item Produk dalam Pesanan -->
                    <div class="p-6 divide-y divide-slate-100">
                        @foreach($pesanan->detail as $item)
                            @php
                                $sudahDiulas = $item->ulasan !== null;
                                $fotoItem = null;
                                if($item->varian && $item->varian->produk && $item->varian->produk->galeri->isNotEmpty()) {
                                    $fotoUtama = $item->varian->produk->galeri->where('foto_utama', 1)->first() ?? $item->varian->produk->galeri->first();
                                    $fotoItem = $fotoUtama ? $fotoUtama->url : null;
                                }
                            @endphp
                            <div class="py-4 first:pt-0 last:pb-0 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                <!-- Info Produk -->
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden flex-shrink-0 flex items-center justify-center">
                                        @if($fotoItem)
                                            <img src="{{ $fotoItem }}" alt="{{ $item->nama_produk }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="bi bi-watch text-2xl text-slate-400"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">A1ORA WATCH</div>
                                        <h3 class="text-sm font-bold text-slate-900">{{ $item->nama_produk }}</h3>
                                        <div class="text-xs text-slate-500 mt-0.5">
                                            Varian: {{ $item->nama_varian ?? 'Standard Edition' }} • Qty: {{ $item->jumlah }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Harga & Tombol Beri Ulasan / Sudah Diulas -->
                                <div class="flex items-center gap-4 self-end sm:self-auto">
                                    <div class="text-right">
                                        <div class="text-sm font-black text-slate-900">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </div>
                                    </div>

                                    <div>
                                        @if($pesanan->status_pesanan === 'selesai')
                                            @if($sudahDiulas)
                                                <!-- Tombol Sudah Diulas (Disabled) -->
                                                <button type="button" disabled 
                                                        class="px-4 py-2 rounded-full text-xs font-semibold bg-slate-100 text-slate-400 border border-slate-200 cursor-not-allowed">
                                                    Sudah Diulas
                                                </button>
                                            @else
                                                <!-- Tombol Beri Ulasan (Memicu Modal Pop-Up) -->
                                                <button type="button" 
                                                        onclick="openModalUlasan('{{ $item->detail_pesanan_id }}', '{{ addslashes($pesanan->nomor_pesanan) }}', '{{ addslashes($item->nama_produk) }}', '{{ addslashes($item->nama_varian ?? 'Standard') }}', '{{ $fotoItem ?? '' }}')"
                                                        class="px-5 py-2 rounded-full text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white shadow-sm hover:shadow-md transition">
                                                    Beri Ulasan
                                                </button>
                                            @endif
                                        @else
                                            <span class="text-xs text-slate-400 italic">Selesaikan pesanan untuk mengulas</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Footer Kartu Pesanan -->
                    <div class="px-6 py-3.5 bg-slate-50/50 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 text-xs">
                        <div class="text-slate-400 flex items-center gap-1.5">
                            <i class="bi bi-shield-check text-blue-600"></i>
                            <span>Dilindungi Asuransi A1ORA Care & Garansi 24 Bulan</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="font-semibold text-slate-700">
                                Total Pesanan: <strong class="text-slate-900 font-black text-sm">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong>
                            </div>
                            @if($pesanan->status_pesanan === 'dikirim')
                                <button type="button" 
                                        onclick="openModalKonfirmasiTerima('{{ $pesanan->pesanan_id }}', '{{ $pesanan->nomor_pesanan }}', '{{ addslashes($kurirPelanggan ?? 'Ekspedisi') }}', '{{ addslashes($nomorResiPelanggan ?? '-') }}')" 
                                        class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-black bg-emerald-600 hover:bg-emerald-700 text-white shadow-2xs hover:shadow transition active:scale-95 cursor-pointer"
                                        title="Konfirmasi bahwa barang pesanan telah diterima (F10-07)">
                                    <i class="bi bi-check2-circle text-sm"></i>
                                    <span>Konfirmasi Terima</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center text-slate-400 shadow-sm">
                    <i class="bi bi-bag-x text-5xl d-block mb-3 text-slate-300"></i>
                    <h3 class="text-base font-bold text-slate-700">Belum Ada Riwayat Pesanan</h3>
                    <p class="text-xs text-slate-400 mt-1">Anda belum memiliki transaksi pesanan pada kategori ini.</p>
                    <a href="{{ route('produk.index') }}" class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs px-5 py-2.5 rounded-full transition shadow">
                        Mulai Belanja Jam Tangan
                    </a>
                </div>
            @endforelse
        </div>

    </div>


    <div id="modalUlasan" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 hidden" style="z-index: 1055;">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl border border-slate-100 relative animate-in fade-in zoom-in-95 duration-200">
            
            <!-- Header Modal -->
            <div class="flex items-start justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg flex-shrink-0">
                        <i class="bi bi-chat-quote-fill"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-900 leading-tight">Beri Ulasan Produk</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Bantu kolektor lain memilih mahakarya terbaik</p>
                    </div>
                </div>

                <!-- Tombol Close (X) -->
                <button type="button" onclick="closeModalUlasan()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                    <i class="bi bi-x-lg text-xs"></i>
                </button>
            </div>

            <!-- Form Ulasan -->
            <form id="formUlasan" method="POST" action="{{ route('pelanggan.ulasan.store') }}" onsubmit="return validateFormUlasan(event)">
                @csrf
                <input type="hidden" name="detail_pesanan_id" id="modalDetailPesananId">
                <input type="hidden" name="rating" id="modalInputRating" value="5">

                <!-- Kartu Info Produk Terverifikasi -->
                <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-3 flex items-center gap-3.5 mb-5">
                    <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 flex-shrink-0 overflow-hidden flex items-center justify-center">
                        <img id="modalProductImg" src="" alt="" class="w-full h-full object-cover hidden">
                        <i id="modalProductIcon" class="bi bi-watch text-xl text-slate-400"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5 text-[10px] font-bold text-blue-600 uppercase tracking-wide">
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-blue-100/70 text-blue-700">
                                <i class="bi bi-patch-check-fill text-[9px]"></i> Terverifikasi Dibeli
                            </span>
                            <span id="modalOrderNo" class="text-slate-400 font-mono">#KW-20260412</span>
                        </div>
                        <h4 id="modalProductName" class="text-xs font-bold text-slate-900 mt-0.5">Halden Classic 40</h4>
                        <div id="modalProductVariant" class="text-[11px] text-slate-400">Varian: Rose Gold 40mm</div>
                    </div>
                </div>

                <!-- Section 1: Rating Bintang Interaktif -->
                <div class="mb-5">
                    <div class="flex justify-between items-center mb-1.5">
                        <label class="text-xs font-bold text-slate-800">
                            Rating Produk <span class="text-rose-500">*</span>
                        </label>
                        <span class="text-xs text-slate-400">Pilih Bintang 1-5</span>
                    </div>

                    <div class="flex items-center justify-between bg-slate-50 border border-slate-200/80 rounded-2xl p-3.5">
                        <!-- 5 Star Buttons -->
                        <div class="flex items-center gap-2" id="starContainer">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" onclick="setRating({{ $i }})" onmouseenter="hoverRating({{ $i }})" onmouseleave="resetHoverRating()"
                                        class="star-btn text-2xl text-amber-400 transition hover:scale-110 focus:outline-none" data-val="{{ $i }}">
                                    <i class="bi bi-star-fill"></i>
                                </button>
                            @endfor
                        </div>

                        <!-- Display Score Angka -->
                        <div class="text-sm font-extrabold text-slate-900">
                            <span id="displayScore">5.0</span> <span class="text-slate-400 text-xs font-semibold">/ 5.0</span>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Ulasan Teks -->
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-1.5">
                        <label class="text-xs font-bold text-slate-800">
                            Ulasan Anda <span class="text-rose-500">*</span>
                        </label>
                        <span id="charCountDisplay" class="text-xs text-slate-400 font-medium">0 / min. 15 karakter</span>
                    </div>

                    <textarea name="komentar" id="inputKomentar" rows="3" oninput="handleKomentarInput()"
                              placeholder="Ceritakan kepuasan Anda mengenai jam tangan, kenyamanan tali, atau presisi pergerakan jarum..."
                              class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-3.5 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"></textarea>

                    <!-- Peringatan Minimal Karakter -->
                    <div id="minCharWarning" class="text-xs text-rose-500 flex items-center gap-1.5 mt-1.5 hidden">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span>Ulasan wajib diisi minimal 15 karakter sebelum mengirimkan.</span>
                    </div>
                </div>

                <!-- Alert Banner: Formulir Belum Lengkap (Muncul jika ada error) -->
                <div id="formAlertBanner" class="bg-rose-50 border border-rose-200 rounded-2xl p-3.5 text-xs text-rose-800 flex items-start gap-2.5 mb-5 hidden">
                    <i class="bi bi-exclamation-triangle-fill text-rose-600 text-sm mt-0.5 flex-shrink-0"></i>
                    <div>
                        <strong class="font-bold block text-[11px] uppercase tracking-wider">FORMULIR BELUM LENGKAP</strong>
                        <span class="text-[11px]">Mohon lengkapi formulir ulasan dengan rating bintang dan ulasan yang valid (minimal 15 karakter) sebelum melanjutkan.</span>
                    </div>
                </div>

                <!-- Tombol Aksi Modal -->
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModalUlasan()" 
                            class="px-5 py-2.5 rounded-full text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-600 transition">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-6 py-2.5 rounded-full text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white shadow-md hover:shadow-lg transition inline-flex items-center gap-2">
                        <i class="bi bi-send-fill text-xs"></i>
                        <span>Kirim Ulasan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script>
        let currentRating = 5;

        function openModalUlasan(detailId, orderNo, productName, productVariant, photoUrl) {
            document.getElementById('modalDetailPesananId').value = detailId;
            document.getElementById('modalOrderNo').textContent = orderNo;
            document.getElementById('modalProductName').textContent = productName;
            document.getElementById('modalProductVariant').textContent = 'Varian: ' + productVariant;

            const imgEl = document.getElementById('modalProductImg');
            const iconEl = document.getElementById('modalProductIcon');
            if (photoUrl) {
                imgEl.src = photoUrl;
                imgEl.classList.remove('hidden');
                iconEl.classList.add('hidden');
            } else {
                imgEl.classList.add('hidden');
                iconEl.classList.remove('hidden');
            }

            // Reset form
            setRating(5);
            document.getElementById('inputKomentar').value = '';
            handleKomentarInput();
            document.getElementById('formAlertBanner').classList.add('hidden');

            // Tampilkan Modal
            document.getElementById('modalUlasan').classList.remove('hidden');
        }

        function closeModalUlasan() {
            document.getElementById('modalUlasan').classList.add('hidden');
        }

        // Fungsi Rating Bintang
        function setRating(val) {
            currentRating = val;
            document.getElementById('modalInputRating').value = val;
            document.getElementById('displayScore').textContent = val.toFixed(1);
            renderStars(val);
        }

        function hoverRating(val) {
            document.getElementById('displayScore').textContent = val.toFixed(1);
            renderStars(val);
        }

        function resetHoverRating() {
            document.getElementById('displayScore').textContent = currentRating.toFixed(1);
            renderStars(currentRating);
        }

        function renderStars(rating) {
            document.querySelectorAll('.star-btn').forEach(btn => {
                const val = parseInt(btn.dataset.val);
                if (val <= rating) {
                    btn.classList.add('text-amber-400');
                    btn.classList.remove('text-slate-300');
                    btn.innerHTML = '<i class="bi bi-star-fill"></i>';
                } else {
                    btn.classList.remove('text-amber-400');
                    btn.classList.add('text-slate-300');
                    btn.innerHTML = '<i class="bi bi-star"></i>';
                }
            });
        }

        // Fungsi Hitung Karakter Komentar
        function handleKomentarInput() {
            const input = document.getElementById('inputKomentar');
            const len = input.value.trim().length;
            document.getElementById('charCountDisplay').textContent = `${len} / min. 15 karakter`;

            const warning = document.getElementById('minCharWarning');
            if (len > 0 && len < 15) {
                warning.classList.remove('hidden');
                document.getElementById('charCountDisplay').classList.add('text-rose-500');
            } else {
                warning.classList.add('hidden');
                document.getElementById('charCountDisplay').classList.remove('text-rose-500');
            }
        }

        // Validasi Form Sebelum Kirim
        function validateFormUlasan(e) {
            const komentar = document.getElementById('inputKomentar').value.trim();
            const alertBanner = document.getElementById('formAlertBanner');

            if (currentRating < 1 || komentar.length < 15) {
                e.preventDefault();
                alertBanner.classList.remove('hidden');
                document.getElementById('minCharWarning').classList.remove('hidden');
                return false;
            }

            alertBanner.classList.add('hidden');
            return true;
        }

        // Close on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModalUlasan();
                closeModalLacak();
                closeModalKonfirmasiTerima();
            }
        });

        // Fitur Konfirmasi Terima Pesanan (F10-07 / BB-73 s/d BB-75)
        function openModalKonfirmasiTerima(id, nomorPesanan, kurir, resi) {
            document.getElementById('modalTerimaOrderNo').textContent = `Pesanan #${nomorPesanan}`;
            document.getElementById('modalTerimaKurir').textContent = kurir || 'Ekspedisi';
            document.getElementById('modalTerimaResi').textContent = resi || '-';
            document.getElementById('formKonfirmasiTerima').action = `/pelanggan/pesanan/${id}/terima`;
            document.getElementById('modalKonfirmasiTerima').classList.remove('hidden');
        }

        function closeModalKonfirmasiTerima() {
            document.getElementById('modalKonfirmasiTerima').classList.add('hidden');
        }

        // Fitur Salin Resi dengan Feedback Visual
        function copyNomorResi(resi, btn) {
            if (!resi) return;
            const originalHtml = btn.innerHTML;
            const performCopy = () => {
                btn.innerHTML = '<i class="bi bi-check2-circle text-emerald-600"></i> <span class="text-emerald-700 font-bold">Tersalin!</span>';
                btn.classList.add('border-emerald-300', 'bg-emerald-50');
                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                    btn.classList.remove('border-emerald-300', 'bg-emerald-50');
                }, 2000);
            };

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(resi).then(performCopy).catch(() => fallbackCopyText(resi, performCopy));
            } else {
                fallbackCopyText(resi, performCopy);
            }
        }

        function fallbackCopyText(text, callback) {
            const tempInput = document.createElement('input');
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            try {
                document.execCommand('copy');
                if (callback) callback();
            } catch (err) {
                alert('Gagal menyalin nomor resi.');
            }
            document.body.removeChild(tempInput);
        }

        // Fitur Modal Lacak Pengiriman
        let currentModalResi = '';

        function openModalLacak(nomorPesanan, kurir, resi, status, penerima, alamat, kota) {
            currentModalResi = resi;
            document.getElementById('modalLacakOrderNo').textContent = `Pesanan #${nomorPesanan}`;
            document.getElementById('modalLacakKurirText').textContent = kurir || 'JNE Express';
            document.getElementById('modalLacakResiText').textContent = resi || '-';
            document.getElementById('modalLacakTujuanText').textContent = `${penerima} - ${alamat}, ${kota}`;

            const stepDalamPengiriman = document.getElementById('stepDalamPengiriman');
            const stepSelesai = document.getElementById('stepSelesai');
            const dotDalamPengiriman = document.getElementById('dotDalamPengiriman');
            const dotSelesai = document.getElementById('dotSelesai');

            if (status === 'selesai') {
                dotDalamPengiriman.className = 'absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-emerald-500 border-2 border-white shadow';
                dotSelesai.className = 'absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-emerald-500 border-2 border-white shadow';
                stepSelesai.querySelector('.step-title').className = 'text-xs font-bold text-emerald-700';
            } else {
                dotDalamPengiriman.className = 'absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-sky-500 border-2 border-white shadow animate-pulse';
                dotSelesai.className = 'absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-slate-200 border-2 border-white';
                stepSelesai.querySelector('.step-title').className = 'text-xs font-bold text-slate-400';
            }

            document.getElementById('modalLacakPengiriman').classList.remove('hidden');
        }

        function closeModalLacak() {
            document.getElementById('modalLacakPengiriman').classList.add('hidden');
        }

        function copyModalResi(btn) {
            copyNomorResi(currentModalResi, btn);
        }
    </script>

    <!-- Modal Lacak Pengiriman Interaktif -->
    <div id="modalLacakPengiriman" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 hidden" style="z-index: 1055;">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-7 shadow-2xl border border-slate-100 relative animate-in fade-in zoom-in-95 duration-200">
            <!-- Header Modal -->
            <div class="flex items-start justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-lg flex-shrink-0">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-900 leading-tight">Lacak Pengiriman</h2>
                        <p class="text-xs text-slate-500 mt-0.5" id="modalLacakOrderNo">Pesanan #...</p>
                    </div>
                </div>
                <button type="button" onclick="closeModalLacak()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                    <i class="bi bi-x-lg text-xs"></i>
                </button>
            </div>

            <!-- Card Kurir & Resi -->
            <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 mb-5 space-y-3">
                <div class="flex justify-between items-center text-xs">
                    <span class="text-slate-500 font-medium">Jasa Ekspedisi:</span>
                    <span class="font-extrabold text-slate-900 uppercase bg-white px-2.5 py-1 rounded-lg border border-slate-200 flex items-center gap-1.5">
                        <i class="bi bi-box-seam text-sky-600"></i>
                        <span id="modalLacakKurirText">JNE Express</span>
                    </span>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="text-slate-500 font-medium">Nomor Resi:</span>
                    <div class="flex items-center gap-2">
                        <span class="font-mono font-black text-slate-900 tracking-wider text-sm bg-white px-2.5 py-1 rounded-lg border border-slate-200" id="modalLacakResiText">
                            -
                        </span>
                        <button type="button" onclick="copyModalResi(this)" class="inline-flex items-center gap-1 text-[11px] font-bold text-sky-700 bg-white hover:bg-sky-50 px-2 py-1 rounded-lg border border-sky-200 shadow-2xs transition" title="Salin Resi">
                            <i class="bi bi-clipboard text-xs"></i>
                            <span>Salin</span>
                        </button>
                    </div>
                </div>
                <div class="pt-2 border-t border-slate-200/70 text-[11px] text-slate-500">
                    <div class="flex items-start gap-1.5">
                        <i class="bi bi-geo-alt-fill text-rose-500 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <span class="font-bold text-slate-700">Tujuan Pengiriman:</span>
                            <span id="modalLacakTujuanText" class="text-slate-600 ml-1">-</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline Status Pengiriman -->
            <div class="mb-5">
                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">Status Perjalanan Paket</h4>
                <div class="relative pl-6 space-y-4 border-l-2 border-slate-200 ml-3 text-xs">
                    <!-- Step 1: Dibuat & Diverifikasi -->
                    <div class="relative">
                        <div class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-emerald-500 border-2 border-white shadow"></div>
                        <div class="font-bold text-slate-900">Pesanan Diverifikasi & Diproses</div>
                        <div class="text-[11px] text-slate-500">Pembayaran terverifikasi. Tim horologi memeriksa nomor seri, kondisi jam, & kelengkapan kartu garansi.</div>
                    </div>
                    <!-- Step 2: Resi Diterbitkan -->
                    <div class="relative">
                        <div class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-emerald-500 border-2 border-white shadow"></div>
                        <div class="font-bold text-slate-900">Paket Diserahkan ke Ekspedisi & Resi Terbit</div>
                        <div class="text-[11px] text-slate-500">Paket dikemas aman dengan bubble wrap lapis baja dan diserahkan ke agen ekspedisi.</div>
                    </div>
                    <!-- Step 3: Dalam Perjalanan -->
                    <div class="relative" id="stepDalamPengiriman">
                        <div id="dotDalamPengiriman" class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-sky-500 border-2 border-white shadow animate-pulse"></div>
                        <div class="font-bold text-sky-700">Dalam Perjalanan ke Kota Tujuan</div>
                        <div class="text-[11px] text-slate-500">Paket sedang berada di jalur transit ekspedisi menuju kota alamat penerima.</div>
                    </div>
                    <!-- Step 4: Selesai -->
                    <div class="relative" id="stepSelesai">
                        <div id="dotSelesai" class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-slate-200 border-2 border-white"></div>
                        <div class="step-title font-bold text-slate-400">Paket Tiba & Selesai</div>
                        <div class="text-[11px] text-slate-400">Paket berhasil diantar kurir dan diterima oleh pembeli.</div>
                    </div>
                </div>
            </div>

            <!-- Footer Modal -->
            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" onclick="closeModalLacak()" class="px-5 py-2 rounded-full text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Terima Pesanan (F10-07 / BB-73 s/d BB-75) -->
    <div id="modalKonfirmasiTerima" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 hidden" style="z-index: 1055;">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl border border-slate-100 relative animate-in fade-in zoom-in-95 duration-200">
            <!-- Header Modal -->
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl flex-shrink-0">
                        <i class="bi bi-box2-heart-fill"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900 leading-tight">Konfirmasi Penerimaan</h3>
                        <p class="text-xs text-slate-500 mt-0.5" id="modalTerimaOrderNo">Pesanan #...</p>
                    </div>
                </div>
                <button type="button" onclick="closeModalKonfirmasiTerima()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                    <i class="bi bi-x-lg text-xs"></i>
                </button>
            </div>

            <!-- Banner Info -->
            <div class="bg-emerald-50/70 border border-emerald-100 rounded-2xl p-4 mb-5 text-xs text-emerald-950 space-y-2">
                <div class="flex items-center gap-2 font-bold text-emerald-800">
                    <i class="bi bi-shield-check text-sm"></i>
                    <span>Verifikasi Paket Diterima</span>
                </div>
                <p class="text-[11px] text-emerald-700 leading-relaxed">
                    Pastikan jam tangan fisik telah Anda terima dari kurir (<strong id="modalTerimaKurir">Ekspedisi</strong>) dengan nomor resi <strong id="modalTerimaResi" class="font-mono bg-white px-1.5 py-0.5 rounded border border-emerald-200">-</strong> dalam kondisi baik dan lengkap.
                </p>
                <div class="text-[10px] text-emerald-600 bg-white/80 p-2.5 rounded-xl border border-emerald-100 flex items-center gap-1.5">
                    <i class="bi bi-info-circle-fill text-emerald-500"></i>
                    <span>Setelah konfirmasi, pesanan akan selesai dan Anda dapat memberikan ulasan produk.</span>
                </div>
            </div>

            <!-- Form Action -->
            <form id="formKonfirmasiTerima" method="POST" action="">
                @csrf
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModalKonfirmasiTerima()" class="px-5 py-2.5 rounded-full text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                        Belum Diterima
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-full text-xs font-black text-white bg-emerald-600 hover:bg-emerald-700 shadow-md hover:shadow-lg transition flex items-center gap-1.5 cursor-pointer">
                        <i class="bi bi-check2-circle text-sm"></i>
                        <span>Ya, Paket Sudah Diterima</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection