@extends('layouts.app')

@section('title', 'Keranjang Belanja - A1ORA Official Boutique')

@section('content')
<div class="container py-4">

    @if(!$keranjang || $keranjang->detail->isEmpty())
        <!-- Tampilan Saat Keranjang Kosong -->
        <div class="card border-0 rounded-4 text-center py-5 my-4 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0 !important;">
            <div class="card-body py-5">
                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="bi bi-cart-x text-muted fs-1"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">Keranjang Belanja Anda Masih Kosong</h4>
                <p class="text-muted small mb-4" style="max-width: 480px; margin: 0 auto;">
                    Anda belum menambahkan jam tangan pilihan ke keranjang. Jelajahi katalog horologi kami dan temukan mahakarya penunjuk waktu Anda.
                </p>
                <a href="{{ route('produk.index') }}" class="btn btn-primary px-4 py-2.5 rounded-pill fw-semibold shadow-sm">
                    <i class="bi bi-watch me-1.5"></i> Jelajahi Koleksi Jam Tangan
                </a>
            </div>
        </div>
    @else
        @php
            $ongkir = 25000;
            $estimasiTotal = $keranjang->total_harga + $ongkir;
        @endphp

        <!-- Banner Layanan Pengiriman Resmi Berasuransi -->
        <div class="card border-0 rounded-4 shadow-xs mb-4" style="background: #f0f6ff; border: 1px solid #dbeafe !important;">
            <div class="card-body p-3 px-md-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center shadow-xs" style="width: 42px; height: 42px; flex-shrink: 0;">
                        <i class="bi bi-truck fs-5"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-0.5">
                            <span class="badge rounded-pill px-2.5 py-1 text-white fw-bold" style="background: #0f172a; font-size: 0.68rem; letter-spacing: 0.5px;">LAYANAN RESMI</span>
                            <span class="fw-bold text-dark" style="font-size: 0.95rem;">Pengiriman Kurir Kilat Berasuransi ke Seluruh Indonesia</span>
                        </div>
                        <div class="text-muted small" style="font-size: 0.8rem;">
                            Setiap unit jam tangan dikirim menggunakan segel keamanan anti-benturan dengan garansi proteksi penuh.
                        </div>
                    </div>
                </div>
                <div class="d-inline-flex align-items-center text-primary fw-semibold small text-nowrap">
                    <i class="bi bi-shield-check fs-5 me-1.5"></i> Asuransi Penuh Disertakan
                </div>
            </div>
        </div>

        <!-- Header Halaman -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
            <div>
                <div class="text-uppercase text-muted fw-bold mb-1" style="font-size: 0.72rem; letter-spacing: 1.5px;">A1ORA OFFICIAL BOUTIQUE</div>
                <h2 class="fw-bold text-dark mb-0">Keranjang Belanja Anda</h2>
            </div>
            <div>
                <span class="badge rounded-pill px-3 py-2 fw-semibold" style="background: #e0edfe; color: #1d4ed8; font-size: 0.82rem;">
                    <i class="bi bi-circle-fill me-1.5" style="font-size: 0.5rem; vertical-align: middle;"></i>
                    <span id="selectedCountBadge">{{ $keranjang->total_item }}</span> Produk Terpilih untuk Checkout
                </span>
            </div>
        </div>

        <div class="row g-4">
            <!-- Kolom Kiri: Daftar Jam Tangan & Fitur Eksklusif -->
            <div class="col-lg-8">

                <!-- Bar Opsi Pilih Semua -->
                <div class="card border-0 rounded-4 shadow-xs bg-white p-3 mb-3" style="border: 1px solid #e2e8f0 !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="form-check d-flex align-items-center gap-2 mb-0">
                            <input class="form-check-input mt-0" type="checkbox" id="selectAllCheckbox" checked onchange="toggleSelectAll(this)" style="cursor: pointer; width: 1.15rem; height: 1.15rem;">
                            <label class="form-check-label fw-bold text-dark small" for="selectAllCheckbox" style="cursor: pointer;">
                                Pilih Semua ({{ $keranjang->total_item }} Item)
                            </label>
                        </div>
                        <div>
                            <button type="button" class="btn btn-link text-muted text-decoration-none p-0 fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.5px;" onclick="unselectAll()">
                                <i class="bi bi-trash3 me-1"></i> HAPUS PILIHAN
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Kartu Daftar Barang di Keranjang -->
                @foreach($keranjang->detail as $item)
                    @php
                        $produk = $item->varian->produk ?? null;
                        $fotoUtama = $produk && $produk->galeri ? ($produk->galeri->where('foto_utama', 1)->first() ?? $produk->galeri->first()) : null;
                        $eyebrow = strtoupper($produk->merek->nama_merek ?? ($produk->kategori->nama_kategori ?? 'A1ORA COLLECTION'));
                    @endphp
                    <div class="card border-0 rounded-4 shadow-xs bg-white p-3 p-md-4 mb-3" style="border: 1px solid #e2e8f0 !important;" id="item-card-{{ $item->detail_keranjang_id }}">
                        <div class="row align-items-center g-3">
                            <!-- Checkbox Item -->
                            <div class="col-auto">
                                <input class="form-check-input item-checkbox" type="checkbox" checked data-id="{{ $item->detail_keranjang_id }}" data-qty="{{ $item->jumlah }}" onchange="updateSelectedCount()" style="cursor: pointer; width: 1.15rem; height: 1.15rem;">
                            </div>

                            <!-- Foto Jam Tangan (Lokal Storage / Fallback Icon) -->
                            <div class="col-auto">
                                <div class="position-relative rounded-3 overflow-hidden bg-light border d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; flex-shrink: 0;">
                                    @if($fotoUtama && $fotoUtama->foto)
                                        <img src="{{ $fotoUtama->url }}" alt="{{ $produk->nama_produk ?? 'Jam' }}" class="w-100 h-100 object-fit-cover">
                                    @else
                                        <i class="bi bi-watch text-secondary fs-2"></i>
                                    @endif
                                </div>
                            </div>

                            <!-- Identitas Jam & Varian -->
                            <div class="col-md">
                                <div class="text-uppercase fw-bold text-primary mb-1" style="font-size: 0.68rem; letter-spacing: 0.8px;">
                                    {{ $eyebrow }}
                                </div>
                                <h6 class="fw-bold text-dark mb-1">
                                    <a href="{{ route('produk.detail', $produk->produk_id ?? 0) }}" class="text-decoration-none text-dark">
                                        {{ $produk->nama_produk ?? 'Jam Tangan A1ORA' }}
                                    </a>
                                </h6>
                                <div class="text-muted small mb-1" style="font-size: 0.8rem;">
                                    {{ $item->varian->nama_varian ?? 'Standard' }}
                                </div>
                                @if($item->varian && $item->varian->stok < $item->jumlah)
                                    <div class="badge bg-danger-subtle text-danger small">
                                        <i class="bi bi-exclamation-triangle me-1"></i> Sisa stok: {{ $item->varian->stok }} unit
                                    </div>
                                @endif
                            </div>

                            <!-- Harga Satuan -->
                            <div class="col-6 col-md-auto text-md-center">
                                <div class="text-muted" style="font-size: 0.72rem;">Harga Satuan</div>
                                <div class="fw-bold text-dark" style="font-size: 0.92rem;">
                                    Rp {{ number_format($item->varian->harga_varian ?? 0, 0, ',', '.') }}
                                </div>
                            </div>

                            <!-- Stepper Kuantitas -->
                            <div class="col-6 col-md-auto">
                                <form action="{{ route('keranjang.update', $item->detail_keranjang_id) }}" method="POST" id="form-qty-{{ $item->detail_keranjang_id }}" class="m-0">
                                    @csrf
                                    @method('PATCH')
                                    <div class="input-group input-group-sm rounded-pill overflow-hidden border bg-light" style="width: 105px;">
                                        <button class="btn btn-sm btn-link text-dark text-decoration-none px-2.5 py-1 fw-bold" type="button" onclick="changeQty({{ $item->detail_keranjang_id }}, -1)">−</button>
                                        <input type="number" 
                                               id="input-qty-{{ $item->detail_keranjang_id }}" 
                                               name="jumlah" 
                                               value="{{ $item->jumlah }}" 
                                               min="1" 
                                               max="{{ $item->varian->stok ?? 99 }}" 
                                               class="form-control form-control-sm text-center border-0 bg-transparent fw-bold p-0" 
                                               style="width: 32px;"
                                               onchange="this.form.submit()">
                                        <button class="btn btn-sm btn-link text-dark text-decoration-none px-2.5 py-1 fw-bold" type="button" onclick="changeQty({{ $item->detail_keranjang_id }}, 1, {{ $item->varian->stok ?? 99 }})">+</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Subtotal & Tombol Hapus -->
                            <div class="col-12 col-md-auto d-flex align-items-center justify-content-between justify-content-md-end gap-3 text-end">
                                <div>
                                    <div class="text-muted d-md-none" style="font-size: 0.72rem;">Subtotal</div>
                                    <div class="fw-bold text-primary fs-6" style="min-width: 110px;">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </div>
                                </div>
                                <form action="{{ route('keranjang.hapus', $item->detail_keranjang_id) }}" method="POST" onsubmit="return confirm('Hapus jam tangan ini dari keranjang?')" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-muted p-1 border-0" title="Hapus dari Keranjang">
                                        <i class="bi bi-x-lg fs-6 text-secondary"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Link Lanjut Belanja & Info Update -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4 pt-1">
                    <a href="{{ route('produk.index') }}" class="text-decoration-none text-dark fw-bold small d-inline-flex align-items-center">
                        <i class="bi bi-arrow-left me-1.5"></i> Lanjutkan Belanja Jam Lainnya
                    </a>
                    <span class="text-muted small" style="font-size: 0.78rem;">
                        Perubahan keranjang otomatis diperbarui secara instan
                    </span>
                </div>

                <!-- 2 Kartu Jaminan Keaslian & Kemasan -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 rounded-4 p-3.5 bg-white shadow-xs h-100" style="border: 1px solid #e2e8f0 !important;">
                            <div class="d-flex align-items-start gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #eef2ff; color: #4338ca; flex-shrink: 0;">
                                    <i class="bi bi-award fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">100% Jam Tangan Original</h6>
                                    <p class="text-muted small mb-0" style="font-size: 0.78rem; line-height: 1.45;">
                                        Sertifikat keaslian resmi pabrikan horologi & Garansi Internasional A1ORA 2 Tahun penuh.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 rounded-4 p-3.5 bg-white shadow-xs h-100" style="border: 1px solid #e2e8f0 !important;">
                            <div class="d-flex align-items-start gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #eef2ff; color: #4338ca; flex-shrink: 0;">
                                    <i class="bi bi-box-seam fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">Kemasan Box Kayu Eksklusif</h6>
                                    <p class="text-muted small mb-0" style="font-size: 0.78rem; line-height: 1.45;">
                                        Dikemas mewah menggunakan Hardwood Leatherette Watch Box anti-benturan dengan segel hologram keamanan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Kolom Kanan: Ringkasan Belanja Sesuai Mockup -->
            <div class="col-lg-4">
                <div class="card border-0 rounded-4 bg-white p-4 shadow-sm" style="border: 1px solid #e2e8f0 !important;">
                    <h5 class="fw-bold text-dark mb-3">Ringkasan Belanja</h5>

                    <div class="pt-1">
                        <!-- Subtotal Produk -->
                        <div class="d-flex justify-content-between text-muted small mb-2">
                            <span>Subtotal Produk ({{ $keranjang->total_item }} Item)</span>
                            <span class="fw-semibold text-dark">Rp {{ number_format($keranjang->total_harga, 0, ',', '.') }}</span>
                        </div>

                        <!-- Biaya Pengiriman Riil Rp 25.000 -->
                        <div class="d-flex justify-content-between text-muted small mb-2">
                            <span>Biaya Pengiriman (Kurir Kilat)</span>
                            <span class="fw-semibold text-dark">Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
                        </div>

                        <!-- Asuransi Pengiriman Resmi (Gratis) Sesuai Mockup -->
                        <div class="d-flex justify-content-between text-muted small mb-2">
                            <span>Asuransi Pengiriman Horologi</span>
                            <span class="text-success fw-semibold">Gratis</span>
                        </div>

                        <!-- Garansi Resmi 2 Tahun (Termasuk) Sesuai Mockup -->
                        <div class="d-flex justify-content-between text-muted small mb-3 pb-3 border-bottom">
                            <span>Garansi Resmi 2 Tahun</span>
                            <span class="text-dark fw-semibold">Termasuk</span>
                        </div>

                        <!-- Total Pembayaran Realistis -->
                        <div class="d-flex justify-content-between align-items-end mb-4">
                            <div>
                                <div class="fw-bold text-muted small text-uppercase" style="letter-spacing: 0.5px; font-size: 0.72rem;">TOTAL PEMBAYARAN</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Termasuk Ongkir & Asuransi</div>
                            </div>
                            <div class="fw-bold text-primary" style="font-size: 1.65rem; letter-spacing: -0.5px;">
                                Rp {{ number_format($estimasiTotal, 0, ',', '.') }}
                            </div>
                        </div>

                        <!-- Tombol Menuju Checkout -->
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 py-3 rounded-pill fw-bold fs-6 shadow-sm mb-3 d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-lock-fill"></i>
                            <span>Lanjutkan ke Checkout (Rp {{ number_format($estimasiTotal, 0, ',', '.') }})</span>
                        </a>

                        <!-- Jaminan SSL -->
                        <div class="text-center text-muted small mb-3" style="font-size: 0.76rem;">
                            <i class="bi bi-shield-check text-primary me-1"></i> Pembayaran Aman 100% Terenkripsi 256-Bit SSL
                        </div>

                        <!-- Metode Pembayaran Resmi -->
                        <div class="text-center">
                            <div class="text-muted small text-uppercase fw-semibold mb-2" style="font-size: 0.65rem; letter-spacing: 1px;">METODE PEMBAYARAN RESMI</div>
                            <div class="d-flex justify-content-center flex-wrap gap-1.5">
                                <span class="badge bg-light text-secondary border px-2 py-1 fw-bold" style="font-size: 0.7rem;">BCA</span>
                                <span class="badge bg-light text-secondary border px-2 py-1 fw-bold" style="font-size: 0.7rem;">MDR</span>
                                <span class="badge bg-light text-secondary border px-2 py-1 fw-bold" style="font-size: 0.7rem;">BRI</span>
                                <span class="badge bg-light text-secondary border px-2 py-1 fw-bold" style="font-size: 0.7rem;">BNI</span>
                                <span class="badge bg-light text-secondary border px-2 py-1 fw-bold" style="font-size: 0.7rem;">QRIS</span>
                                <span class="badge bg-light text-secondary border px-2 py-1 fw-bold" style="font-size: 0.7rem;">VISA</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Bantuan WhatsApp Konsultan Horologi -->
                <div class="card border-0 rounded-4 shadow-xs mt-3" style="background: #f0f6ff; border: 1px solid #dbeafe !important;">
                    <a href="https://wa.me/6281234567890?text=Halo%20A1ORA%20Watch,%20saya%20ingin%20berkonsultasi%20mengenai%20pesanan%20keranjang%20saya." target="_blank" class="text-decoration-none p-3 d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center shadow-xs" style="width: 42px; height: 42px; flex-shrink: 0;">
                            <i class="bi bi-headset fs-4"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark small mb-0.5">Butuh Bantuan Pesanan?</div>
                            <div class="text-muted" style="font-size: 0.75rem;">Konsultan Horologi kami siap di WhatsApp 24/7</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    @endif

