@extends('layouts.app')

@section('title', 'Katalog Jam Tangan')

@section('content')
<div class="row">
    <!-- Kolom Sidebar Filter -->
    <div class="col-lg-3 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="fw-bold mb-3"><i class="bi bi-funnel me-1"></i> Filter Produk</h5>
                <form action="{{ route('produk.index') }}" method="GET">
                    <!-- Pencarian Nama / Merek -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Pencarian</label>
                        <input type="text" name="q" class="form-control form-control-sm" 
                               placeholder="Cari nama atau merek..." value="{{ request('q') }}">
                    </div>

                    <!-- Filter Kategori -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Kategori</label>
                        <select name="kategori_id" class="form-select form-select-sm">
                            <option value="">Semua Kategori</option>
                            @foreach($daftarKategori as $kat)
                                <option value="{{ $kat->kategori_id }}" {{ request('kategori_id') == $kat->kategori_id ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Rentang Harga -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Harga Minimum (Rp)</label>
                        <input type="number" name="harga_min" class="form-control form-control-sm" 
                               placeholder="Contoh: 100000" value="{{ request('harga_min') }}" min="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Harga Maksimum (Rp)</label>
                        <input type="number" name="harga_max" class="form-control form-control-sm" 
                               placeholder="Contoh: 2000000" value="{{ request('harga_max') }}" min="0">
                    </div>

                    <!-- Urutkan -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Urutkan</label>
                        <select name="sort" class="form-select form-select-sm">
                            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Harga Tertinggi</option>
                            <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama A - Z</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-dark btn-sm">
                            <i class="bi bi-search me-1"></i> Terapkan Filter
                        </button>
                        @if(request()->hasAny(['q', 'kategori_id', 'harga_min', 'harga_max', 'sort']))
                            <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary btn-sm">Reset Filter</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Kolom Daftar Produk -->
    <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Daftar Jam Tangan</h5>
            <span class="text-muted small">Menampilkan {{ $daftarProduk->total() }} produk</span>
        </div>

        @if($daftarProduk->isEmpty())
            <!-- Pesan jika produk tidak ditemukan -->
            <div class="card border-0 shadow-sm text-center py-5">
                <div class="card-body">
                    <i class="bi bi-search display-4 text-muted"></i>
                    <h5 class="mt-3 fw-bold">Produk Tidak Ditemukan</h5>
                    <p class="text-muted small">Coba ubah kata kunci pencarian atau sesuaikan filter rentang harga Anda.</p>
                    <a href="{{ route('produk.index') }}" class="btn btn-dark btn-sm">Lihat Semua Produk</a>
                </div>
            </div>
        @else
            <!-- Grid Produk -->
            <div class="row row-cols-1 row-cols-md-3 g-3">
                @foreach($daftarProduk as $item)
                    @php
                        // Ambil foto utama, jika tidak ada ambil foto pertama di galeri
                        $fotoUtama = $item->galeri->where('foto_utama', 1)->first() ?? $item->galeri->first();
                    @endphp
                    <div class="col">
                        <div class="card h-100 product-card shadow-sm border-0">
                            <!-- Foto Produk -->
                            <div style="height: 200px; background-color: #eee; overflow: hidden;" class="d-flex align-items-center justify-content-center">
                                @if($fotoUtama && $fotoUtama->foto)
                                    <img src="{{ asset('storage/' . $fotoUtama->foto) }}" 
                                         alt="{{ $item->nama_produk }}" 
                                         class="w-100 h-100 object-fit-cover">
                                @else
                                    <div class="text-muted text-center p-3">
                                        <i class="bi bi-watch display-6 d-block mb-1"></i>
                                        <span class="small">Tidak ada foto</span>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body d-flex flex-col flex-column">
                                <div class="mb-1">
                                    <span class="badge bg-secondary-subtle text-secondary small">{{ $item->kategori->nama_kategori ?? '-' }}</span>
                                    <span class="badge bg-light text-dark border small">{{ $item->merek->nama_merek ?? '-' }}</span>
                                </div>
                                <h6 class="card-title fw-bold text-truncate mb-2" title="{{ $item->nama_produk }}">
                                    {{ $item->nama_produk }}
                                </h6>

                                <!-- Harga Terendah dari Varian Aktif -->
                                <div class="mt-auto pt-2 border-top">
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">Mulai dari:</small>
                                    @if($item->harga_terendah !== null)
                                        <span class="fw-bold text-danger fs-6">
                                            Rp {{ number_format($item->harga_terendah, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-muted small fst-italic">Varian Habis</span>
                                    @endif
                                    
                                    <a href="{{ route('produk.detail', $item->produk_id) }}" class="btn btn-outline-dark btn-sm w-100 mt-2">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $daftarProduk->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
