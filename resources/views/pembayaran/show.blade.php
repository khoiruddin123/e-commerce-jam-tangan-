@extends('layouts.app')

@section('title', 'Pembayaran Pesanan #' . $pesanan->nomor_pesanan . ' - A1ORA Watch')

@section('content')
<div class="container py-3">

    <!-- Breadcrumb Navigasi -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('produk.index') }}" class="text-decoration-none text-muted">Katalog</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pelanggan.beranda') }}" class="text-decoration-none text-muted">Pesanan Saya</a></li>
            <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">Pembayaran</li>
        </ol>
    </nav>

    <!-- Notifikasi Pesan Flash & Validasi Error -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4 d-flex align-items-center gap-3 p-3.5" role="alert" style="border: 1.5px solid #fecdd3 !important; background: #fff1f2;">
            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px; background: #fee2e2; color: #dc2626;">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            </div>
            <div class="flex-grow-1">
                <strong class="text-danger d-block small fw-bold" style="font-size: 0.92rem;">Verifikasi Pembayaran Gagal</strong>
                <span class="text-danger small" style="font-size: 0.85rem;">{{ session('error') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4 d-flex align-items-center gap-3 p-3.5" role="alert" style="border: 1.5px solid #bbf7d0 !important; background: #f0fdf4;">
            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px; background: #dcfce7; color: #16a34a;">
                <i class="bi bi-check-circle-fill fs-5"></i>
            </div>
            <div class="flex-grow-1">
                <strong class="text-success d-block small fw-bold" style="font-size: 0.92rem;">Berhasil</strong>
                <span class="text-success small" style="font-size: 0.85rem;">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4 d-flex align-items-center gap-3 p-3.5" role="alert" style="border: 1.5px solid #fecdd3 !important; background: #fff1f2;">
            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px; background: #fee2e2; color: #dc2626;">
                <i class="bi bi-exclamation-octagon-fill fs-5"></i>
            </div>
            <div class="flex-grow-1">
                <strong class="text-danger d-block small fw-bold" style="font-size: 0.92rem;">Perhatian</strong>
                <ul class="mb-0 ps-3 small text-danger" style="font-size: 0.85rem;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Stepper 4 Tahap Pembelian (Simetris & Terpusat Sesuai Mockup) -->
    <div class="card border-0 rounded-4 bg-white p-4 shadow-xs mb-4" style="border: 1px solid #e2e8f0 !important;">
        <div class="position-relative px-2 px-md-4">
            <!-- Garis Penghubung Latar Belakang -->
            <div class="position-absolute start-0 end-0 translate-middle-y d-none d-md-block" style="top: 16px; margin: 0 12%; height: 2px; background: #e2e8f0; z-index: 1;">
                <div style="width: 66%; height: 100%; background: #10b981;"></div>
            </div>

            <div class="d-flex justify-content-between position-relative" style="z-index: 2;">
                <!-- Tahap 1: Keranjang (Selesai) -->
                <div class="text-center" style="width: 110px;">
                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center mx-auto mb-2 shadow-xs" style="width: 34px; height: 34px; background: #10b981;">
                        <i class="bi bi-check-lg fw-bold" style="font-size: 0.95rem;"></i>
                    </div>
                    <div class="small fw-semibold text-dark" style="font-size: 0.8rem;">1. Keranjang</div>
                </div>

                <!-- Tahap 2: Pengiriman (Selesai) -->
                <div class="text-center" style="width: 110px;">
                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center mx-auto mb-2 shadow-xs" style="width: 34px; height: 34px; background: #10b981;">
                        <i class="bi bi-check-lg fw-bold" style="font-size: 0.95rem;"></i>
                    </div>
                    <div class="small fw-semibold text-dark" style="font-size: 0.8rem;">2. Pengiriman</div>
                </div>

                <!-- Tahap 3: Pembayaran (Aktif) -->
                <div class="text-center" style="width: 110px;">
                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center mx-auto mb-2 shadow-sm" style="width: 34px; height: 34px; background: #2563eb;">
                        <span class="fw-bold" style="font-size: 0.88rem;">3</span>
                    </div>
                    <div class="small fw-bold text-primary" style="font-size: 0.8rem;">3. Pembayaran</div>
                </div>

                <!-- Tahap 4: Selesai -->
                <div class="text-center" style="width: 110px;">
                    <div class="rounded-circle text-muted d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 34px; height: 34px; background: #f1f5f9; border: 1px solid #e2e8f0;">
                        <span class="fw-bold" style="font-size: 0.88rem;">4</span>
                    </div>
                    <div class="small text-muted" style="font-size: 0.8rem;">4. Selesai</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Status Pesanan & Total Tagihan -->
    <div class="card border-0 rounded-4 bg-white p-4 mb-4 shadow-sm" style="border: 1px solid #e2e8f0 !important;">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <span class="badge rounded-pill px-3 py-1.5 fw-bold text-uppercase small mb-2" style="background: #fef3c7; color: #b45309; font-size: 0.72rem; letter-spacing: 0.5px;">
                    <i class="bi bi-clock me-1"></i> MENUNGGU PEMBAYARAN
                </span>
                <h3 class="fw-bold text-dark mb-1">Tagihan Pembayaran Pesanan</h3>
                <div class="text-muted small">
                    Nomor Pesanan: <strong class="text-dark font-monospace">#{{ $pesanan->nomor_pesanan }}</strong>
                    &bull; Tanggal: {{ $pesanan->created_at ? $pesanan->created_at->translatedFormat('d F Y, H:i') : now()->translatedFormat('d F Y, H:i') }} WIB
                </div>
            </div>
            <div class="text-md-end">
                <span class="text-muted small d-block mb-1">Total Tagihan:</span>
                <h2 class="fw-bold mb-0" style="color: #e11d48; font-size: 2.2rem; letter-spacing: -0.5px;">
                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                </h2>
            </div>
        </div>
    </div>

    @php
        $isExpired = $pembayaran->status_pembayaran === 'kedaluwarsa' || ($pembayaran->batas_pembayaran && now()->greaterThan($pembayaran->batas_pembayaran));
        $isCancelled = $pesanan->status_pesanan === 'dibatalkan' || $pembayaran->status_pembayaran === 'dibatalkan';
    @endphp

    @if($isCancelled)
        <!-- Alert Jika Pesanan Sudah Dibatalkan -->
        <div class="alert alert-danger rounded-4 border-0 shadow-sm p-4 text-center my-4 bg-white" style="border: 1px solid #fecdd3 !important;">
            <i class="bi bi-x-circle-fill display-4 text-danger d-block mb-2"></i>
            <h5 class="fw-bold text-dark">Pesanan Ini Telah Dibatalkan</h5>
            <p class="small text-muted mb-3">Transaksi untuk pesanan ini telah dibatalkan dan tidak dapat dilanjutkan.</p>
            <a href="{{ route('produk.index') }}" class="btn btn-outline-danger btn-sm rounded-pill px-4">Kembali ke Katalog</a>
        </div>
    @elseif($isExpired)
        <!-- Alert Jika Waktu Kedaluwarsa -->
        <div class="alert alert-danger rounded-4 border-0 shadow-sm p-4 text-center my-4 bg-white" style="border: 1px solid #fecdd3 !important;">
            <i class="bi bi-hourglass-bottom display-4 text-danger d-block mb-2"></i>
            <h5 class="fw-bold text-dark">Waktu Pembayaran Telah Kedaluwarsa</h5>
            <p class="small text-muted mb-3">Batas waktu untuk menyelesaikan pembayaran pesanan ini telah habis sehingga pesanan otomatis dibatalkan.</p>
            <a href="{{ route('produk.index') }}" class="btn btn-dark btn-sm rounded-pill px-4">Belanja Jam Tangan Baru</a>
        </div>
    @else
        <div class="row g-4">
            <!-- Kolom Kiri: Rincian Produk & Pengiriman (col-lg-5) -->
            <div class="col-lg-5">
                <!-- 1. Card Rincian Jam Tangan Dipesan -->
                <div class="card border-0 rounded-4 bg-white p-4 mb-4 shadow-sm" style="border: 1px solid #e2e8f0 !important;">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center shadow-xs" style="width: 34px; height: 34px; background: #eff6ff; color: #2563eb;">
                            <i class="bi bi-box-seam fs-6"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-0">Rincian Jam Tangan Dipesan</h6>
                    </div>
                    
                    <div>
                        @foreach($pesanan->detail as $item)
                            @php
                                $produk = $item->varian->produk ?? null;
                                $fotoUtama = $produk && $produk->galeri ? ($produk->galeri->where('foto_utama', 1)->first() ?? $produk->galeri->first()) : null;
                            @endphp
                            <div class="d-flex align-items-center gap-3 py-3 border-bottom">
                                <div class="rounded-3 bg-light border overflow-hidden d-flex align-items-center justify-content-center" style="width: 56px; height: 56px; flex-shrink: 0;">
                                    @if($fotoUtama && $fotoUtama->foto)
                                        <img src="{{ asset('storage/' . $fotoUtama->foto) }}" alt="{{ $item->nama_produk }}" class="w-100 h-100 object-fit-cover">
                                    @else
                                        <i class="bi bi-watch text-secondary fs-4"></i>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 0.92rem;">{{ $item->nama_produk }}</h6>
                                    <div class="text-muted small mb-0.5" style="font-size: 0.75rem;">
                                        Varian: <span class="text-dark fw-semibold">{{ $item->nama_varian }}</span> &bull; SKU: {{ $item->kode_sku }}
                                    </div>
                                    <div class="text-muted small" style="font-size: 0.78rem;">
                                        {{ $item->jumlah }} x Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="text-end fw-bold text-dark" style="font-size: 0.92rem;">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Ringkasan Perhitungan -->
                    <div class="mt-3 pt-2">
                        <div class="d-flex justify-content-between text-muted small mb-2">
                            <span>Subtotal Produk</span>
                            <span class="text-dark fw-semibold">Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted small mb-2">
                            <span>Ongkos Kirim Flat</span>
                            <span class="text-dark fw-semibold">Rp {{ number_format($pesanan->ongkir, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between fw-bold text-dark pt-2.5 border-top align-items-center">
                            <span>Total Pembayaran</span>
                            <span class="fs-5" style="color: #e11d48;">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- 2. Card Informasi Alamat Pengiriman -->
                <div class="card border-0 rounded-4 bg-white p-4 shadow-sm" style="border: 1px solid #e2e8f0 !important;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center shadow-xs" style="width: 34px; height: 34px; background: #fff1f2; color: #e11d48;">
                                <i class="bi bi-geo-alt fs-6"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-0">Alamat Pengiriman</h6>
                        </div>
                        <span class="badge rounded-pill px-3 py-1 fw-semibold" style="background: #f1f5f9; color: #475569; font-size: 0.72rem;">
                            ● Alamat Utama
                        </span>
                    </div>
                    <div class="small">
                        <div class="fw-bold text-dark mb-1" style="font-size: 0.92rem;">
                            {{ $pesanan->nama_penerima }} <span class="fw-normal text-muted">({{ $pesanan->telepon_penerima }})</span>
                        </div>
                        <div class="text-muted mb-1">{{ $pesanan->alamat_pengiriman }}</div>
                        <div class="text-muted">{{ $pesanan->kota }} {{ $pesanan->kode_pos ? ' - ' . $pesanan->kode_pos : '' }}</div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Kotak Simulasi Pembayaran & Hitung Mundur (col-lg-7) -->
            <div class="col-lg-7">
                <div class="card border-0 rounded-4 bg-white p-4 shadow-sm sticky-top" style="top: 85px; border: 1px solid #e2e8f0 !important;">
                    
                    <!-- Kotak Hitung Mundur Waktu -->
                    <div class="p-3.5 rounded-4 text-center mb-4" style="background: #fff5f5; border: 1px solid #fed7d7;">
                        <div class="small fw-bold text-uppercase mb-1.5" style="color: #e11d48; letter-spacing: 0.8px; font-size: 0.75rem;">
                            <i class="bi bi-clock me-1"></i> SELESAIKAN PEMBAYARAN DALAM:
                        </div>
                        <div id="countdownTimer" class="font-monospace fw-bold mb-1" style="font-size: 2.5rem; color: #dc2626; letter-spacing: 3px; line-height: 1.1;">
                            01 : 59 : 03
                        </div>
                        <div class="text-muted small" style="font-size: 0.75rem;">
                            Batas Waktu: {{ $pembayaran->batas_pembayaran ? $pembayaran->batas_pembayaran->translatedFormat('d F Y, H:i:s') : '-' }} WIB
                        </div>
                    </div>

                    <!-- Form Verifikasi Pembayaran -->
                    <form action="{{ route('pembayaran.verifikasi', $pesanan->pesanan_id) }}" method="POST" id="formVerifikasi">
                        @csrf

                        <!-- Pilihan Bank (Logo Asli Bersih di Wadah Khusus + Jarak Sejajar) -->
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-dark mb-2.5">Pilih Metode Bank (Simulasi):</label>
                            <div class="row g-2.5" id="bankSelectorGroup">
                                
                                <!-- 1. BCA Virtual Account -->
                                <div class="col-sm-6">
                                    <div class="bank-card rounded-4 d-flex align-items-center active-bank" 
                                         onclick="selectBank(this, 'BCA Virtual Account (Simulasi)')" 
                                         style="cursor: pointer; background: #f0f7ff; border: 2px solid #2563eb; height: 60px; padding: 0 14px; transition: all 0.2s ease;">
                                        <input type="radio" class="d-none" name="metode_pembayaran" value="BCA Virtual Account (Simulasi)" checked>
                                        
                                        <!-- Wadah Logo Putih Bersih (58x34 px) -->
                                        <div class="d-flex align-items-center justify-content-center bg-white rounded-3 border flex-shrink-0" style="width: 58px; height: 34px;">
                                            <div class="d-flex align-items-center justify-content-center rounded-1" style="background: #005baa; width: 48px; height: 26px;">
                                                <span class="text-white font-monospace" style="font-size: 0.85rem; letter-spacing: 0.5px; font-weight: 900;">BCA</span>
                                            </div>
                                        </div>

                                        <!-- Informasi Bank -->
                                        <div class="ms-3 flex-grow-1 min-w-0">
                                            <div class="small fw-bold text-dark bank-title text-truncate" style="font-size: 0.85rem; line-height: 1.2;">BCA Virtual Account</div>
                                            <div class="text-muted" style="font-size: 0.7rem;">Otomatis (24 Jam)</div>
                                        </div>

                                        <!-- Indikator Centang -->
                                        <div class="bank-status-icon ms-2 flex-shrink-0 text-primary">
                                            <i class="bi bi-check-circle-fill fs-5"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- 2. Mandiri Virtual -->
                                <div class="col-sm-6">
                                    <div class="bank-card rounded-4 d-flex align-items-center" 
                                         onclick="selectBank(this, 'Mandiri Virtual Account (Simulasi)')" 
                                         style="cursor: pointer; background: #ffffff; border: 1.5px solid #e2e8f0; height: 60px; padding: 0 14px; transition: all 0.2s ease;">
                                        <input type="radio" class="d-none" name="metode_pembayaran" value="Mandiri Virtual Account (Simulasi)">
                                        
                                        <!-- Wadah Logo Putih Bersih (58x34 px) -->
                                        <div class="d-flex align-items-center justify-content-center bg-white rounded-3 border flex-shrink-0" style="width: 58px; height: 34px;">
                                            <svg width="48" height="18" viewBox="0 0 120 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M85 8C96 8 108 14 114 22C106 18 96 16 88 17C79 18 70 24 64 30C71 22 78 14 85 8Z" fill="#FDB813"/>
                                                <text x="4" y="27" fill="#002D62" font-family="'Plus Jakarta Sans', Arial, sans-serif" font-weight="900" font-size="22" letter-spacing="-0.6">mandıri</text>
                                            </svg>
                                        </div>

                                        <!-- Informasi Bank -->
                                        <div class="ms-3 flex-grow-1 min-w-0">
                                            <div class="small fw-bold text-dark bank-title text-truncate" style="font-size: 0.85rem; line-height: 1.2;">Mandiri Virtual</div>
                                            <div class="text-muted" style="font-size: 0.7rem;">Otomatis (24 Jam)</div>
                                        </div>

                                        <!-- Indikator Centang -->
                                        <div class="bank-status-icon ms-2 flex-shrink-0 text-muted opacity-40">
                                            <i class="bi bi-circle fs-5"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- 3. BRI Virtual Account -->
                                <div class="col-sm-6">
                                    <div class="bank-card rounded-4 d-flex align-items-center" 
                                         onclick="selectBank(this, 'BRI Virtual Account (Simulasi)')" 
                                         style="cursor: pointer; background: #ffffff; border: 1.5px solid #e2e8f0; height: 60px; padding: 0 14px; transition: all 0.2s ease;">
                                        <input type="radio" class="d-none" name="metode_pembayaran" value="BRI Virtual Account (Simulasi)">
                                        
                                        <!-- Wadah Logo Putih Bersih (58x34 px) -->
                                        <div class="d-flex align-items-center justify-content-center bg-white rounded-3 border flex-shrink-0" style="width: 58px; height: 34px;">
                                            <div class="d-flex align-items-center justify-content-center rounded-1" style="background: #00529c; width: 48px; height: 26px;">
                                                <svg width="42" height="18" viewBox="0 0 100 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M22 8C14 14 12 24 18 31C16 26 18 17 25 12L22 8Z" fill="#F37021"/>
                                                    <text x="58" y="29" fill="#FFFFFF" font-family="'Plus Jakarta Sans', Arial, sans-serif" font-weight="900" font-size="26" letter-spacing="1" text-anchor="middle">BRI</text>
                                                </svg>
                                            </div>
                                        </div>

                                        <!-- Informasi Bank -->
                                        <div class="ms-3 flex-grow-1 min-w-0">
                                            <div class="small fw-bold text-dark bank-title text-truncate" style="font-size: 0.85rem; line-height: 1.2;">BRI Virtual Account</div>
                                            <div class="text-muted" style="font-size: 0.7rem;">Otomatis (24 Jam)</div>
                                        </div>

                                        <!-- Indikator Centang -->
                                        <div class="bank-status-icon ms-2 flex-shrink-0 text-muted opacity-40">
                                            <i class="bi bi-circle fs-5"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- 4. QRIS Pay -->
                                <div class="col-sm-6">
                                    <div class="bank-card rounded-4 d-flex align-items-center" 
                                         onclick="selectBank(this, 'QRIS Instant (Simulasi)')" 
                                         style="cursor: pointer; background: #ffffff; border: 1.5px solid #e2e8f0; height: 60px; padding: 0 14px; transition: all 0.2s ease;">
                                        <input type="radio" class="d-none" name="metode_pembayaran" value="QRIS Instant (Simulasi)">
                                        
                                        <!-- Wadah Logo Putih Bersih (58x34 px) -->
                                        <div class="d-flex align-items-center justify-content-center bg-white rounded-3 border flex-shrink-0" style="width: 58px; height: 34px;">
                                            <svg width="48" height="20" viewBox="0 0 100 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="2" y="8" width="7" height="7" rx="1.5" fill="#DC2626"/>
                                                <rect x="11" y="8" width="7" height="7" rx="1.5" fill="#1E293B"/>
                                                <rect x="2" y="17" width="7" height="7" rx="1.5" fill="#1E293B"/>
                                                <text x="24" y="25" fill="#DC2626" font-family="'Plus Jakarta Sans', Arial, sans-serif" font-weight="900" font-size="20" letter-spacing="0.5">QRIS</text>
                                            </svg>
                                        </div>

                                        <!-- Informasi Bank -->
                                        <div class="ms-3 flex-grow-1 min-w-0">
                                            <div class="small fw-bold text-dark bank-title text-truncate" style="font-size: 0.85rem; line-height: 1.2;">QRIS Instant</div>
                                            <div class="text-muted" style="font-size: 0.7rem;">BCA, GoPay, OVO, dll</div>
                                        </div>

                                        <!-- Indikator Centang -->
                                        <div class="bank-status-icon ms-2 flex-shrink-0 text-muted opacity-40">
                                            <i class="bi bi-circle fs-5"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Kotak Kode Pembayaran Acak (Nomor Referensi) -->
                        <div class="rounded-4 mb-4" style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 18px 20px;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small text-muted fw-semibold" style="font-size: 0.82rem;">Kode Pembayaran Simulasi Anda:</span>
                                <button type="button" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1.5 px-2.5 py-1" onclick="copyKodePembayaran()" style="font-size: 0.78rem; border-radius: 8px;">
                                    <i class="bi bi-copy"></i> <span>Salin</span>
                                </button>
                            </div>
                            <div class="d-flex align-items-center justify-content-between py-1 mb-2">
                                <span class="font-monospace fs-4 fw-bold text-dark mb-0" id="kodeDisplay" style="letter-spacing: 1.5px; line-height: 1;">
                                    {{ $pembayaran->nomor_referensi }}
                                </span>
                                <button type="button" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1.5 px-3 py-1.5 shadow-xs fw-semibold" onclick="pasteKode()" style="font-size: 0.8rem; border-radius: 10px; background: #2563eb; border: none;">
                                    <i class="bi bi-arrow-down-circle"></i> <span>Pakai Kode Ini</span>
                                </button>
                            </div>
                            <div class="d-flex align-items-center gap-2 text-muted small pt-2 border-top" style="font-size: 0.76rem;">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span>Ini adalah simulasi transaksi akademik. Masukkan kode di atas pada form verifikasi di bawah.</span>
                            </div>
                        </div>

                        <!-- Input Verifikasi Kode (Default KOSONG, Merah Jika Ada Kesalahan) -->
                        <div class="mb-4">
                            <label for="inputKode" class="form-label small fw-bold text-dark mb-2">
                                Masukkan Kode untuk Konfirmasi:
                            </label>
                            <input type="text" 
                                   name="kode_pembayaran" 
                                   id="inputKode" 
                                   value="{{ old('kode_pembayaran') }}"
                                   class="form-control form-control-lg font-monospace text-center fw-bold @if($errors->has('kode_pembayaran') || session('error')) is-invalid @endif" 
                                   style="border: 1.5px solid {{ (session('error') || $errors->has('kode_pembayaran')) ? '#ef4444' : '#cbd5e1' }}; background: #ffffff; font-size: 1.25rem; letter-spacing: 2px; height: 52px; border-radius: 14px;"
                                   placeholder="Masukkan kode pembayaran di sini" 
                                   required 
                                   autocomplete="off">
                            @if(session('error'))
                                <div class="text-danger small fw-semibold mt-1.5 d-flex align-items-center gap-1.5">
                                    <i class="bi bi-x-circle-fill"></i>
                                    <span>{{ session('error') }}</span>
                                </div>
                            @elseif($errors->has('kode_pembayaran'))
                                <div class="invalid-feedback text-center fw-semibold">
                                    {{ $errors->first('kode_pembayaran') }}
                                </div>
                            @endif
                        </div>

                        <!-- Tombol Verifikasi Bayar (Shape & Radius Presisi 14px) -->
                        <button type="submit" class="btn btn-dark w-100 py-3 fw-bold fs-6 shadow-sm mb-3 d-flex align-items-center justify-content-center gap-2" id="btnSubmitBayar" style="background: #0f172a; height: 50px; border-radius: 14px; transition: all 0.2s ease;">
                            <i class="bi bi-shield-check fs-5"></i>
                            <span>Verifikasi Pembayaran Sekarang</span>
                        </button>
                    </form>

                    <!-- Jarak Pemisah Lembut -->
                    <div class="text-center my-2">
                        <span class="text-muted small" style="font-size: 0.76rem;">Atau jika ingin membatalkan transaksi:</span>
                    </div>

                    <!-- Form Pembatalan Pesanan (Radius Serasi 14px) -->
                    <form action="{{ route('pembayaran.batal', $pesanan->pesanan_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini? Aksi ini tidak dapat diurungkan.')">
                        @csrf
                        <button type="submit" class="btn w-100 py-2.5 fw-semibold small bg-white d-flex align-items-center justify-content-center gap-2" style="border: 1.5px solid #fecdd3; color: #dc2626; height: 46px; border-radius: 14px; transition: all 0.2s ease;">
                            <i class="bi bi-x-circle fs-6"></i>
                            <span>Batalkan Pesanan Ini</span>
                        </button>
                    </form>

                </div>
            </div>
        </div>
    @endif
</div>

<!-- JavaScript Interaktivitas Bank & Hitung Mundur -->
<script>
    // 1. Fungsi Pilihan Bank (Interaktivitas Visual Presisi & Logo Bersih)
    function selectBank(element, value) {
        document.querySelectorAll('.bank-card').forEach(card => {
            card.style.background = '#ffffff';
            card.style.border = '1.5px solid #e2e8f0';
            const iconWrap = card.querySelector('.bank-status-icon');
            if (iconWrap) {
                iconWrap.className = 'bank-status-icon ms-2 flex-shrink-0 text-muted opacity-40';
                iconWrap.innerHTML = '<i class="bi bi-circle fs-5"></i>';
            }
        });

        // Aktifkan kartu yang dipilih
        element.style.background = '#f0f7ff';
        element.style.border = '2px solid #2563eb';
        const activeIconWrap = element.querySelector('.bank-status-icon');
        if (activeIconWrap) {
            activeIconWrap.className = 'bank-status-icon ms-2 flex-shrink-0 text-primary';
            activeIconWrap.innerHTML = '<i class="bi bi-check-circle-fill fs-5"></i>';
        }

        const radio = element.querySelector('input[type="radio"]');
        if (radio) radio.checked = true;
    }

    // 2. Batas Waktu Hitung Mundur dari Server
    const batasWaktuString = "{{ $pembayaran->batas_pembayaran ? $pembayaran->batas_pembayaran->toIso8601String() : '' }}";
    const targetTime = batasWaktuString ? new Date(batasWaktuString).getTime() : null;

    function updateCountdown() {
        if (!targetTime) return;

        const now = new Date().getTime();
        const difference = targetTime - now;

        const timerElement = document.getElementById('countdownTimer');
        const submitBtn = document.getElementById('btnSubmitBayar');
        const inputKode = document.getElementById('inputKode');

        if (difference <= 0) {
            if (timerElement) {
                timerElement.textContent = "00 : 00 : 00 (Kedaluwarsa)";
                timerElement.style.color = '#94a3b8';
            }
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bi bi-x-circle me-1"></i> Waktu Telah Habis';
                submitBtn.className = 'btn btn-secondary w-100 py-3 fw-bold fs-6 disabled';
                submitBtn.style.borderRadius = '14px';
            }
            if (inputKode) {
                inputKode.disabled = true;
            }
            return;
        }

        const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((difference % (1000 * 60)) / (1000 * 60));
        const seconds = Math.floor((difference % (1000 * 60)) / 1000);

        const format = (num) => String(num).padStart(2, '0');

        if (timerElement) {
            timerElement.textContent = `${format(hours)} : ${format(minutes)} : ${format(seconds)}`;
        }
    }

    if (targetTime) {
        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    // 3. Salin Kode ke Clipboard
    function copyKodePembayaran() {
        const kode = document.getElementById('kodeDisplay').textContent.trim();
        navigator.clipboard.writeText(kode).then(() => {
            alert('Kode pembayaran ' + kode + ' berhasil disalin ke clipboard!');
        });
    }

    // 4. Otomatis Isi Kode ke Input
    function pasteKode() {
        const kode = document.getElementById('kodeDisplay').textContent.trim();
        const input = document.getElementById('inputKode');
        if (input) {
            input.value = kode;
            input.focus();
        }
    }
</script>
@endsection