</div>

<!-- Script Interaktivitas Stepper & Pilihan -->
<script>
function changeQty(id, delta, max) {
    const input = document.getElementById('input-qty-' + id);
    if (!input) return;
    let currentVal = parseInt(input.value) || 1;
    let newVal = currentVal + delta;
    if (newVal < 1) newVal = 1;
    if (max && newVal > max) {
        alert('Jumlah melebihi stok yang tersedia (' + max + ' unit).');
        return;
    }
    if (newVal !== currentVal) {
        input.value = newVal;
        document.getElementById('form-qty-' + id).submit();
    }
}

function toggleSelectAll(master) {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    checkboxes.forEach(cb => {
        cb.checked = master.checked;
    });
    updateSelectedCount();
}

function unselectAll() {
    const master = document.getElementById('selectAllCheckbox');
    if (master) master.checked = false;
    toggleSelectAll({ checked: false });
}

function updateSelectedCount() {
    const checkboxes = document.querySelectorAll('.item-checkbox:checked');
    let totalItems = 0;
    checkboxes.forEach(cb => {
        totalItems += parseInt(cb.dataset.qty) || 1;
    });
    const badge = document.getElementById('selectedCountBadge');
    if (badge) {
        badge.innerText = totalItems;
    }
}
</script>
@endsection
