@extends('layouts.app')

@section('title', 'Kronos Watch - Horology Jakarta | Temukan Jam Tangan Yang Tepat')

@section('content')
<div class="container py-3">

    <!-- 1. HERO SECTION (Dark Luxury Gradient Card Sesuai Mockup) -->
    <div class="rounded-5 overflow-hidden shadow-lg p-4 p-md-5 mb-5 text-white position-relative" 
         style="background: radial-gradient(circle at 80% 25%, #1e293b 0%, #090e17 100%); border: 1px solid rgba(255,255,255,0.08);">
        
        <div class="row align-items-center g-4 py-2">
            <!-- Kolom Kiri: Headline & Pencarian Cepat -->
            <div class="col-lg-7">
                <span class="badge rounded-pill px-3 py-1.5 fw-bold mb-3 d-inline-flex align-items-center gap-1.5" 
                      style="background: rgba(37, 99, 235, 0.2); color: #60a5fa; border: 1px solid rgba(96, 165, 250, 0.3); font-size: 0.72rem; letter-spacing: 1px;">
                    <span class="rounded-circle d-inline-block" style="width: 6px; height: 6px; background: #3b82f6;"></span>
                    KOLEKSI TERBARU 2026
                </span>

                <h1 class="display-4 fw-bolder mb-3 text-white" style="letter-spacing: -1.2px; line-height: 1.15;">
                    Temukan Jam Tangan<br>
                    <span style="background: linear-gradient(90deg, #ffffff 40%, #94a3b8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        Yang Tepat
                    </span>
                </h1>

                <p class="text-white-50 fs-6 mb-4" style="max-width: 520px; line-height: 1.6; font-size: 0.95rem;">
                    Koleksi jam tangan analog, digital, dan smartwatch premium terbaik untuk menyempurnakan gaya dan kepribadian Anda setiap saat dengan presisi standar Swiss & Jepang.
                </p>

                <!-- Input Pencarian Cepat ke Halaman Katalog -->
                <form action="{{ route('produk.katalog') }}" method="GET" class="mb-4" style="max-width: 480px;">
                    <div class="bg-white rounded-pill p-1.5 ps-3 d-flex align-items-center shadow-lg">
                        <i class="bi bi-search text-muted me-2"></i>
                        <input type="text" name="q" class="form-control border-0 bg-transparent text-dark shadow-none" 
                               placeholder="Cari merek, model, atau seri jam tangan..." style="font-size: 0.88rem;">
                        <button type="submit" class="btn btn-primary rounded-pill px-3.5 py-2 fw-bold d-flex align-items-center gap-1.5 flex-shrink-0" 
                                style="background: #2563eb; font-size: 0.85rem;">
                            <span>Cari Produk</span>
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </form>

                <!-- 2 Badge Keunggulan di Bawah Pencarian -->
                <div class="d-flex flex-wrap gap-4 text-white-50 small">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; background: rgba(59, 130, 246, 0.2); color: #60a5fa;">
                            <i class="bi bi-patch-check-fill" style="font-size: 0.8rem;"></i>
                        </div>
                        <span style="font-size: 0.8rem;">100% Autentik & Bergaransi Resmi</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; background: rgba(16, 185, 129, 0.2); color: #34d399;">
                            <i class="bi bi-truck" style="font-size: 0.8rem;"></i>
                        </div>
                        <span style="font-size: 0.8rem;">Pengiriman Kilat & Aman Seluruh Indonesia</span>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Showcase Arloji Utama & Kartu Harga Melayang -->
            <div class="col-lg-5 text-center position-relative">
                @php
                    $heroFoto = null;
                    if ($heroProduct && $heroProduct->galeri->isNotEmpty()) {
                        $heroFotoObj = $heroProduct->galeri->where('foto_utama', 1)->first() ?? $heroProduct->galeri->first();
                        $heroFoto = $heroFotoObj ? asset('storage/' . $heroFotoObj->foto) : null;
                    }
                @endphp

                <div class="position-relative d-inline-block">
                    <!-- Foto Jam Hero -->
                    <div class="rounded-circle overflow-hidden mx-auto d-flex align-items-center justify-content-center shadow-lg" 
                         style="width: 320px; height: 320px; background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, rgba(255,255,255,0.01) 70%); border: 1px solid rgba(255,255,255,0.12);">
                        @if($heroFoto)
                            <img src="{{ $heroFoto }}" alt="{{ $heroProduct->nama_produk ?? 'Arloji Pilihan' }}" class="w-100 h-100 object-fit-contain p-3" style="filter: drop-shadow(0 15px 25px rgba(0,0,0,0.6));">
                        @else
                            <i class="bi bi-watch text-white-50" style="font-size: 8rem;"></i>
                        @endif
                    </div>

                    <!-- Floating Badge Harga & Detail -->
                    @if($heroProduct)
                        <div class="position-absolute bottom-0 end-0 bg-white text-dark rounded-4 p-2.5 px-3 shadow-lg d-flex align-items-center gap-3 border" 
                             style="transform: translate(10px, 15px); border-radius: 16px;">
                            <div class="text-start">
                                <span class="text-muted d-block font-monospace" style="font-size: 0.65rem; letter-spacing: 0.8px;">ARLOJI TERLARIS 2026</span>
                                <strong class="fs-6 d-block" style="color: #0f172a; line-height: 1.1;">
                                    Rp {{ number_format($heroProduct->harga_terendah ?? 0, 0, ',', '.') }}
                                </strong>
                            </div>
                            <a href="{{ route('produk.detail', $heroProduct->produk_id) }}" 
                               class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center shadow-xs flex-shrink-0" 
                               style="width: 34px; height: 34px; background: #2563eb;" title="Lihat Arloji Ini">
                                <i class="bi bi-arrow-right text-white"></i>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- 3 Box Keunggulan Mesin Horologi di Bawah Foto -->
                <div class="row g-2 mt-4 pt-2">
                    <div class="col-4">
                        <div class="p-2 rounded-3 border" style="background: rgba(255,255,255,0.04); border-color: rgba(255,255,255,0.08) !important;">
                            <i class="bi bi-award text-primary d-block mb-1"></i>
                            <div class="small fw-semibold text-white" style="font-size: 0.72rem;">100% Autentik</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 rounded-3 border" style="background: rgba(255,255,255,0.04); border-color: rgba(255,255,255,0.08) !important;">
                            <i class="bi bi-clock-history text-info d-block mb-1"></i>
                            <div class="small fw-semibold text-white" style="font-size: 0.72rem;">Kaliber Presisi</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 rounded-3 border" style="background: rgba(255,255,255,0.04); border-color: rgba(255,255,255,0.08) !important;">
                            <i class="bi bi-shield-check text-success d-block mb-1"></i>
                            <div class="small fw-semibold text-white" style="font-size: 0.72rem;">Garansi 2 Thn</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- 2. KATEGORI PILIHAN JAM TANGAN -->
    <div class="mb-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-2 mb-4">
            <div>
                <span class="text-primary fw-bold text-uppercase small d-block mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">
                    JELAJAHI PILIHAN
                </span>
                <h3 class="fw-bolder text-dark mb-0" style="letter-spacing: -0.5px;">Kategori Pilihan Jam Tangan</h3>
            </div>
            <p class="text-muted small mb-0 text-md-end" style="max-width: 420px; font-size: 0.82rem;">
                Pilihan kurasi lengkap dari jam tangan estetika classic, unik, hingga smart wearable teknologi tinggi.
            </p>
        </div>

        <div class="row g-3">
            @forelse($daftarKategori as $kat)
                @php
                    // Ambil salah satu foto produk aktif dari kategori ini sebagai cover
                    $sampleProduk = \App\Models\Produk::where('kategori_id', $kat->kategori_id)
                        ->where('status_produk', 'aktif')
                        ->with('galeri')
                        ->first();
                    $katFoto = null;
                    if ($sampleProduk && $sampleProduk->galeri->isNotEmpty()) {
                        $fObj = $sampleProduk->galeri->where('foto_utama', 1)->first() ?? $sampleProduk->galeri->first();
                        $katFoto = $fObj ? asset('storage/' . $fObj->foto) : null;
                    }
                @endphp
                <div class="col-6 col-md-4 col-lg-4">
                    <a href="{{ route('produk.katalog', ['kategori_id' => $kat->kategori_id]) }}" class="text-decoration-none">
                        <div class="card border-0 rounded-4 bg-white p-3.5 shadow-xs h-100 transition-all hover-translate" 
                             style="border: 1px solid #e2e8f0 !important; transition: all 0.25s ease;">
                            
                            <!-- Foto / Visual Kategori -->
                            <div class="rounded-3 bg-light overflow-hidden d-flex align-items-center justify-content-center mb-3" style="height: 140px;">
                                @if($katFoto)
                                    <img src="{{ $katFoto }}" alt="{{ $kat->nama_kategori }}" class="w-100 h-100 object-fit-contain p-2">
                                @else
                                    <i class="bi bi-watch text-secondary" style="font-size: 3.5rem;"></i>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Jam Tangan {{ $kat->nama_kategori }}</h6>
                                <i class="bi bi-arrow-right text-primary"></i>
                            </div>
                            <div class="text-muted small" style="font-size: 0.75rem;">
                                Koleksi Kurasi Pilihan &bull; <span class="text-primary fw-semibold">{{ $kat->produk_count }} Produk</span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border rounded-4 text-center py-4 text-muted small">
                        Kategori jam tangan belum tersedia di database.
                    </div>
                </div>
            @endforelse
        </div>
    </div>


    <!-- 3. PRODUK TERBARU & TERLARIS (8 Card Grid Sesuai Mockup) -->
    <div class="mb-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <span class="text-primary fw-bold text-uppercase small d-block mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">
                    PRODUK TERBAIK
                </span>
                <h3 class="fw-bolder text-dark mb-0" style="letter-spacing: -0.5px;">Produk Terbaru & Terlaris</h3>
            </div>

            <!-- Tab Filter Kategori Cepat -->
            <div class="d-flex flex-wrap gap-1.5">
                <a href="{{ route('produk.katalog') }}" class="btn btn-sm btn-dark rounded-pill px-3 py-1.5 fw-semibold" style="font-size: 0.78rem;">
                    Semua Produk
                </a>
                @foreach($daftarKategori->take(4) as $kPill)
                    <a href="{{ route('produk.katalog', ['kategori_id' => $kPill->kategori_id]) }}" 
                       class="btn btn-sm btn-light border rounded-pill px-3 py-1.5 fw-semibold text-secondary" style="font-size: 0.78rem;">
                        {{ $kPill->nama_kategori }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Grid 8 Kartu Jam Tangan -->
        <div class="row g-3 g-md-4">
            @forelse($produkTerbaru as $item)
                @php
                    $fotoItem = null;
                    if ($item->galeri->isNotEmpty()) {
                        $fObj = $item->galeri->where('foto_utama', 1)->first() ?? $item->galeri->first();
                        $fotoItem = $fObj ? asset('storage/' . $fObj->foto) : null;
                    }
                    $ratingVal = $item->ulasan_avg_rating ? round($item->ulasan_avg_rating, 1) : 4.9;
                @endphp
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card border-0 rounded-4 bg-white shadow-xs overflow-hidden h-100 d-flex flex-column position-relative" 
                         style="border: 1px solid #e2e8f0 !important; transition: all 0.25s ease;">
                        
                        <!-- Badge Ready Stock Top-Left -->
                        <div class="position-absolute top-0 start-0 m-2.5" style="z-index: 2;">
                            <span class="badge rounded-pill px-2.5 py-1 fw-bold text-uppercase" 
                                  style="background: #e0f2fe; color: #0284c7; font-size: 0.65rem; letter-spacing: 0.5px;">
                                READY
                            </span>
                        </div>

                        <!-- Foto Jam Tangan -->
                        <a href="{{ route('produk.detail', $item->produk_id) }}" class="d-block bg-light position-relative overflow-hidden" style="height: 200px;">
                            @if($fotoItem)
                                <img src="{{ $fotoItem }}" alt="{{ $item->nama_produk }}" class="w-100 h-100 object-fit-contain p-3" style="transition: transform 0.3s ease;">
                            @else
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                    <i class="bi bi-watch" style="font-size: 3.5rem;"></i>
                                </div>
                            @endif
                        </a>

                        <!-- Informasi Produk -->
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <span class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.68rem; letter-spacing: 0.5px;">
                                {{ $item->merek->nama_merek ?? 'KRONOS WATCH' }}
                            </span>

                            <h6 class="fw-bold text-dark text-truncate mb-1.5" style="font-size: 0.9rem;" title="{{ $item->nama_produk }}">
                                <a href="{{ route('produk.detail', $item->produk_id) }}" class="text-decoration-none text-dark">
                                    {{ $item->nama_produk }}
                                </a>
                            </h6>

                            <!-- Rating Ulasan -->
                            <div class="d-flex align-items-center gap-1.5 mb-2.5">
                                <i class="bi bi-star-fill text-warning" style="font-size: 0.75rem;"></i>
                                <span class="small fw-bold text-dark" style="font-size: 0.78rem;">{{ $ratingVal }}</span>
                                <span class="text-muted small" style="font-size: 0.72rem;">({{ $item->ulasan_count ?? 12 }})</span>
                            </div>

                            <!-- Harga & Tombol Aksi (Sticky Bottom di Kartu) -->
                            <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted d-block" style="font-size: 0.65rem;">Harga Mulai:</span>
                                    <strong class="text-dark fs-6" style="font-size: 0.95rem !important;">
                                        Rp {{ number_format($item->harga_terendah ?? 0, 0, ',', '.') }}
                                    </strong>
                                </div>
                                <a href="{{ route('produk.detail', $item->produk_id) }}" 
                                   class="btn btn-dark rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 shadow-xs" 
                                   style="width: 34px; height: 34px; background: #0f172a;" title="Lihat Detail Arloji">
                                    <i class="bi bi-arrow-right text-white"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border rounded-4 text-center py-5 text-muted">
                        <i class="bi bi-watch fs-1 d-block mb-2 text-secondary"></i>
                        <h6 class="fw-bold text-dark">Belum Ada Produk Ditampilkan</h6>
                        <p class="small text-muted mb-0">Admin dapat menambahkan jam tangan baru melalui dashboard admin.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Tombol Besar Lihat Semua Koleksi -->
        <div class="text-center mt-4 pt-2">
            <a href="{{ route('produk.katalog') }}" 
               class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-sm d-inline-flex align-items-center gap-2" 
               style="background: #2563eb; font-size: 0.92rem;">
                <span>LIHAT SEMUA KOLEKSI JAM TANGAN</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>


    <!-- 4. BANNER KURASI EKSKLUSIF (Dark Luxury Promo Card Sesuai Mockup) -->
    <div class="rounded-5 overflow-hidden p-4 p-md-5 mb-5 text-white position-relative" 
         style="background: linear-gradient(135deg, #0b1322 0%, #1e293b 100%); border: 1px solid rgba(255,255,255,0.08);">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge rounded-pill px-3 py-1.5 fw-bold mb-3 d-inline-flex align-items-center gap-1.5" 
                      style="background: rgba(239, 68, 68, 0.2); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); font-size: 0.72rem; letter-spacing: 1px;">
                    <span class="rounded-circle d-inline-block" style="width: 6px; height: 6px; background: #ef4444;"></span>
                    KURASI HOROLOGI EKSKLUSIF
                </span>

                <h2 class="display-6 fw-bolder mb-3 text-white" style="letter-spacing: -0.8px; line-height: 1.2;">
                    Koleksi Autentik Kaliber Mekanis & Chronograph Pilihan
                </h2>

                <p class="text-white-50 fs-6 mb-4" style="max-width: 540px; line-height: 1.6; font-size: 0.92rem;">
                    Dapatkan kurasi jam tangan mewah bergaransi distributor resmi Indonesia. Dilengkapi sertifikat nomor seri keaslian dan layanan gratis perawatan mesin hingga 2 tahun.
                </p>

                <div class="d-flex flex-wrap align-items-center gap-3">
                    <a href="{{ route('produk.katalog') }}" class="btn btn-light rounded-pill px-4 py-2.5 fw-bold text-dark shadow-sm d-inline-flex align-items-center gap-2" style="font-size: 0.88rem;">
                        <span>Jelajahi Koleksi Lengkap</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                    <span class="text-white-50 small">&bull; Ready Stock di Butik Plaza Senayan</span>
                </div>
            </div>

            <div class="col-lg-5 text-center d-none d-lg-block">
                <div class="p-4 rounded-4 text-center border" style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.08) !important;">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px; background: rgba(37,99,235,0.2); color: #60a5fa;">
                        <i class="bi bi-watch fs-2"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-1">KRONOS ATELIER</h5>
                    <p class="text-white-50 small mb-0" style="font-size: 0.78rem;">Kurasi Arloji Berstandar Internasional</p>
                </div>
            </div>
        </div>
    </div>


    <!-- 5. APA KATA KOLEKTOR & PEMBELI KAMI (Testimoni Sesuai Mockup) -->
    <div class="mb-5">
        <div class="text-center max-w-lg mx-auto mb-4">
            <span class="text-primary fw-bold text-uppercase small d-block mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">
                TESTIMONI TERPERCAYA
            </span>
            <h3 class="fw-bolder text-dark mb-2" style="letter-spacing: -0.5px;">Apa Kata Kolektor & Pembeli Kami</h3>
            <p class="text-muted small mb-0 mx-auto" style="max-width: 540px; font-size: 0.82rem;">
                Kepuasan dan autentisitas pengalaman ribuan kolektor serta profesional pecinta jam tangan di seluruh Nusantara.
            </p>
        </div>

        <div class="row g-3">
            <!-- Testimoni 1 -->
            <div class="col-md-4">
                <div class="card border-0 rounded-4 bg-white p-4 shadow-xs h-100" style="border: 1px solid #e2e8f0 !important;">
                    <div class="d-flex justify-content-between align-items-center mb-2.5">
                        <div class="text-warning small">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <span class="badge bg-success-subtle text-success small fw-semibold" style="font-size: 0.7rem;">
                            <i class="bi bi-patch-check-fill me-1"></i> Pembeli Terverifikasi
                        </span>
                    </div>
                    <p class="text-dark small mb-3 flex-grow-1" style="font-size: 0.82rem; line-height: 1.6;">
                        "Finishing bezel dan rantainya luar biasa rapi. Dial sunburst biru kelihatan sangat mewah di bawah sinar matahari. Packing box kayu sangat aman!"
                    </p>
                    <div class="d-flex align-items-center gap-2.5 pt-2 border-top">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 36px; height: 36px; background: #1e293b; font-size: 0.8rem;">
                            BW
                        </div>
                        <div>
                            <div class="fw-bold text-dark small" style="font-size: 0.82rem;">Bambang Wicaksono</div>
                            <div class="text-muted" style="font-size: 0.7rem;">Kolektor Jam Pria &bull; Jakarta</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testimoni 2 -->
            <div class="col-md-4">
                <div class="card border-0 rounded-4 bg-white p-4 shadow-xs h-100" style="border: 1px solid #e2e8f0 !important;">
                    <div class="d-flex justify-content-between align-items-center mb-2.5">
                        <div class="text-warning small">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <span class="badge bg-success-subtle text-success small fw-semibold" style="font-size: 0.7rem;">
                            <i class="bi bi-patch-check-fill me-1"></i> Pembeli Terverifikasi
                        </span>
                    </div>
                    <p class="text-dark small mb-3 flex-grow-1" style="font-size: 0.82rem; line-height: 1.6;">
                        "Pengiriman kilat ke Surabaya aman dengan asuransi. Ukuran 42mm pas banget untuk kado suami saya. Kualitas build sangat solid dan mewah."
                    </p>
                    <div class="d-flex align-items-center gap-2.5 pt-2 border-top">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 36px; height: 36px; background: #2563eb; font-size: 0.8rem;">
                            CG
                        </div>
                        <div>
                            <div class="fw-bold text-dark small" style="font-size: 0.82rem;">drg. Clarissa Gunawan</div>
                            <div class="text-muted" style="font-size: 0.7rem;">Pembeli &bull; Surabaya</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testimoni 3 -->
            <div class="col-md-4">
                <div class="card border-0 rounded-4 bg-white p-4 shadow-xs h-100" style="border: 1px solid #e2e8f0 !important;">
                    <div class="d-flex justify-content-between align-items-center mb-2.5">
                        <div class="text-warning small">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <span class="badge bg-success-subtle text-success small fw-semibold" style="font-size: 0.7rem;">
                            <i class="bi bi-patch-check-fill me-1"></i> Pembeli Terverifikasi
                        </span>
                    </div>
                    <p class="text-dark small mb-3 flex-grow-1" style="font-size: 0.82rem; line-height: 1.6;">
                        "Lume BGW9-nya terang banget waktu gelap. Kartu garansi NFC terverifikasi langsung di website resmi. Sangat puas belanja di Kronos!"
                    </p>
                    <div class="d-flex align-items-center gap-2.5 pt-2 border-top">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 36px; height: 36px; background: #059669; font-size: 0.8rem;">
                            RM
                        </div>
                        <div>
                            <div class="fw-bold text-dark small" style="font-size: 0.82rem;">Reza Mahardika</div>
                            <div class="text-muted" style="font-size: 0.7rem;">Kolektor &bull; Bandung</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- 6. TRUST BADGES BAR (3 Pilar Keunggulan Butik) -->
    <div class="card border-0 rounded-4 bg-white p-4 shadow-xs mb-4" style="border: 1px solid #e2e8f0 !important;">
        <div class="row g-4 text-center text-md-start">
            <div class="col-md-4 d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 48px; height: 48px; background: #eff6ff; color: #2563eb;">
                    <i class="bi bi-patch-check-fill fs-4"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-dark mb-1" style="font-size: 0.88rem;">100% Autentik & Bergaransi Resmi</h6>
                    <p class="text-muted small mb-0" style="font-size: 0.75rem;">Sertifikasi nomor seri internasional dan garansi orisinal pabrikan penuh.</p>
                </div>
            </div>

            <div class="col-md-4 d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 48px; height: 48px; background: #f0fdf4; color: #16a34a;">
                    <i class="bi bi-shield-check fs-4"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-dark mb-1" style="font-size: 0.88rem;">Pengiriman Berasuransi Aman</h6>
                    <p class="text-muted small mb-0" style="font-size: 0.75rem;">Proteksi kurir khusus segel anti-rusak untuk menjamin jam tangan utuh.</p>
                </div>
            </div>

            <div class="col-md-4 d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                     style="width: 48px; height: 48px; background: #fff1f2; color: #e11d48;">
                    <i class="bi bi-tools fs-4"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-dark mb-1" style="font-size: 0.88rem;">Garansi Servis Mesin 2 Tahun</h6>
                    <p class="text-muted small mb-0" style="font-size: 0.75rem;">Layanan kalibrasi dan pengecekan mesin mekanik berkala di butik kami.</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
