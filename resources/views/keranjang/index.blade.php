@extends('layouts.app')

@section('title', 'Keranjang Belanja - Kronos Watch')

@section('content')
<div class="container py-3">
    <!-- Judul Halaman -->
    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
        <div>
            <h4 class="fw-bold mb-1"><i class="bi bi-cart3 me-2"></i> Keranjang Belanja Anda</h4>
            <p class="text-muted small mb-0">Kelola daftar jam tangan yang akan Anda pesan.</p>
        </div>
        <a href="{{ route('produk.index') }}" class="btn btn-outline-dark btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Lanjut Belanja
        </a>
    </div>

    @if(!$keranjang || $keranjang->detail->isEmpty())
        <!-- Tampilan Jika Keranjang Kosong -->
        <div class="card border-0 shadow-sm rounded-4 text-center py-5 my-4">
            <div class="card-body">
                <i class="bi bi-cart-x display-1 text-muted opacity-50 mb-3 d-block"></i>
                <h5 class="fw-bold text-dark">Keranjang Belanja Anda Masih Kosong</h5>
                <p class="text-muted small mb-4">Anda belum memasukkan jam tangan apa pun ke dalam keranjang.</p>
                <a href="{{ route('produk.index') }}" class="btn btn-dark px-4 py-2 rounded-3 fw-semibold">
                    <i class="bi bi-watch me-1"></i> Jelajahi Katalog Jam Tangan
                </a>
            </div>
        </div>
    @else
        <!-- Tampilan Daftar Item & Ringkasan Belanja (F8-02) -->
        <div class="row g-4">
            <!-- Kolom Kiri: Daftar Barang -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-3">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr class="small text-muted">
                                    <th style="min-width: 250px;">Produk & Varian</th>
                                    <th>Harga Satuan</th>
                                    <th style="min-width: 140px;">Jumlah</th>
                                    <th>Subtotal</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($keranjang->detail as $item)
                                    @php
                                        $produk = $item->varian->produk ?? null;
                                        $fotoUtama = $produk && $produk->galeri ? ($produk->galeri->where('foto_utama', 1)->first() ?? $produk->galeri->first()) : null;
                                    @endphp
                                    <tr>
                                        <!-- Foto & Nama Produk -->
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="rounded-3 bg-light overflow-hidden d-flex align-items-center justify-content-center" style="width: 65px; height: 65px; flex-shrink: 0;">
                                                    @if($fotoUtama && $fotoUtama->foto)
                                                        <img src="{{ asset('storage/' . $fotoUtama->foto) }}" alt="{{ $produk->nama_produk ?? 'Jam' }}" class="w-100 h-100 object-fit-cover">
                                                    @else
                                                        <i class="bi bi-watch text-muted fs-4"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <a href="{{ route('produk.detail', $produk->produk_id ?? 0) }}" class="text-decoration-none text-dark fw-bold small d-block">
                                                        {{ $produk->nama_produk ?? 'Produk Tidak Ditemukan' }}
                                                    </a>
                                                    <span class="badge bg-light text-secondary border small mt-1">
                                                        Varian: {{ $item->varian->nama_varian ?? '-' }}
                                                    </span>
                                                    @if($item->varian && $item->varian->stok < $item->jumlah)
                                                        <span class="badge bg-danger-subtle text-danger d-block mt-1 small">
                                                            Sisa stok hanya: {{ $item->varian->stok }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Harga Satuan Varian (F8-02 & D.2) -->
                                        <td class="small fw-semibold text-secondary">
                                            Rp {{ number_format($item->varian->harga_varian ?? 0, 0, ',', '.') }}
                                        </td>

                                        <!-- Ubah Jumlah Barang (F8-03) -->
                                        <td>
                                            <form action="{{ route('keranjang.update', $item->detail_keranjang_id) }}" method="POST" class="d-flex align-items-center gap-1">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" 
                                                       name="jumlah" 
                                                       value="{{ $item->jumlah }}" 
                                                       min="1" 
                                                       max="{{ $item->varian->stok ?? 1 }}" 
                                                       class="form-control form-control-sm text-center fw-bold" 
                                                       style="width: 65px;"
                                                       onchange="this.form.submit()">
                                                <button type="submit" class="btn btn-outline-secondary btn-sm" title="Simpan Perubahan">
                                                    <i class="bi bi-arrow-repeat"></i>
                                                </button>
                                            </form>
                                        </td>

                                        <!-- Subtotal Item (F8-05 & Accessor) -->
                                        <td class="fw-bold text-dark small">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>

                                        <!-- Hapus Item (F8-03) -->
                                        <td class="text-center">
                                            <form action="{{ route('keranjang.hapus', $item->detail_keranjang_id) }}" method="POST" onsubmit="return confirm('Hapus jam tangan ini dari keranjang?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm border-0" title="Hapus Barang">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Ringkasan Belanja (F8-07) -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                    <h5 class="fw-bold text-dark mb-3">Ringkasan Belanja</h5>

                    <div class="d-flex justify-content-between text-muted small mb-2">
                        <span>Total Barang</span>
                        <span class="fw-semibold text-dark">{{ $keranjang->total_item }} Unit</span>
                    </div>

                    <div class="d-flex justify-content-between text-muted small mb-3 pb-3 border-bottom">
                        <span>Subtotal Produk</span>
                        <span class="fw-bold text-dark fs-6">Rp {{ number_format($keranjang->total_harga, 0, ',', '.') }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="fw-bold text-dark">Estimasi Total</span>
                        <span class="fw-bold text-danger fs-5">Rp {{ number_format($keranjang->total_harga, 0, ',', '.') }}</span>
                    </div>

                    <p class="text-muted small mb-3" style="font-size: 0.78rem;">
                        <i class="bi bi-info-circle me-1"></i> Biaya ongkos kirim dan formulir alamat penerima akan dihitung pada halaman Checkout.
                    </p>

                    <!-- Tombol Lanjut ke Checkout (Menuju Tahap 4) -->
                    <a href="{{ url('/checkout') }}" class="btn btn-dark w-100 py-2.5 rounded-3 fw-semibold">
                        Lanjut ke Checkout <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
