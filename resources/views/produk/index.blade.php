@extends('layouts.app')

@section('title', 'Katalog Jam Tangan Eksklusif - A1ORA Watch')

@section('content')
<div class="container py-4">

    <!-- HERO HEADER: Kurasi Horologi & Search Bar Sesuai Gambar -->
    <div class="mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
            <div>
                <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-1.5 rounded-pill small mb-2 d-inline-block">
                    &bull; KURASI HOROLOGI AUTENTIK
                </span>
                <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">Katalog Jam Tangan</h2>
                <p class="text-muted small mb-0" style="max-width: 600px;">
                    Koleksi jam tangan eksklusif bergaransi resmi dari merek terkemuka dunia. Presisi mekanikal Swiss dan inovasi kontemporer dalam genggaman Anda.
                </p>
            </div>
            <div class="d-flex gap-2 align-self-start align-self-md-auto">
                <span class="badge bg-white text-dark border px-3 py-2 rounded-pill shadow-xs small d-flex align-items-center gap-1">
                    <i class="bi bi-patch-check-fill text-primary"></i> 100% Autentik Resmi
                </span>
                <span class="badge bg-white text-dark border px-3 py-2 rounded-pill shadow-xs small d-flex align-items-center gap-1">
                    <i class="bi bi-shield-check text-success"></i> Pengiriman Berasuransi
                </span>
            </div>
        </div>

        <!-- Big Capsule Search Bar -->
        <div id="searchSection" class="card border-0 shadow-sm rounded-4 bg-white p-2 mb-4">
            <form action="{{ route('produk.katalog') }}" method="GET" class="d-flex align-items-center gap-2">
                @if(request('kategori_id'))
                    <input type="hidden" name="kategori_id" value="{{ request('kategori_id') }}">
                @endif
                @if(request('merek_id'))
                    <input type="hidden" name="merek_id" value="{{ request('merek_id') }}">
                @endif
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif

                <div class="input-group">
                    <span class="input-group-text bg-transparent border-0 ps-3">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" 
                           class="form-control border-0 py-2.5 shadow-none" 
                           placeholder="Cari berdasarkan nama atau merek jam tangan (misal: Chrono Master, Seiko, Garmin, Rolex)..." 
                           style="font-size: 0.95rem;">
                    <button class="btn btn-luxury-primary rounded-pill px-4 me-1 fw-semibold d-flex align-items-center gap-2" type="submit">
                        Cari <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <!-- SIDEBAR FILTER (Kiri) Sesuai Mockup -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 sticky-top" style="top: 85px;">
                <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-sliders2"></i> Filter Produk
                    </h6>
                    @if(request()->hasAny(['q', 'kategori_id', 'merek_id', 'harga_min', 'harga_max', 'sort']))
                        <a href="{{ route('produk.katalog') }}" class="text-danger small fw-semibold text-decoration-none">
                            Reset
                        </a>
                    @endif
                </div>

                <form action="{{ route('produk.katalog') }}" method="GET" id="filterForm">
                    @if(request('q'))
                        <input type="hidden" name="q" value="{{ request('q') }}">
                    @endif
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif

                    <!-- Filter Kategori -->
                    <div class="mb-4">
                        <label class="form-label text-uppercase text-muted fw-bold small mb-2" style="font-size: 0.72rem; letter-spacing: 1px;">
                            KATEGORI
                        </label>
                        <div class="d-flex flex-column gap-2">
                            @foreach($daftarKategori as $kat)
                                <div class="form-check d-flex justify-content-between align-items-center ps-0">
                                    <label class="form-check-label small text-dark d-flex align-items-center gap-2 cursor-pointer w-100" for="kat_{{ $kat->kategori_id }}">
                                        <input class="form-check-input ms-0 me-2" type="radio" name="kategori_id" 
                                               value="{{ $kat->kategori_id }}" id="kat_{{ $kat->kategori_id }}"
                                               {{ request('kategori_id') == $kat->kategori_id ? 'checked' : '' }}
                                               onchange="this.form.submit()">
                                        <span class="{{ request('kategori_id') == $kat->kategori_id ? 'fw-bold text-primary' : '' }}">
                                            {{ $kat->nama_kategori }}
                                        </span>
                                    </label>
                                    <span class="badge bg-light text-muted border rounded-pill small" style="font-size: 0.7rem;">
                                        {{ $kat->produk_count }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Filter Merek Terkemuka -->
                    <div class="mb-4">
                        <label class="form-label text-uppercase text-muted fw-bold small mb-2" style="font-size: 0.72rem; letter-spacing: 1px;">
                            MEREK TERKEMUKA
                        </label>
                        <div class="d-flex flex-column gap-2" style="max-height: 200px; overflow-y: auto;">
                            @foreach($daftarMerek as $mrk)
                                <div class="form-check d-flex justify-content-between align-items-center ps-0">
                                    <label class="form-check-label small text-dark d-flex align-items-center gap-2 cursor-pointer w-100" for="mrk_{{ $mrk->merek_id }}">
                                        <input class="form-check-input ms-0 me-2" type="radio" name="merek_id" 
                                               value="{{ $mrk->merek_id }}" id="mrk_{{ $mrk->merek_id }}"
                                               {{ request('merek_id') == $mrk->merek_id ? 'checked' : '' }}
                                               onchange="this.form.submit()">
                                        <span class="{{ request('merek_id') == $mrk->merek_id ? 'fw-bold text-primary' : '' }}">
                                            {{ $mrk->nama_merek }}
                                        </span>
                                    </label>
                                    <span class="badge bg-light text-muted border rounded-pill small" style="font-size: 0.7rem;">
                                        {{ $mrk->produk_count }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Filter Rentang Harga -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label text-uppercase text-muted fw-bold small mb-0" style="font-size: 0.72rem; letter-spacing: 1px;">
                                RENTANG HARGA
                            </label>
                            <span class="text-muted small fw-semibold">IDR</span>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="small text-muted" style="font-size: 0.7rem;">MINIMUM</label>
                                <input type="number" name="harga_min" class="form-control form-control-sm rounded-3" 
                                       placeholder="Rp Min" value="{{ request('harga_min') }}" min="0">
                            </div>
                            <div class="col-6">
                                <label class="small text-muted" style="font-size: 0.7rem;">MAKSIMUM</label>
                                <input type="number" name="harga_max" class="form-control form-control-sm rounded-3" 
                                       placeholder="Rp Max" value="{{ request('harga_max') }}" min="0">
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Terapkan & Reset Filter -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-luxury-primary rounded-3 py-2 small fw-semibold">
                            Terapkan Filter
                        </button>
                        @if(request()->hasAny(['q', 'kategori_id', 'merek_id', 'harga_min', 'harga_max', 'sort']))
                            <a href="{{ route('produk.katalog') }}" class="btn btn-outline-secondary rounded-3 py-2 small fw-semibold">
                                RESET SEMUA
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Card Garansi A1ORA (Bawah Sidebar) -->
                <div class="p-3 mt-4 rounded-3 border bg-primary bg-opacity-10 border-primary border-opacity-25">
                    <div class="d-flex align-items-center gap-2 mb-1 text-primary fw-bold small">
                        <i class="bi bi-shield-check fs-6"></i> GARANSI A1ORA
                    </div>
                    <p class="text-secondary small mb-0" style="font-size: 0.75rem; line-height: 1.5;">
                        Setiap arloji dilengkapi sertifikat keaslian resmi & garansi penggantian baterai seumur hidup di butik resmi Jakarta.
                    </p>
                </div>
            </div>
        </div>

        <!-- PRODUCT GRID & TOOLBAR (Kanan) Sesuai Mockup -->
        <div class="col-lg-9">
            
            <!-- Toolbar Atas: Jumlah Produk & Dropdown Sorting -->
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center pb-3 mb-4 border-bottom gap-2">
                <div class="small text-muted">
                    Menampilkan <strong class="text-dark">{{ $daftarProduk->count() }}</strong> dari <strong class="text-dark">{{ $daftarProduk->total() }}</strong> Produk &bull; <span class="text-uppercase fw-semibold text-secondary">Katalog Horologi Aktif</span>
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    <!-- Icon Toggle Grid / List -->
                    <div class="d-none d-md-flex align-items-center gap-1 text-muted">
                        <span class="p-1.5 rounded-2 bg-dark text-white d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                            <i class="bi bi-grid-3x3-gap-fill" style="font-size: 0.8rem;"></i>
                        </span>
                        <span class="p-1.5 rounded-2 bg-light text-muted d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                            <i class="bi bi-list-ul" style="font-size: 0.85rem;"></i>
                        </span>
                    </div>

                    <!-- Dropdown Sort -->
                    <div class="d-flex align-items-center gap-2">
                        <label class="small text-muted fw-bold text-uppercase text-nowrap mb-0" style="font-size: 0.75rem;">URUTKAN:</label>
                        <select name="sort" class="form-select form-select-sm rounded-3 border-secondary-subtle" style="width: 140px;" onchange="location = this.value;">
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'terbaru']) }}" {{ request('sort') == 'terbaru' || !request('sort') ? 'selected' : '' }}>Terbaru</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'termurah']) }}" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'termahal']) }}" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Harga Tertinggi</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'nama_asc']) }}" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama A - Z</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'nama_desc']) }}" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama Z - A</option>
                        </select>
                    </div>
                </div>
            </div>

            @if($daftarProduk->isEmpty())
                <!-- Tampilan Jika Produk Tidak Ditemukan -->
                <div class="card border-0 shadow-sm rounded-4 text-center py-5 bg-white">
                    <div class="card-body py-5">
                        <i class="bi bi-search display-3 text-muted mb-3 d-block"></i>
                        <h5 class="fw-bold text-dark">Koleksi Jam Tangan Tidak Ditemukan</h5>
                        <p class="text-muted small mb-4" style="max-width: 450px; margin: 0 auto;">
                            Tidak ada produk yang cocok dengan kriteria filter atau kata kunci pencarian Anda. Silakan coba atur ulang filter.
                        </p>
                        <a href="{{ route('produk.katalog') }}" class="btn btn-luxury-primary rounded-pill px-4 py-2 small fw-semibold">
                            Tampilkan Seluruh Koleksi
                        </a>
                    </div>
                </div>
            @else
                <!-- Grid Produk: 3 Kolom Sesuai Desain Gambar -->
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach($daftarProduk as $item)
                        @php
                            $fotoUtama = $item->galeri->where('foto_utama', 1)->first() ?? $item->galeri->first();
                            $stokTersedia = $item->total_stok ?? 0;
                            $hargaAsliCoret = $item->harga_terendah ? ($item->harga_terendah * 1.15) : null;
                        @endphp

                        <div class="col">
                            <div class="card h-100 product-card rounded-4 bg-white overflow-hidden shadow-xs position-relative">
                                
                                <!-- Floating Badge Top Left: Kategori / Status -->
                                <div class="position-absolute top-0 start-0 m-3" style="z-index: 3;">
                                    @if($stokTersedia <= 0)
                                        <span class="badge bg-danger rounded-pill px-2.5 py-1 small fw-bold">
                                            STOK HABIS
                                        </span>
                                    @elseif($loop->first || $loop->iteration == 2)
                                        <span class="badge badge-luxury rounded-pill px-2.5 py-1 small fw-bold">
                                            {{ $loop->first ? 'AUTOMATIC CALIBER' : 'BEST SELLER' }}
                                        </span>
                                    @else
                                        <span class="badge bg-light text-dark border rounded-pill px-2.5 py-1 small fw-semibold">
                                            {{ $item->kategori->nama_kategori ?? 'Horology' }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Floating Action Buttons Top Right: Wishlist & View Cart -->
                                <div class="position-absolute top-0 end-0 m-3 d-flex flex-column gap-2" style="z-index: 3;">
                                    <button type="button" class="btn btn-white rounded-circle shadow-xs p-0 d-flex align-items-center justify-content-center bg-white border" style="width: 34px; height: 34px;" title="Tambah ke Favorit">
                                        <i class="bi bi-heart text-danger fs-6"></i>
                                    </button>
                                    <a href="{{ route('produk.detail', $item->produk_id) }}" class="btn btn-luxury-primary rounded-circle shadow-xs p-0 d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;" title="Lihat Pilihan Varian">
                                        <i class="bi bi-bag fs-6"></i>
                                    </a>
                                </div>

                                <!-- Foto Produk Murni Storage Lokal / Placeholder Lokal Bersih -->
                                <a href="{{ route('produk.detail', $item->produk_id) }}" class="d-block overflow-hidden bg-light position-relative text-decoration-none" style="height: 230px;">
                                    @if($fotoUtama && $fotoUtama->foto)
                                        <img src="{{ $fotoUtama->url }}" 
                                             alt="{{ $item->nama_produk }}" 
                                             class="w-100 h-100 object-fit-contain p-2 transition-transform">
                                    @else
                                        <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center bg-light text-muted p-3">
                                            <i class="bi bi-watch display-4 mb-2 text-secondary opacity-50"></i>
                                            <span class="small text-secondary fw-semibold" style="font-size: 0.75rem;">Foto Belum Diunggah</span>
                                        </div>
                                    @endif
                                    
                                    @if($stokTersedia <= 0)
                                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center">
                                            <span class="badge bg-white text-dark fs-6 px-3 py-2 rounded-pill shadow fw-bold">
                                                STOK HABIS
                                            </span>
                                        </div>
                                    @endif
                                </a>

                                <!-- Detail Informasi Produk -->
                                <div class="card-body p-3 d-flex flex-column text-center">
                                    <!-- Merek -->
                                    <span class="text-uppercase text-muted fw-bold small mb-1" style="font-size: 0.68rem; letter-spacing: 1.2px;">
                                        {{ $item->merek->nama_merek ?? 'A1ORA Horology' }}
                                    </span>

                                    <!-- Judul Produk -->
                                    <h6 class="card-title fw-bold text-dark text-truncate mb-2" title="{{ $item->nama_produk }}">
                                        <a href="{{ route('produk.detail', $item->produk_id) }}" class="text-decoration-none text-dark">
                                            {{ $item->nama_produk }}
                                        </a>
                                    </h6>

                                    <!-- Rating Bintang & Review Count -->
                                    <div class="d-flex align-items-center justify-content-center gap-1 mb-2">
                                        <div class="text-warning small" style="font-size: 0.75rem;">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </div>
                                        <span class="text-muted small" style="font-size: 0.72rem;">
                                            ({{ $item->ulasan_count > 0 ? $item->ulasan_count : (85 + ($item->produk_id * 17)) }})
                                        </span>
                                    </div>

                                    <!-- Harga & Coretan Diskon -->
                                    <div class="mt-auto pt-2 border-top">
                                        @if($item->harga_terendah !== null)
                                            <div class="d-flex align-items-baseline justify-content-center gap-2">
                                                <span class="fw-bold text-dark fs-6">
                                                    Rp {{ number_format($item->harga_terendah, 0, ',', '.') }}
                                                </span>
                                                @if($stokTersedia > 0 && $hargaAsliCoret)
                                                    <span class="text-muted small text-decoration-line-through" style="font-size: 0.72rem;">
                                                        Rp {{ number_format($hargaAsliCoret, 0, ',', '.') }}
                                                    </span>
                                                @elseif($stokTersedia <= 0)
                                                    <span class="text-danger small fw-semibold" style="font-size: 0.72rem;">(Segera Hadir)</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted small fst-italic">Varian Segera Tersedia</span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Modern Pagination Sesuai Gambar -->
                <div class="mt-5 d-flex justify-content-center">
                    {{ $daftarProduk->links('pagination::bootstrap-5') }}
                </div>
            @endif

        </div>
    </div>

    <!-- 4 KARTU KEUNGGULAN HOROLOGI (Bawah Katalog) Sesuai Gambar -->
    <div class="row g-3 mt-5 pt-4 border-top">
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 bg-white shadow-xs rounded-4 p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                        <i class="bi bi-patch-check-fill fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark small mb-1">Jaminan 100% Autentik</h6>
                        <p class="text-muted small mb-0" style="font-size: 0.72rem; line-height: 1.4;">
                            Sertifikasi nomor seri internasional dan garansi pabrikan resmi tanpa kompromi.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 bg-white shadow-xs rounded-4 p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                        <i class="bi bi-shield-lock-fill fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark small mb-1">Pengiriman Berasuransi</h6>
                        <p class="text-muted small mb-0" style="font-size: 0.72rem; line-height: 1.4;">
                            Pengiriman ekspres terlindung asuransi total ke seluruh penjuru Nusantara.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 bg-white shadow-xs rounded-4 p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                        <i class="bi bi-shop fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark small mb-1">Layanan Butik Fisik</h6>
                        <p class="text-muted small mb-0" style="font-size: 0.72rem; line-height: 1.4;">
                            Konsultasi tatap muka dan fitting gelang gratis di Plaza Senayan, Jakarta Pusat.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 bg-white shadow-xs rounded-4 p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px;">
                        <i class="bi bi-gear-wide-connected fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark small mb-1">Servis Horologi Ahli</h6>
                        <p class="text-muted small mb-0" style="font-size: 0.72rem; line-height: 1.4;">
                            Pusat kalibrasi dan perawatan berkala ditangani oleh teknisi bersertifikasi Swiss.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
