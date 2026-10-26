@extends('layouts.app')

@section('title', $produk->nama_produk . ' - Kronos Watch')

@section('content')
<div class="container py-2">
    <!-- Breadcrumb Navigasi -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('produk.index') }}" class="text-decoration-none text-muted">Katalog</a></li>
            @if($produk->kategori)
                <li class="breadcrumb-item">
                    <a href="{{ route('produk.index', ['kategori_id' => $produk->kategori_id]) }}" class="text-decoration-none text-muted">
                        {{ $produk->kategori->nama_kategori }}
                    </a>
                </li>
            @endif
            <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">{{ $produk->nama_produk }}</li>
        </ol>
    </nav>

    <div class="row g-4 mb-5">
        <!-- Kolom Galeri Foto Produk -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white p-3">
                @php
                    $fotoUtama = $produk->galeri->where('foto_utama', 1)->first() ?? $produk->galeri->first();
                @endphp

                <!-- Foto Utama Display -->
                <div class="position-relative d-flex align-items-center justify-content-center bg-light rounded-3 overflow-hidden mb-3" style="height: 420px;">
                    @if($fotoUtama && $fotoUtama->foto)
                        <img id="mainProductImage" 
                             src="{{ asset('storage/' . $fotoUtama->foto) }}" 
                             alt="{{ $produk->nama_produk }}" 
                             class="w-100 h-100 object-fit-contain p-2 transition-all">
                    @else
                        <div class="text-muted text-center p-4">
                            <i class="bi bi-watch display-1 d-block mb-2 text-secondary"></i>
                            <span class="small">Foto produk belum tersedia</span>
                        </div>
                    @endif
                </div>

                <!-- Thumbnail Foto Galeri -->
                @if($produk->galeri->count() > 1)
                    <div class="d-flex gap-2 overflow-x-auto pb-2" id="galleryThumbnails">
                        @foreach($produk->galeri as $index => $foto)
                            <button type="button" 
                                    class="btn p-0 border rounded-3 overflow-hidden thumbnail-btn {{ $loop->first ? 'border-dark border-2' : 'border-light-subtle' }}" 
                                    style="width: 72px; height: 72px; flex-shrink: 0;"
                                    onclick="changeMainImage('{{ asset('storage/' . $foto->foto) }}', this)">
                                <img src="{{ asset('storage/' . $foto->foto) }}" 
                                     alt="Foto {{ $index + 1 }}" 
                                     class="w-100 h-100 object-fit-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Kolom Informasi & Pilihan Varian Produk -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                <!-- Merek & Kategori -->
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-dark px-2.5 py-1.5 fw-medium">{{ $produk->merek->nama_merek ?? 'Original Brand' }}</span>
                    <span class="badge bg-light text-secondary border px-2.5 py-1.5">{{ $produk->kategori->nama_kategori ?? 'Umum' }}</span>
                    @if($produk->kode_produk)
                        <span class="text-muted small ms-auto">Kode: {{ $produk->kode_produk }}</span>
                    @endif
                </div>

                <!-- Nama Produk -->
                <h3 class="fw-bold text-dark mb-2">{{ $produk->nama_produk }}</h3>

                <!-- Rating & Ulasan Singkat -->
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="d-flex text-warning">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($rataRataRating))
                                <i class="bi bi-star-fill"></i>
                            @elseif($i - $rataRataRating < 1 && $i - $rataRataRating > 0)
                                <i class="bi bi-star-half"></i>
                            @else
                                <i class="bi bi-star text-muted opacity-50"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="fw-bold text-dark small">{{ $rataRataRating > 0 ? $rataRataRating : '0.0' }}</span>
                    <span class="text-muted small">({{ $totalUlasan }} ulasan pembeli)</span>
                </div>

                <hr class="my-3 opacity-25">

                <!-- Tampilan Harga Dinamis -->
                <div class="mb-3">
                    <div class="text-muted small mb-1" id="labelHarga">Harga:</div>
                    <h3 class="fw-bold text-danger mb-0" id="displayHarga">
                        @if($produk->varian->isNotEmpty())
                            Rp {{ number_format($produk->varian->min('harga_varian'), 0, ',', '.') }}
                        @else
                            <span class="text-muted fs-5">Harga Belum Ditentukan</span>
                        @endif
                    </h3>
                </div>

                <!-- Pilihan Varian Produk & Formulir Keranjang (F8-01) -->
                @if($produk->varian->isNotEmpty())
                    <form action="{{ route('keranjang.tambah') }}" method="POST">
                        @csrf
                        
                        <!-- Pilihan Varian -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-dark d-flex justify-content-between align-items-center">
                                <span>Pilih Varian:</span>
                                <span id="displaySku" class="text-muted fw-normal" style="font-size: 0.8rem;"></span>
                            </label>
                            <div class="d-flex flex-wrap gap-2" id="variantOptions">
                                @foreach($produk->varian as $varian)
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
                                    <label class="btn btn-outline-dark btn-sm rounded-3 py-2 px-3 text-start position-relative" 
                                           for="varian_{{ $varian->varian_id }}">
                                        <span class="fw-semibold d-block">{{ $varian->nama_varian }}</span>
                                        <span class="small text-muted d-block" style="font-size: 0.75rem;">
                                            {{ $varian->warna ?? '-' }} | {{ $varian->bahan_tali ?? '-' }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Indikator Stok Berdasarkan Varian Terpilih (F7 - 04 & F8 - 04) -->
                        <div class="mb-4 p-3 bg-light rounded-3 d-flex align-items-center justify-content-between" id="stockStatusContainer">
                            <div class="d-flex align-items-center gap-2">
                                <i id="stockIcon" class="bi bi-check-circle-fill text-success fs-5"></i>
                                <div>
                                    <span class="d-block small text-muted">Ketersediaan Stok:</span>
                                    <strong id="stockText" class="text-dark">Pilih varian...</strong>
                                </div>
                            </div>
                            <span id="stockBadge" class="badge bg-success-subtle text-success border border-success-subtle">
                                Tersedia
                            </span>
                        </div>

                        <!-- Jumlah Pembelian & Tombol Aksi -->
                        <div class="row g-2 align-items-center mb-3">
                            <div class="col-4 col-sm-3">
                                <label class="form-label small text-muted mb-1">Jumlah</label>
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary" type="button" onclick="adjustQty(-1)">-</button>
                                    <input type="number" id="inputQty" name="jumlah" class="form-control text-center fw-semibold" value="1" min="1" max="1">
                                    <button class="btn btn-outline-secondary" type="button" onclick="adjustQty(1)">+</button>
                                </div>
                            </div>
                            <div class="col-8 col-sm-9 d-flex gap-2 pt-4">
                                <button type="submit" class="btn btn-dark w-100 py-2 fw-semibold" id="btnAddToCart">
                                    <i class="bi bi-cart-plus me-1"></i> Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <!-- Jika seluruh produk belum memiliki varian aktif -->
                    <div class="alert alert-warning border-0 rounded-3 mb-4">
                        <i class="bi bi-exclamation-triangle me-1"></i> Produk ini belum memiliki varian aktif yang dapat dibeli saat ini.
                    </div>
                @endif

                <div class="text-muted small mt-2">
                    <i class="bi bi-shield-check text-success me-1"></i> 100% Produk Original & Bergaransi Resmi.
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Deskripsi, Spesifikasi, dan Ulasan Produk -->
    <div class="card border-0 shadow-sm rounded-4 bg-white p-4 mb-4">
        <ul class="nav nav-pills mb-4 border-bottom pb-3 gap-2" id="productTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-3 px-4 fw-semibold" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc-pane" type="button" role="tab">
                    <i class="bi bi-card-text me-1"></i> Deskripsi & Spesifikasi
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-3 px-4 fw-semibold" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-pane" type="button" role="tab">
                    <i class="bi bi-chat-left-heart me-1"></i> Ulasan Pembeli ({{ $totalUlasan }})
                </button>
            </li>
        </ul>

        <div class="tab-content" id="productTabContent">
            <!-- Tab Konten: Deskripsi & Spesifikasi -->
            <div class="tab-pane fade show active" id="desc-pane" role="tabpanel">
                <div class="row g-4">
                    <div class="col-md-7">
                        <h6 class="fw-bold text-dark mb-2">Deskripsi Produk</h6>
                        <p class="text-secondary lh-base mb-4" style="white-space: pre-line;">
                            {{ $produk->deskripsi ?? 'Belum ada deskripsi untuk jam tangan ini.' }}
                        </p>
                    </div>
                    <div class="col-md-5">
                        <div class="p-3 bg-light rounded-3">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-gear-wide-connected me-1"></i> Spesifikasi Teknis</h6>
                            @if($produk->spesifikasi)
                                <p class="text-secondary small mb-0" style="white-space: pre-line;">
                                    {{ $produk->spesifikasi }}
                                </p>
                            @else
                                <span class="text-muted small">Informasi spesifikasi belum dicantumkan.</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Konten: Ulasan & Rating (F7 - 03) -->
            <div class="tab-pane fade" id="reviews-pane" role="tabpanel">
                <!-- Ringkasan Ulasan -->
                <div class="row align-items-center p-3 bg-light rounded-3 mb-4">
                    <div class="col-sm-4 text-center border-end">
                        <h1 class="fw-bold text-dark mb-0">{{ $rataRataRating > 0 ? $rataRataRating : '0.0' }}</h1>
                        <div class="text-warning mb-1">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= round($rataRataRating) ? '-fill' : '' }}"></i>
                            @endfor
                        </div>
                        <span class="text-muted small">Rata-rata dari {{ $totalUlasan }} ulasan</span>
                    </div>
                    <div class="col-sm-8 ps-sm-4 mt-3 mt-sm-0">
                        <p class="text-muted small mb-0">
                            Semua ulasan berasal dari pembeli terverifikasi yang telah menyelesaikan pesanan jam tangan ini di <strong>Kronos Watch</strong>.
                        </p>
                    </div>
                </div>

                <!-- Daftar Komentar Ulasan -->
                @if($daftarUlasan->isEmpty())
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-chat-square-dots display-6 d-block mb-2 opacity-50"></i>
                        <p class="mb-0">Belum ada ulasan untuk produk ini.</p>
                        <small>Jadilah yang pertama memberikan ulasan setelah melakukan pembelian!</small>
                    </div>
                @else
                    <div class="d-flex flex-column gap-3">
                        @foreach($daftarUlasan as $ulasan)
                            <div class="p-3 border rounded-3 bg-white">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center fw-bold" style="width: 34px; height: 34px; font-size: 0.85rem;">
                                            {{ strtoupper(substr($ulasan->user->nama ?? 'P', 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong class="d-block small text-dark">{{ $ulasan->user->nama ?? 'Pelanggan Kronos' }}</strong>
                                            <span class="text-muted" style="font-size: 0.75rem;">
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
                                <p class="text-secondary small mb-0">
                                    {{ $ulasan->komentar ?? 'Tidak ada komentar tertulis.' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Script Interaktif Varian, Stok, Harga, dan Galeri Foto -->
<script>
    // Format angka ke format Rupiah
    function formatRupiah(number) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
    }

    // Fungsi ganti foto utama saat thumbnail galeri diklik
    function changeMainImage(imageSrc, element) {
        const mainImg = document.getElementById('mainProductImage');
        if (mainImg) {
            mainImg.src = imageSrc;
        }

        // Update active border style pada thumbnail
        document.querySelectorAll('.thumbnail-btn').forEach(btn => {
            btn.classList.remove('border-dark', 'border-2');
            btn.classList.add('border-light-subtle');
        });
        element.classList.remove('border-light-subtle');
        element.classList.add('border-dark', 'border-2');
    }

    // Fungsi untuk memperbarui tampilan harga & status stok saat varian dipilih
    function updateVariantDetails(radio) {
        const harga = parseFloat(radio.dataset.harga) || 0;
        const stok = parseInt(radio.dataset.stok) || 0;
        const sku = radio.dataset.sku || '';

        // 1. Update Tampilan Harga
        const displayHarga = document.getElementById('displayHarga');
        if (displayHarga) {
            displayHarga.textContent = formatRupiah(harga);
        }

        // 2. Update SKU
        const displaySku = document.getElementById('displaySku');
        if (displaySku && sku) {
            displaySku.textContent = 'SKU: ' + sku;
        }

        // 3. Update Status Ketersediaan Stok (F7 - 04)
        const stockText = document.getElementById('stockText');
        const stockBadge = document.getElementById('stockBadge');
        const stockIcon = document.getElementById('stockIcon');
        const btnAddToCart = document.getElementById('btnAddToCart');
        const inputQty = document.getElementById('inputQty');

        if (stok > 0) {
            stockText.textContent = 'Tersedia ' + stok + ' unit';
            stockText.className = 'text-dark';
            stockBadge.textContent = 'Tersedia';
            stockBadge.className = 'badge bg-success-subtle text-success border border-success-subtle';
            stockIcon.className = 'bi bi-check-circle-fill text-success fs-5';

            if (btnAddToCart) {
                btnAddToCart.disabled = false;
                btnAddToCart.innerHTML = '<i class="bi bi-cart-plus me-1"></i> Tambah ke Keranjang';
                btnAddToCart.className = 'btn btn-dark w-100 py-2 fw-semibold';
            }

            if (inputQty) {
                inputQty.max = stok;
                if (parseInt(inputQty.value) > stok) {
                    inputQty.value = stok;
                }
                if (parseInt(inputQty.value) < 1) {
                    inputQty.value = 1;
                }
            }
        } else {
            // Informasi ketika stok varian tidak tersedia (F7 - 04)
            stockText.textContent = 'Stok Habis';
            stockText.className = 'text-danger fw-bold';
            stockBadge.textContent = 'Habis';
            stockBadge.className = 'badge bg-danger-subtle text-danger border border-danger-subtle';
            stockIcon.className = 'bi bi-x-circle-fill text-danger fs-5';

            if (btnAddToCart) {
                btnAddToCart.disabled = true;
                btnAddToCart.innerHTML = '<i class="bi bi-slash-circle me-1"></i> Stok Varian Tidak Tersedia';
                btnAddToCart.className = 'btn btn-secondary w-100 py-2 fw-semibold';
            }

            if (inputQty) {
                inputQty.value = 0;
                inputQty.max = 0;
            }
        }
    }

    // Fungsi atur jumlah (Quantity)
    function adjustQty(change) {
        const inputQty = document.getElementById('inputQty');
        if (!inputQty) return;

        let currentVal = parseInt(inputQty.value) || 1;
        const max = parseInt(inputQty.max) || 1;
        const min = parseInt(inputQty.min) || 1;

        if (max === 0) return; // Jika stok habis

        let newVal = currentVal + change;
        if (newVal >= min && newVal <= max) {
            inputQty.value = newVal;
        }
    }

    // Pasang event listener saat DOM selesai dimuat
    document.addEventListener('DOMContentLoaded', function () {
        const variantRadios = document.querySelectorAll('.variant-radio');
        variantRadios.forEach(radio => {
            radio.addEventListener('change', function () {
                updateVariantDetails(this);
            });
        });

        // Trigger inisialisasi pada varian yang sedang aktif/checked
        const checkedVariant = document.querySelector('.variant-radio:checked');
        if (checkedVariant) {
            updateVariantDetails(checkedVariant);
        }
    });
</script>
@endsection
