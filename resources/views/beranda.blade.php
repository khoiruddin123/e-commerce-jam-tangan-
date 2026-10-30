@extends('layouts.app')

@section('title', 'A1ORA Watch - Horology Jakarta | Temukan Jam Tangan Yang Tepat')

@section('content')

<!-- ==========================================
     1. HERO SECTION: FULL WIDTH DARI KANAN KE KIRI (Edge to Edge)
     Sesuai Mockup Desain Figma Desktop
     ========================================== -->
<section class="hero-section w-100 position-relative text-white overflow-hidden py-4 py-lg-5" 
         style="background: radial-gradient(circle at 72% 35%, #182848 0%, #0c1427 48%, #060913 100%);">
    
    <!-- Ambient Lighting Glow Decorative Circle -->
    <div class="position-absolute top-0 end-0 translate-middle-y rounded-circle pointer-events-none" 
         style="width: 550px; height: 550px; background: radial-gradient(circle, rgba(37,99,235,0.18) 0%, rgba(37,99,235,0) 70%); filter: blur(50px); z-index: 1;"></div>

    <div class="container-fluid position-relative" style="max-width: 1440px; padding-left: clamp(1rem, 3.5vw, 2.5rem); padding-right: clamp(1rem, 3.5vw, 2.5rem); z-index: 2;">
        <div class="row align-items-center g-4 g-lg-5 py-2">
            
            <!-- Kolom Kiri: Headline & Pencarian Cepat Sesuai Figma -->
            <div class="col-lg-7">
                
                <!-- Badge Koleksi Terbaru -->
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill mb-3" 
                     style="background: rgba(37, 99, 235, 0.16); border: 1px solid rgba(59, 130, 246, 0.35); color: #60a5fa; font-size: 0.72rem; font-weight: 700; letter-spacing: 1.2px;">
                    <span class="rounded-circle d-inline-block" style="width: 6px; height: 6px; background: #3b82f6;"></span>
                    KOLEKSI TERBARU 2026
                </div>

                <!-- Headline -->
                <h1 class="display-4 fw-bolder text-white mb-3" style="letter-spacing: -1.5px; line-height: 1.15; font-size: clamp(2.3rem, 4vw, 3.5rem);">
                    Temukan Jam Tangan<br>
                    <span style="background: linear-gradient(90deg, #ffffff 40%, #cbd5e1 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        Yang Tepat
                    </span>
                </h1>

                <!-- Subtitle -->
                <p class="text-white-50 mb-4" style="max-width: 520px; font-size: 0.95rem; line-height: 1.65; color: #94a3b8 !important;">
                    Koleksi jam tangan analog, digital, dan smartwatch premium terbaik untuk menyempurnakan gaya dan kepribadian Anda setiap saat dengan presisi standar Swiss.
                </p>

                <!-- Input Pencarian Putih Kapsul Sesuai Figma -->
                <form action="{{ route('produk.katalog') }}" method="GET" class="mb-4" style="max-width: 520px;">
                    <div class="bg-white rounded-pill p-1.5 ps-3 d-flex align-items-center shadow-lg" style="box-shadow: 0 10px 25px rgba(0,0,0,0.4) !important;">
                        <i class="bi bi-search text-muted me-2" style="font-size: 0.95rem;"></i>
                        <input type="text" name="q" class="form-control border-0 bg-transparent text-dark shadow-none px-1" 
                               placeholder="Cari nama, merek, atau seri jam tangan..." style="font-size: 0.88rem;">
                        <button type="submit" class="btn btn-primary rounded-pill px-3.5 py-2 fw-semibold d-flex align-items-center gap-1.5 flex-shrink-0" 
                                style="background: #2563eb; font-size: 0.85rem; border: none;">
                            <span>Cari Produk</span>
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </form>

                <!-- 2 Feature Pills Gelap di Bawah Pencarian Sesuai Figma -->
                <div class="d-flex flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-2.5 p-2 px-3 rounded-4" 
                         style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); backdrop-filter: blur(8px);">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                             style="width: 32px; height: 32px; background: rgba(37, 99, 235, 0.2); color: #60a5fa;">
                            <i class="bi bi-patch-check-fill" style="font-size: 0.95rem;"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white" style="font-size: 0.8rem; line-height: 1.2;">100% Autentik Resmi</div>
                            <div class="text-white-50" style="font-size: 0.7rem;">Bergaransi Resmi 2 Tahun</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2.5 p-2 px-3 rounded-4" 
                         style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); backdrop-filter: blur(8px);">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                             style="width: 32px; height: 32px; background: rgba(16, 185, 129, 0.2); color: #34d399;">
                            <i class="bi bi-truck" style="font-size: 0.95rem;"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white" style="font-size: 0.8rem; line-height: 1.2;">Pengiriman Kilat & Aman</div>
                            <div class="text-white-50" style="font-size: 0.7rem;">Cakupan Seluruh Indonesia</div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Kolom Kanan: Showcase Arloji Sesuai Figma -->
            <div class="col-lg-5">
                <div class="position-relative">
                    
                    @php
                        // Prioritaskan arloji Figma resmi transparan kualitas tinggi (HD Casio Watch)
                        $heroWatchImg = asset('images/hero-watch.png') . '?v=' . (file_exists(public_path('images/hero-watch.png')) ? filemtime(public_path('images/hero-watch.png')) : time());
                        $heroDetailRoute = route('produk.katalog');
                        $heroPriceDisplay = 'Rp 4.850.000';

                        if ($heroProduct) {
                            $heroDetailRoute = route('produk.detail', $heroProduct->produk_id);
                            if ($heroProduct->harga_terendah) {
                                $heroPriceDisplay = 'Rp ' . number_format($heroProduct->harga_terendah, 0, ',', '.');
                            }
                        }
                    @endphp

                    <!-- Foto Jam Arloji & Badge Harga Melayang -->
                    <div class="position-relative text-center py-2" style="min-height: 280px; display: flex; align-items: center; justify-content: center;">
                        <img src="{{ $heroWatchImg }}" 
                             alt="A1ORA Luxury Watch" 
                             class="img-fluid position-relative" 
                             style="max-height: 330px; object-fit: contain; filter: drop-shadow(0 25px 35px rgba(0,0,0,0.85));">
                        
                        <!-- Floating Badge Harga Kanan Bawah Sesuai Figma -->
                        <div class="position-absolute bg-white text-dark rounded-4 p-2 px-3 shadow-lg d-flex align-items-center gap-3 border" 
                             style="bottom: 5px; right: 5px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.35) !important;">
                            <div class="text-start">
                                <span class="text-muted d-block fw-bold font-monospace" style="font-size: 0.62rem; letter-spacing: 0.8px;">SERI UTAMA 2026</span>
                                <strong class="fs-6 d-block" style="color: #0f172a; line-height: 1.1;">
                                    {{ $heroPriceDisplay }}
                                </strong>
                            </div>
                            <a href="{{ $heroDetailRoute }}" 
                               class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center shadow-xs flex-shrink-0" 
                               style="width: 34px; height: 34px; background: #2563eb;" title="Lihat Arloji Ini">
                                <i class="bi bi-arrow-right text-white"></i>
                            </a>
                        </div>
                    </div>

                    <!-- 3 Box Spesifikasi Teknis di Bawah Arloji Sesuai Figma -->
                    <div class="row g-2 mt-3 pt-2">
                        <div class="col-4">
                            <div class="p-2.5 rounded-3 text-center" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                                <i class="bi bi-gear-wide-connected text-primary d-block mb-1" style="font-size: 1rem;"></i>
                                <div class="text-white-50 text-uppercase fw-semibold" style="font-size: 0.6rem; letter-spacing: 0.5px;">MOVEMENT</div>
                                <div class="text-white fw-bold" style="font-size: 0.75rem;">Swiss Calibre</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2.5 rounded-3 text-center" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                                <i class="bi bi-shield-shaded text-info d-block mb-1" style="font-size: 1rem;"></i>
                                <div class="text-white-50 text-uppercase fw-semibold" style="font-size: 0.6rem; letter-spacing: 0.5px;">CASE MATERIAL</div>
                                <div class="text-white fw-bold" style="font-size: 0.75rem;">316L Solid Steel</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-2.5 rounded-3 text-center" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08);">
                                <i class="bi bi-droplet-fill text-primary d-block mb-1" style="font-size: 1rem;"></i>
                                <div class="text-white-50 text-uppercase fw-semibold" style="font-size: 0.6rem; letter-spacing: 0.5px;">WATER RESIST</div>
                                <div class="text-white fw-bold" style="font-size: 0.75rem;">10ATM / 100M</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- ==========================================
     KONTEN HALAMAN BERANDA (Full-Bleed Container 1440px)
     ========================================== -->
