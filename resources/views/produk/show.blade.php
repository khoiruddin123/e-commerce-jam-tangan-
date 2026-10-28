@extends('layouts.app')

@section('title', $produk->nama_produk . ' - Kronos Watch')

@section('content')
<div class="container py-3">

    <!-- Breadcrumb Navigasi & SKU Asli Database -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-0">
                <li class="breadcrumb-item"><a href="{{ route('produk.index') }}" class="text-decoration-none text-muted"><i class="bi bi-house-door me-1"></i>Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('produk.katalog') }}" class="text-decoration-none text-muted">Katalog Jam Tangan</a></li>
                @if($produk->kategori)
                    <li class="breadcrumb-item">
                        <a href="{{ route('produk.katalog', ['kategori_id' => $produk->kategori_id]) }}" class="text-decoration-none text-muted">
                            {{ $produk->kategori->nama_kategori }}
                        </a>
                    </li>
                @endif
                <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">{{ $produk->nama_produk }}</li>
            </ol>
        </nav>
        <div class="small text-muted">
            <span class="badge bg-light text-dark border px-2.5 py-1" id="topSkuBadge">
                SKU: {{ $produk->varian->first()->kode_sku ?? ($produk->kode_produk ?? '-') }}
            </span>
        </div>
    </div>

    <!-- MAIN PRODUCT SECTION: 2 KOLOM -->
    <div class="row g-4 mb-5">
        
        <!-- KOLOM KIRI: Galeri Foto Produk & Jaminan Keaslian -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-xs rounded-4 bg-white p-3 mb-3 position-relative overflow-hidden">
                @php
                    $fotoUtama = $produk->galeri->where('foto_utama', 1)->first() ?? $produk->galeri->first();
                    $totalStok = $produk->varian->sum('stok');
                @endphp

                <!-- Status Ketersediaan Stok Fisik -->
                <div class="position-absolute top-0 start-0 m-3" style="z-index: 3;">
                    @if($totalStok > 0)
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 small fw-semibold">
                            &bull; Stok Tersedia
                        </span>
                    @else
                        <span class="badge bg-danger rounded-pill px-2.5 py-1 small fw-bold">
                            Stok Habis
                        </span>
                    @endif
                </div>

                <!-- Display Foto Produk Asli (Tanpa Unsplash) -->
                <div class="position-relative d-flex align-items-center justify-content-center bg-light rounded-4 overflow-hidden mb-3" style="height: 400px;">
                    @if($fotoUtama && $fotoUtama->foto)
                        <img id="mainProductImage" 
                             src="{{ asset('storage/' . $fotoUtama->foto) }}" 
                             alt="{{ $produk->nama_produk }}" 
                             class="w-100 h-100 object-fit-contain p-3 transition-transform">
                    @else
                        <div class="text-muted text-center p-4">
                            <i class="bi bi-watch display-1 d-block mb-2 text-secondary opacity-50"></i>
                            <span class="small fw-semibold text-secondary">Foto Produk Belum Diunggah</span>
                        </div>
                    @endif
                </div>

                <!-- Thumbnail Galeri Jika Ada Foto Tambahan -->
                @if($produk->galeri->count() > 1)
                    <div class="d-flex gap-2 overflow-x-auto pb-1" id="galleryThumbnails">
                        @foreach($produk->galeri as $index => $foto)
                            <button type="button" 
                                    class="btn p-0 border rounded-3 overflow-hidden thumbnail-btn {{ $loop->first ? 'border-primary border-2' : 'border-light-subtle' }}" 
                                    style="width: 70px; height: 70px; flex-shrink: 0;"
                                    onclick="changeMainImage('{{ asset('storage/' . $foto->foto) }}', this)">
                                <img src="{{ asset('storage/' . $foto->foto) }}" 
                                     alt="Galeri {{ $index + 1 }}" 
                                     class="w-100 h-100 object-fit-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Jaminan Keaslian Resmi -->
            <div class="row g-2">
                <div class="col-6">
                    <div class="card border-0 bg-white shadow-xs rounded-3 p-2.5 h-100 d-flex flex-row align-items-center gap-2">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="bi bi-patch-check-fill fs-6"></i>
                        </div>
                        <div>
                            <span class="d-block fw-bold text-dark small" style="font-size: 0.75rem;">Produk Original</span>
                            <span class="text-muted small" style="font-size: 0.68rem;">Garansi resmi terjamin</span>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card border-0 bg-white shadow-xs rounded-3 p-2.5 h-100 d-flex flex-row align-items-center gap-2">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="bi bi-shield-check fs-6"></i>
                        </div>
                        <div>
                            <span class="d-block fw-bold text-dark small" style="font-size: 0.75rem;">Pengiriman Aman</span>
                            <span class="text-muted small" style="font-size: 0.68rem;">Kemasan rapi & berasuransi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: Informasi, Pemilih Varian Asli, & Form Pembelian -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-xs rounded-4 bg-white p-4">

                <!-- Header Merek & Kategori Asli -->
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="text-primary fw-bold text-uppercase small" style="font-size: 0.78rem; letter-spacing: 1px;">
                        {{ $produk->merek->nama_merek ?? 'Kronos' }}
                    </span>
                    <span class="text-muted small">&bull;</span>
                    <span class="badge bg-light text-secondary border small">
                        {{ $produk->kategori->nama_kategori ?? 'Umum' }}
                    </span>
                </div>

                <!-- Judul Produk Asli Database -->
                <h2 class="fw-bold text-dark mb-2" style="letter-spacing: -0.5px;">{{ $produk->nama_produk }}</h2>

                <!-- Rating Bintang Asli (Hanya muncul jika ada ulasan) -->
                <div class="d-flex align-items-center gap-2 mb-3">
                    @if($totalUlasan > 0)
                        <div class="text-warning small">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= round($rataRataRating) ? '-fill' : '' }}"></i>
                            @endfor
                        </div>
                        <span class="fw-bold text-dark small">{{ $rataRataRating }}</span>
                        <span class="text-muted small">({{ $totalUlasan }} ulasan)</span>
                    @else
                        <span class="text-muted small">
                            <i class="bi bi-star text-muted me-1"></i>Belum ada ulasan pembeli
                        </span>
                    @endif
                </div>

                <!-- Kotak Harga Murni (Tanpa Coretan Dummy) -->
                @php
                    $hargaAwal = $produk->varian->first()->harga_varian ?? 0;
                @endphp
                <div class="p-3 rounded-4 bg-light bg-opacity-75 border mb-3">
                    <div class="text-muted small mb-1">Harga:</div>
                    <h2 class="fw-bold text-dark mb-0" id="displayHarga">
                        Rp {{ number_format($hargaAwal, 0, ',', '.') }}
                    </h2>
                </div>

                <!-- Ringkasan Deskripsi Asli Database -->
                @if($produk->deskripsi)
                    <p class="text-secondary small mb-4" style="line-height: 1.6;">
                        {{ Str::limit($produk->deskripsi, 200, '...') }}
                    </p>
                @endif

                <!-- FORM PEMBELIAN & VARIANT SELECTOR ASLI DATABASE -->
                @if($produk->varian->isNotEmpty())
                    <form action="{{ route('keranjang.tambah') }}" method="POST" id="formAddToCart">
                        @csrf
                        
                        <!-- Pilihan Varian Asli dari tabel varian_produk -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-bold small text-dark mb-0">
                                    Pilih Varian:
                                </label>
                                <span id="selectedVariantLabel" class="text-primary fw-semibold small">
                                    {{ $produk->varian->first()->nama_varian }}
                                </span>
                            </div>

                            <div class="row g-2" id="variantOptions">
                                @foreach($produk->varian as $varian)
                                    <div class="col-6">
                                        <input type="radio" 
                                               class="btn-check variant-radio" 
                                               name="varian_id" 
                                               id="varian_{{ $varian->varian_id }}" 
                                               value="{{ $varian->varian_id }}"
                                               data-nama="{{ $varian->nama_varian }}"
                                               data-sku="{{ $varian->kode_sku }}"
                                               data-harga="{{ $varian->harga_varian }}"
                                               data-stok="{{ $varian->stok }}"
                                               data-warna="{{ $varian->warna }}"
                                               data-tali="{{ $varian->bahan_tali }}"
                                               {{ $loop->first ? 'checked' : '' }}
                                               autocomplete="off">
                                        <label class="btn btn-outline-secondary w-100 text-start p-2.5 rounded-3 variant-card-label position-relative" 
                                               for="varian_{{ $varian->varian_id }}">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <span class="fw-semibold small text-dark d-block text-truncate" style="max-width: 140px;">
                                                    {{ $varian->nama_varian }}
                                                </span>
                                            </div>
                                            <span class="fw-bold small text-primary d-block">
                                                Rp {{ number_format($varian->harga_varian, 0, ',', '.') }}
                                            </span>
                                            @if($varian->warna || $varian->bahan_tali)
                                                <span class="text-muted d-block" style="font-size: 0.7rem;">
                                                    {{ $varian->warna ?? '' }} {{ $varian->bahan_tali ? '• ' . $varian->bahan_tali : '' }}
                                                </span>
                                            @endif
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Bar Status Stok Asli Database -->
                        <div class="p-2.5 rounded-3 bg-light border mb-4 d-flex align-items-center gap-2" id="stockStatusContainer">
                            <i class="bi bi-box-seam text-primary"></i>
                            <div class="small text-dark">
                                Ketersediaan Stok: <strong id="stockText" class="text-success">{{ $produk->varian->first()->stok }} unit</strong>
                            </div>
                        </div>

                        <!-- Quantity & Tombol Tambah ke Keranjang Asli -->
                        <div class="row g-2 align-items-center mb-3">
                            <div class="col-4 col-sm-3">
                                <label class="form-label small text-muted mb-1 d-block" style="font-size: 0.72rem;">Jumlah</label>
                                <div class="input-group">
                                    <button class="btn btn-outline-secondary px-2" type="button" onclick="adjustQty(-1)">-</button>
                                    <input type="number" id="inputQty" name="jumlah" class="form-control text-center fw-bold px-1" value="1" min="1" max="{{ $produk->varian->first()->stok ?? 1 }}">
                                    <button class="btn btn-outline-secondary px-2" type="button" onclick="adjustQty(1)">+</button>
                                </div>
                            </div>
                            <div class="col-8 col-sm-9 d-flex flex-column justify-content-end">
                                <label class="form-label small text-muted mb-1 d-none d-sm-block" style="font-size: 0.72rem;">&nbsp;</label>
                                <button type="submit" class="btn btn-luxury-primary w-100 py-2.5 rounded-3 fw-semibold shadow-xs" id="btnAddToCart">
                                    <i class="bi bi-bag-plus me-1"></i> Tambah ke Keranjang &bull; <span id="btnPriceLabel">Rp {{ number_format($hargaAwal, 0, ',', '.') }}</span>
                                </button>
                            </div>
                        </div>

                        <!-- Tombol Konsultasi WhatsApp (Tetap Ada) -->
                        <div>
                            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Kronos%20Watch,%20saya%20tertarik%20dengan%20jam%20tangan%20{{ urlencode($produk->nama_produk) }}" 
                               target="_blank" 
                               class="btn btn-outline-success w-100 py-2 rounded-3 small fw-semibold d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-whatsapp fs-5"></i> Konsultasi Produk via WhatsApp
                            </a>
                        </div>

                    </form>
                @else
                    <div class="alert alert-warning border-0 rounded-3 mb-0">
                        <i class="bi bi-exclamation-triangle me-1"></i> Jam tangan ini belum memiliki varian aktif yang dapat dibeli saat ini.
                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- TABS SECTION: Deskripsi, Spesifikasi, & Ulasan Murni Database -->
    <div class="card border-0 shadow-xs rounded-4 bg-white p-4 mb-5">
        <ul class="nav nav-pills justify-content-center mb-4 border-bottom pb-3 gap-2" id="productDetailTab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active rounded-pill px-4 fw-semibold small" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc-pane" type="button" role="tab">
                    Deskripsi Produk
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link rounded-pill px-4 fw-semibold small" id="spec-tab" data-bs-toggle="tab" data-bs-target="#spec-pane" type="button" role="tab">
                    Spesifikasi Teknis
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link rounded-pill px-4 fw-semibold small" id="review-tab" data-bs-toggle="tab" data-bs-target="#review-pane" type="button" role="tab">
                    Ulasan ({{ $totalUlasan }})
                </button>
            </li>
        </ul>

        <div class="tab-content" id="productDetailTabContent">
            
            <!-- Tab 1: Deskripsi Asli -->
            <div class="tab-pane fade show active" id="desc-pane" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <h6 class="fw-bold text-dark mb-3">Deskripsi Produk</h6>
                        <p class="text-secondary lh-lg mb-4" style="white-space: pre-line;">
                            {{ $produk->deskripsi ?? 'Belum ada rincian deskripsi untuk jam tangan ini.' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Spesifikasi Asli Database -->
            <div class="tab-pane fade" id="spec-pane" role="tabpanel">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="table-responsive">
                            <table class="table table-borderless table-striped small">
                                <tbody>
                                    <tr>
                                        <td class="text-muted fw-semibold" style="width: 35%;">Merek</td>
                                        <td class="fw-bold text-dark">{{ $produk->merek->nama_merek ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-semibold">Kategori</td>
                                        <td class="fw-bold text-dark">{{ $produk->kategori->nama_kategori ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-semibold">Spesifikasi Detail</td>
                                        <td class="text-dark" style="white-space: pre-line;">{{ $produk->spesifikasi ?? 'Informasi spesifikasi belum dicantumkan.' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 3: Ulasan Murni Database (Tanpa Sampel Palsu) -->
            <div class="tab-pane fade" id="review-pane" role="tabpanel">
                @if($daftarUlasan->isEmpty())
                    <!-- Tampilan Murni Jika Belum Ada Ulasan Asli -->
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-chat-square-dots display-4 d-block mb-3 opacity-50"></i>
                        <h6 class="fw-bold text-dark">Belum Ada Ulasan</h6>
                        <p class="small text-muted mb-0" style="max-width: 400px; margin: 0 auto;">
                            Belum ada pembeli yang memberikan ulasan untuk jam tangan ini.
                        </p>
                    </div>
                @else
                    <!-- Daftar Ulasan Asli dari Tabel ulasan di MariaDB -->
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 mb-4">
                                <h2 class="fw-bold text-dark mb-0">{{ $rataRataRating }}</h2>
                                <div>
                                    <div class="text-warning small mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= round($rataRataRating) ? '-fill' : '' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="text-muted small">Rata-rata dari {{ $totalUlasan }} ulasan pembeli</span>
                                </div>
                            </div>

                            <div class="d-flex flex-column gap-3">
                                @foreach($daftarUlasan as $ulasan)
                                    <div class="p-3 border rounded-3 bg-white shadow-xs">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                                    {{ strtoupper(substr($ulasan->user->nama ?? 'P', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <span class="fw-bold text-dark small d-block">{{ $ulasan->user->nama ?? 'Pelanggan' }}</span>
                                                    <span class="text-muted" style="font-size: 0.7rem;">
                                                        {{ $ulasan->tanggal_ulasan ? \Carbon\Carbon::parse($ulasan->tanggal_ulasan)->translatedFormat('d F Y') : '-' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="text-warning small">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="bi bi-star{{ $i <= $ulasan->rating ? '-fill' : '' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="text-secondary small mb-0 mt-2" style="line-height: 1.5;">
                                            "{{ $ulasan->komentar }}"
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <!-- REKOMENDASI PRODUK TERKAIT ASLI DARI DATABASE -->
    @if(isset($produkTerkait) && $produkTerkait->isNotEmpty())
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h5 class="fw-bold text-dark mb-0">Koleksi Jam Tangan Lainnya</h5>
                    <span class="text-muted small">Produk terkait dari katalog kami</span>
                </div>
                <a href="{{ route('produk.katalog') }}" class="text-primary fw-semibold small text-decoration-none">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
                @foreach($produkTerkait as $relItem)
                    @php
                        $relFoto = $relItem->galeri->where('foto_utama', 1)->first() ?? $relItem->galeri->first();
                    @endphp
                    <div class="col">
                        <div class="card h-100 product-card rounded-4 bg-white overflow-hidden shadow-xs position-relative">
                            
                            <!-- Badges Kategori Asli -->
                            <div class="position-absolute top-0 start-0 m-2" style="z-index: 2;">
                                <span class="badge bg-light text-dark border rounded-pill px-2 py-1 small" style="font-size: 0.68rem;">
                                    {{ $relItem->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                            </div>

                            <!-- Gambar Asli Storage / Placeholder Bersih -->
                            <a href="{{ route('produk.detail', $relItem->produk_id) }}" class="d-block bg-light overflow-hidden text-center text-decoration-none" style="height: 180px;">
                                @if($relFoto && $relFoto->foto)
                                    <img src="{{ asset('storage/' . $relFoto->foto) }}" alt="{{ $relItem->nama_produk }}" class="w-100 h-100 object-fit-contain p-2">
                                @else
                                    <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-muted">
                                        <i class="bi bi-watch display-6 opacity-50 mb-1"></i>
                                        <span style="font-size: 0.68rem;">Foto belum ada</span>
                                    </div>
                                @endif
                            </a>

                            <!-- Detail Asli -->
                            <div class="card-body p-3 d-flex flex-column text-center">
                                <span class="text-uppercase text-muted fw-bold small mb-1" style="font-size: 0.65rem;">
                                    {{ $relItem->merek->nama_merek ?? 'Kronos' }}
                                </span>
                                <h6 class="card-title fw-bold text-dark text-truncate mb-2" title="{{ $relItem->nama_produk }}" style="font-size: 0.85rem;">
                                    <a href="{{ route('produk.detail', $relItem->produk_id) }}" class="text-decoration-none text-dark">
                                        {{ $relItem->nama_produk }}
                                    </a>
                                </h6>
                                <div class="mt-auto d-flex align-items-center justify-content-between pt-2 border-top">
                                    <span class="fw-bold text-dark small">
                                        Rp {{ number_format($relItem->harga_terendah ?? 0, 0, ',', '.') }}
                                    </span>
                                    <a href="{{ route('produk.detail', $relItem->produk_id) }}" class="btn btn-luxury-primary rounded-circle p-0 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                        <i class="bi bi-bag" style="font-size: 0.75rem;"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>

<!-- SCRIPT INTERAKTIF ASLI: GANTI FOTO & VARIANT SELECTOR -->
<script>
    function formatRupiah(number) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
    }

    function changeMainImage(imageSrc, element) {
        const mainImg = document.getElementById('mainProductImage');
        if (mainImg) {
            mainImg.src = imageSrc;
        }
        document.querySelectorAll('.thumbnail-btn').forEach(btn => {
            btn.classList.remove('border-primary', 'border-2');
            btn.classList.add('border-light-subtle');
        });
        element.classList.remove('border-light-subtle');
        element.classList.add('border-primary', 'border-2');
    }

    function updateVariantDetails(radio) {
        const harga = parseFloat(radio.dataset.harga) || 0;
        const stok = parseInt(radio.dataset.stok) || 0;
        const sku = radio.dataset.sku || '';
        const nama = radio.dataset.nama || '';

        // 1. Label varian terpilih
        const selectedLabel = document.getElementById('selectedVariantLabel');
        if (selectedLabel) selectedLabel.textContent = nama;

        // 2. Update harga dinamis
        const displayHarga = document.getElementById('displayHarga');
        const btnPriceLabel = document.getElementById('btnPriceLabel');

        if (displayHarga) displayHarga.textContent = formatRupiah(harga);
        if (btnPriceLabel) btnPriceLabel.textContent = formatRupiah(harga);

        // 3. Update SKU
        const topSkuBadge = document.getElementById('topSkuBadge');
        if (topSkuBadge && sku) topSkuBadge.textContent = 'SKU: ' + sku;

        // 4. Update status stok real-time & tombol Add to Cart
        const stockText = document.getElementById('stockText');
        const btnAddToCart = document.getElementById('btnAddToCart');
        const inputQty = document.getElementById('inputQty');

        if (stok > 0) {
            if (stockText) {
                stockText.textContent = stok + ' unit';
                stockText.className = 'text-success fw-bold';
            }
            if (btnAddToCart) {
                btnAddToCart.disabled = false;
                btnAddToCart.innerHTML = '<i class="bi bi-bag-plus me-1"></i> Tambah ke Keranjang &bull; ' + formatRupiah(harga);
                btnAddToCart.className = 'btn btn-luxury-primary w-100 py-2.5 rounded-3 fw-semibold shadow-xs';
            }
            if (inputQty) {
                inputQty.max = stok;
                if (parseInt(inputQty.value) > stok) inputQty.value = stok;
                if (parseInt(inputQty.value) < 1) inputQty.value = 1;
            }
        } else {
            if (stockText) {
                stockText.textContent = 'Stok Habis';
                stockText.className = 'text-danger fw-bold';
            }
            if (btnAddToCart) {
                btnAddToCart.disabled = true;
                btnAddToCart.innerHTML = '<i class="bi bi-slash-circle me-1"></i> Stok Varian Tidak Tersedia';
                btnAddToCart.className = 'btn btn-secondary w-100 py-2.5 rounded-3 fw-semibold';
            }
            if (inputQty) {
                inputQty.value = 0;
                inputQty.max = 0;
            }
        }

        // 5. Update active style pada card varian
        document.querySelectorAll('.variant-card-label').forEach(lbl => {
            lbl.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10');
            lbl.classList.add('border-secondary');
        });
        const currentCard = document.querySelector('label[for="' + radio.id + '"]');
        if (currentCard) {
            currentCard.classList.remove('border-secondary');
            currentCard.classList.add('border-primary', 'bg-primary', 'bg-opacity-10');
        }
    }

    function adjustQty(change) {
        const inputQty = document.getElementById('inputQty');
        if (!inputQty) return;

        let currentVal = parseInt(inputQty.value) || 1;
        const max = parseInt(inputQty.max) || 1;
        const min = parseInt(inputQty.min) || 1;

        if (max === 0) return;

        let newVal = currentVal + change;
        if (newVal >= min && newVal <= max) {
            inputQty.value = newVal;
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const variantRadios = document.querySelectorAll('.variant-radio');
        variantRadios.forEach(radio => {
            radio.addEventListener('change', function () {
                updateVariantDetails(this);
            });
        });

        const checkedVariant = document.querySelector('.variant-radio:checked');
        if (checkedVariant) {
            updateVariantDetails(checkedVariant);
        }
    });
</script>
@endsection