<div class="container-fluid py-5" style="max-width: 1440px; padding-left: clamp(1rem, 3.5vw, 2.5rem); padding-right: clamp(1rem, 3.5vw, 2.5rem);">

    <!-- 2. KATEGORI PILIHAN JAM TANGAN (Bentuk Card Rapi Horizontal) -->
    <div class="mb-5 pb-2">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-2 mb-4">
            <div>
                <span class="text-primary fw-bold text-uppercase small d-block mb-1" style="font-size: 0.75rem; letter-spacing: 1.2px;">
                    <i class="bi bi-grid me-1"></i>JELAJAHI PILIHAN
                </span>
                <h3 class="fw-bolder text-dark mb-0" style="letter-spacing: -0.6px; font-size: clamp(1.4rem, 2.5vw, 1.85rem);">
                    Kategori Pilihan Jam Tangan
                </h3>
            </div>
            <p class="text-muted small mb-0 text-md-end" style="max-width: 460px; font-size: 0.84rem; line-height: 1.5;">
                Pilihan kurasi terlengkap dari berbagai estetika desain, mekanik presisi, dan teknologi pintar terdepan.
            </p>
        </div>

        <div class="row g-3 g-lg-4">
            @forelse($daftarKategori as $kat)
                @php
                    $sampleProduk = \App\Models\Produk::where('kategori_id', $kat->kategori_id)
                        ->where('status_produk', 'aktif')
                        ->whereHas('galeri')
                        ->with('galeri')
                        ->first();
                    $katFoto = null;
                    if ($sampleProduk && $sampleProduk->galeri->isNotEmpty()) {
                        $fObj = $sampleProduk->galeri->where('foto_utama', 1)->first() ?? $sampleProduk->galeri->first();
                        if ($fObj) {
                            $katFoto = $fObj->url;
                        }
                    }
                    $katSlug = strtolower(trim($kat->nama_kategori));
                @endphp
                <div class="col-12 col-md-4">
                    <a href="{{ route('produk.katalog', ['kategori_id' => $kat->kategori_id]) }}" class="text-decoration-none">
                        <div class="card border rounded-4 bg-white p-3 shadow-xs h-100 category-card" 
                             style="border-color: #e2e8f0 !important; transition: all 0.25s ease;">
                            <div class="d-flex align-items-center gap-3">
                                <!-- Square Image Thumbnail -->
                                <div class="rounded-4 overflow-hidden flex-shrink-0 d-flex align-items-center justify-content-center position-relative" 
                                     style="width: 100px; height: 100px; background: radial-gradient(circle, #ffffff 0%, #f1f5f9 100%); border: 1px solid #e2e8f0;">
                                    @if($katFoto)
                                        <img src="{{ $katFoto }}" alt="{{ $kat->nama_kategori }}" class="w-100 h-100 object-fit-cover category-img" style="transition: transform 0.3s ease;">
                                    @else
                                        @if($katSlug === 'analog')
                                            <i class="bi bi-clock text-primary fs-2"></i>
                                        @elseif($katSlug === 'digital')
                                            <i class="bi bi-smartwatch text-info fs-2"></i>
                                        @elseif($katSlug === 'sport')
                                            <i class="bi bi-stopwatch text-warning fs-2"></i>
                                        @else
                                            <i class="bi bi-watch text-primary fs-2"></i>
                                        @endif
                                    @endif
                                </div>
                                <!-- Content -->
                                <div class="flex-grow-1 min-w-0">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="badge bg-primary-subtle text-primary rounded-pill px-2.5 py-0.5 fw-bold" style="font-size: 0.68rem;">
                                            {{ $kat->produk_count }} KOLEKSI
                                        </span>
                                    </div>
                                    <h6 class="fw-bold text-dark text-truncate mb-1" style="font-size: 1.02rem; letter-spacing: -0.2px;">
                                        Jam Tangan {{ $kat->nama_kategori }}
                                    </h6>
                                    <p class="text-muted small mb-0 text-truncate" style="font-size: 0.78rem;">
                                        {{ $kat->deskripsi ?? 'Kurasi presisi horologi resmi' }}
                                    </p>
                                </div>
                                <!-- Action Button -->
                                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 category-arrow-btn" 
                                     style="width: 34px; height: 34px; background: #eff6ff; color: #2563eb; transition: all 0.2s ease;">
                                    <i class="bi bi-arrow-right fs-6"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                        <!-- Pesan jika tidak ada produk yang cocok dengan kategori filter -->
            <div class="col-12 d-none" id="noFilterResults">
                <div class="alert alert-light border rounded-4 text-center py-5 text-muted">
                    <i class="bi bi-watch fs-1 d-block mb-2 text-secondary"></i>
                    <h6 class="fw-bold text-dark">Belum Ada Jam Tangan di Kategori Ini</h6>
                    <p class="small text-muted mb-0">Silakan pilih kategori lainnya atau lihat seluruh koleksi kami.</p>
                </div>
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

            <!-- Tab Filter Kategori Cepat (Interaktif) -->
            <div class="d-flex flex-wrap gap-1.5" id="productFilterTabs">
                <button type="button" class="btn btn-sm btn-dark rounded-pill px-3 py-1.5 fw-semibold filter-tab-btn active" data-filter="all" style="font-size: 0.78rem;">
                    Semua Produk
                </button>
                @foreach($daftarKategori as $kPill)
                    <button type="button" class="btn btn-sm btn-light border rounded-pill px-3 py-1.5 fw-semibold text-secondary filter-tab-btn" 
                            data-filter="{{ $kPill->kategori_id }}" style="font-size: 0.78rem;">
                        {{ $kPill->nama_kategori }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Grid 8 Kartu Jam Tangan -->
        <div class="row g-3 g-md-4" id="productGridContainer">
            @forelse($produkTerbaru as $item)
                @php
                    $fotoItem = null;
                    if ($item->galeri->isNotEmpty()) {
                        $fObj = $item->galeri->where('foto_utama', 1)->first() ?? $item->galeri->first();
                        $fotoItem = $fObj ? $fObj->url : null;
                    }
                    $ratingVal = $item->ulasan_avg_rating ? round($item->ulasan_avg_rating, 1) : 4.9;
                @endphp
                <div class="col-6 col-md-4 col-lg-3 product-grid-item" data-category="{{ $item->kategori_id }}" style="transition: all 0.25s ease;">
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
                                {{ $item->merek->nama_merek ?? 'A1ORA WATCH' }}
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
                        <!-- Pesan jika tidak ada produk yang cocok dengan kategori filter -->
            <div class="col-12 d-none" id="noFilterResults">
                <div class="alert alert-light border rounded-4 text-center py-5 text-muted">
                    <i class="bi bi-watch fs-1 d-block mb-2 text-secondary"></i>
                    <h6 class="fw-bold text-dark">Belum Ada Jam Tangan di Kategori Ini</h6>
                    <p class="small text-muted mb-0">Silakan pilih kategori lainnya atau lihat seluruh koleksi kami.</p>
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
                    <h5 class="fw-bold text-white mb-1">A1ORA ATELIER</h5>
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
                        "Lume BGW9-nya terang banget waktu gelap. Kartu garansi NFC terverifikasi langsung di website resmi. Sangat puas belanja di A1ORA!"
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterTabs = document.querySelectorAll('.filter-tab-btn');
    const productItems = document.querySelectorAll('.product-grid-item');
    const emptyState = document.getElementById('noFilterResults');

    filterTabs.forEach(btn => {
        btn.addEventListener('click', function () {
            // Update active state styling
            filterTabs.forEach(b => {
                b.classList.remove('btn-dark', 'text-white', 'active');
                b.classList.add('btn-light', 'text-secondary');
            });
            this.classList.remove('btn-light', 'text-secondary');
            this.classList.add('btn-dark', 'text-white', 'active');

            const filterValue = this.getAttribute('data-filter');
            let visibleCount = 0;

            productItems.forEach(item => {
                const itemCategory = item.getAttribute('data-category');
                if (filterValue === 'all' || itemCategory === filterValue) {
                    item.style.display = '';
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.96)';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'scale(1)';
                    }, 40);
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            if (emptyState) {
                if (visibleCount === 0) {
                    emptyState.classList.remove('d-none');
                } else {
                    emptyState.classList.add('d-none');
                }
            }
        });
    });
});
</script>
@endpush