@extends('layouts.app')

@section('title', 'Pembayaran Berhasil #' . $pesanan->nomor_pesanan . ' - A1ORA Watch')

@section('content')
<div class="container py-3">

    <!-- Breadcrumb Navigasi -->
    <nav aria-label="breadcrumb" class="mb-3 d-print-none">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('produk.index') }}" class="text-decoration-none text-muted">Katalog</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pelanggan.beranda') }}" class="text-decoration-none text-muted">Pesanan Saya</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pembayaran.show', $pesanan->pesanan_id) }}" class="text-decoration-none text-muted">Pembayaran</a></li>
            <li class="breadcrumb-item active text-success fw-bold" aria-current="page">Berhasil</li>
        </ol>
    </nav>

    <!-- Stepper 4 Tahap Pembelian (Semua Tahap Selesai Hijau) -->
    <div class="card border-0 rounded-4 bg-white p-4 shadow-xs mb-4 d-print-none" style="border: 1px solid #e2e8f0 !important;">
        <div class="position-relative px-2 px-md-4">
            <!-- Garis Penghubung Hijau Solid (100% Selesai) -->
            <div class="position-absolute start-0 end-0 translate-middle-y d-none d-md-block" style="top: 16px; margin: 0 10%; height: 2px; background: #10b981; z-index: 1;"></div>

            <div class="d-flex justify-content-between position-relative" style="z-index: 2;">
                <!-- Langkah 1: Keranjang -->
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center shadow-xs flex-shrink-0" style="width: 34px; height: 34px; background: #10b981;">
                        <i class="bi bi-check-lg fw-bold" style="font-size: 0.95rem;"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 0.65rem; letter-spacing: 0.8px;">LANGKAH 1</div>
                        <div class="small fw-bold text-dark" style="font-size: 0.82rem;">Keranjang</div>
                    </div>
                </div>

                <!-- Langkah 2: Pengiriman -->
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center shadow-xs flex-shrink-0" style="width: 34px; height: 34px; background: #10b981;">
                        <i class="bi bi-check-lg fw-bold" style="font-size: 0.95rem;"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 0.65rem; letter-spacing: 0.8px;">LANGKAH 2</div>
                        <div class="small fw-bold text-dark" style="font-size: 0.82rem;">Pengiriman</div>
                    </div>
                </div>

                <!-- Langkah 3: Pembayaran -->
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center shadow-xs flex-shrink-0" style="width: 34px; height: 34px; background: #10b981;">
                        <i class="bi bi-check-lg fw-bold" style="font-size: 0.95rem;"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 0.65rem; letter-spacing: 0.8px;">LANGKAH 3</div>
                        <div class="small fw-bold text-dark" style="font-size: 0.82rem;">Pembayaran</div>
                    </div>
                </div>

                <!-- Langkah 4: Selesai -->
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center shadow-xs flex-shrink-0" style="width: 34px; height: 34px; background: #10b981;">
                        <i class="bi bi-check-lg fw-bold" style="font-size: 0.95rem;"></i>
                    </div>
                    <div>
                        <div class="text-uppercase text-success fw-bold" style="font-size: 0.65rem; letter-spacing: 0.8px;">LANGKAH 4</div>
                        <div class="small fw-bold text-success" style="font-size: 0.82rem;">Selesai</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Banner Sukses (Mint Ambient Gradient) -->
    <div class="card border-0 rounded-4 text-center p-4 p-md-5 mb-4 shadow-xs" style="background: linear-gradient(180deg, #f0fdf4 0%, #ecfdf5 100%); border: 1.5px solid #a7f3d0 !important;">
        <!-- Ikon Centang Hijau Besar -->
        <div class="d-inline-flex align-items-center justify-content-center text-white rounded-circle mx-auto mb-3" style="width: 76px; height: 76px; background: #10b981; box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.4);">
            <i class="bi bi-check-lg" style="font-size: 2.5rem; stroke-width: 2;"></i>
        </div>

        <div>
            <span class="badge rounded-pill px-3 py-1.5 fw-bold text-uppercase mb-2.5 d-inline-flex align-items-center gap-1.5" style="background: #d1fae5; color: #065f46; font-size: 0.72rem; letter-spacing: 0.5px;">
                <span class="rounded-circle d-inline-block" style="width: 7px; height: 7px; background: #059669;"></span>
                STATUS: DIBAYAR & TERVERIFIKASI
            </span>
        </div>

        <h2 class="fw-bolder text-dark mb-2" style="font-size: 2rem; letter-spacing: -0.5px;">Pembayaran Berhasil Diverifikasi!</h2>
        <p class="text-muted small mx-auto mb-0" style="max-width: 620px; font-size: 0.95rem; line-height: 1.6;">
            Terima kasih! Pesanan Anda telah terbayar penuh dan saat ini sedang disiapkan oleh tim kurator horologi <strong class="text-dark">A1ORA Watch Jakarta</strong>.
        </p>
    </div>

    <!-- Konten Utama 2 Kolom (Kiri col-lg-7, Kanan col-lg-5) -->
    <div class="row g-4">
        
        <!-- KOLOM KIRI (col-lg-7): Tracker Logistik & Rincian Jam Tangan -->
        <div class="col-lg-7">
            
            <!-- 1. Card Proses Verifikasi & Logistik -->
            <div class="card border-0 rounded-4 bg-white p-4 shadow-sm mb-4" style="border: 1px solid #e2e8f0 !important;">
                <div class="d-flex justify-content-between align-items-center mb-3.5 pb-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <span class="rounded-circle d-inline-block" style="width: 8px; height: 8px; background: #10b981;"></span>
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Proses Verifikasi & Logistik</h6>
                    </div>
                    <span class="badge rounded-pill px-3 py-1 fw-semibold" style="background: #f1f5f9; color: #475569; font-size: 0.72rem;">
                        Real-time Tracker
                    </span>
                </div>

                <div class="d-flex flex-column gap-3">
                    
                    <!-- Item 1: Verifikasi Pembayaran Real-time (Selesai) -->
                    <div class="d-flex align-items-center justify-content-between p-2.5 rounded-3 bg-light">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0" style="width: 28px; height: 28px; background: #10b981;">
                                <i class="bi bi-check-lg" style="font-size: 0.85rem;"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark small" style="font-size: 0.86rem;">Verifikasi Pembayaran Real-time</div>
                                <div class="text-muted" style="font-size: 0.74rem;">
                                    Lunas Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }} via {{ $pesanan->pembayaran?->metode_pembayaran ?? 'BCA Virtual Account' }} (ID: {{ sprintf('%03d-%03d-%04d', rand(10, 99), rand(100, 999), rand(1000, 9999)) }})
                                </div>
                            </div>
                        </div>
                        <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background: #dcfce7; color: #15803d; font-size: 0.72rem;">Selesai</span>
                    </div>

                    <!-- Item 2: Validasi Kode Simulasi Transaksi (Valid) -->
                    <div class="d-flex align-items-center justify-content-between p-2.5 rounded-3 bg-light">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0" style="width: 28px; height: 28px; background: #10b981;">
                                <i class="bi bi-check-lg" style="font-size: 0.85rem;"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark small" style="font-size: 0.86rem;">Validasi Kode Simulasi Transaksi</div>
                                <div class="text-muted" style="font-size: 0.74rem;">
                                    Kode: <strong class="font-monospace text-dark">{{ $pesanan->pembayaran?->nomor_referensi }}</strong> &bull; Terverifikasi Sistem
                                </div>
                            </div>
                        </div>
                        <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background: #dcfce7; color: #15803d; font-size: 0.72rem;">Valid</span>
                    </div>

                    <!-- Item 3: Penerbitan Sertifikat Garansi & Keaslian (COA) (Terbit) -->
                    <div class="d-flex align-items-center justify-content-between p-2.5 rounded-3 bg-light">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0" style="width: 28px; height: 28px; background: #10b981;">
                                <i class="bi bi-check-lg" style="font-size: 0.85rem;"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark small" style="font-size: 0.86rem;">Penerbitan Sertifikat Garansi & Keaslian (COA)</div>
                                <div class="text-muted" style="font-size: 0.74rem;">
                                    Nomor Seri Digital: <span class="font-monospace text-dark">KW-COA-{{ strtoupper(substr(md5($pesanan->nomor_pesanan), 0, 4)) }}-{{ strtoupper(substr($pesanan->nomor_pesanan, -3)) }}</span>
                                </div>
                            </div>
                        </div>
                        <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background: #dcfce7; color: #15803d; font-size: 0.72rem;">Terbit</span>
                    </div>

                    <!-- Item 4: Quality Control & Kalibrasi Mesin (Sedang Berjalan) -->
                    <div class="d-flex align-items-center justify-content-between p-2.5 rounded-3" style="background: #fffbeb; border: 1px solid #fef08a;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px; background: #fef3c7;">
                                <span class="spinner-grow spinner-grow-sm text-warning" style="width: 12px; height: 12px;"></span>
                            </div>
                            <div>
                                <div class="fw-bold text-dark small" style="font-size: 0.86rem;">Quality Control & Kalibrasi Mesin</div>
                                <div class="text-warning-emphasis" style="font-size: 0.74rem;">
                                    Pemeriksaan akurasi waktu otomatis & ketahanan segel air (Sedang Berjalan)
                                </div>
                            </div>
                        </div>
                        <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background: #fef3c7; color: #b45309; font-size: 0.72rem;">Proses</span>
                    </div>

                    <!-- Item 5: Pengemasan Tamper-Evident & Pick-up Kurir (Menunggu) -->
                    <div class="d-flex align-items-center justify-content-between p-2.5 rounded-3 bg-white border">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px; background: #f8fafc; border: 1.5px solid #cbd5e1;">
                                <span class="rounded-circle" style="width: 8px; height: 8px; background: #cbd5e1;"></span>
                            </div>
                            <div>
                                <div class="fw-semibold text-muted small" style="font-size: 0.86rem;">Pengemasan Tamper-Evident & Pick-up Kurir</div>
                                <div class="text-muted" style="font-size: 0.74rem;">
                                    Dijadwalkan serah terima hari ini sebelum 18:00 WIB
                                </div>
                            </div>
                        </div>
                        <span class="badge rounded-pill px-2.5 py-1 fw-semibold" style="background: #f1f5f9; color: #64748b; font-size: 0.72rem;">Menunggu</span>
                    </div>

                </div>
            </div>

            <!-- 2. Card Rincian Jam Tangan Dipesan -->
            <div class="card border-0 rounded-4 bg-white p-4 shadow-sm mb-4" style="border: 1px solid #e2e8f0 !important;">
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
                            <div class="rounded-3 bg-light border overflow-hidden d-flex align-items-center justify-content-center" style="width: 58px; height: 58px; flex-shrink: 0;">
                                @if($fotoUtama && $fotoUtama->foto)
                                    <img src="{{ $fotoUtama->url }}" alt="{{ $item->nama_produk }}" class="w-100 h-100 object-fit-cover">
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
                                    {{ $item->jumlah }} unit &times; Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="text-end fw-bold text-dark" style="font-size: 0.95rem;">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Perhitungan Rincian Biaya -->
                <div class="mt-3 pt-2">
                    <div class="d-flex justify-content-between text-muted small mb-2">
                        <span>Subtotal Produk</span>
                        <span class="text-dark fw-semibold">Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between text-muted small mb-2">
                        <span>Ongkos Kirim Flat (Asuransi Termasuk)</span>
                        <span class="text-dark fw-semibold">Rp {{ number_format($pesanan->ongkir, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between text-muted small mb-2">
                        <span>Biaya Layanan & Verifikasi VA</span>
                        <span class="text-success fw-bold">GRATIS</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-2">
                        <span class="fw-bold fs-5 text-dark">Total Pembayaran</span>
                        <div class="text-end">
                            <div class="fw-black fs-4" style="color: #059669; font-weight: 800; letter-spacing: -0.5px;">
                                Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                            </div>
                            <span class="badge bg-success small fw-bold px-2 py-0.5" style="font-size: 0.7rem;">LUNAS</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- KOLOM KANAN (col-lg-5): Ringkasan Invoice & Tombol Aksi -->
        <div class="col-lg-5">
            
            <!-- 1. Card Ringkasan Invoice -->
            <div class="card border-0 rounded-4 bg-white p-4 shadow-sm mb-4" style="border: 1px solid #e2e8f0 !important;">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <span class="small fw-bold text-muted text-uppercase tracking-wider" style="font-size: 0.78rem;">RINGKASAN INVOICE</span>
                    <span class="badge rounded-pill px-2.5 py-1 fw-semibold d-inline-flex align-items-center gap-1" style="background: #dcfce7; color: #15803d; font-size: 0.72rem;">
                        <span class="rounded-circle d-inline-block" style="width: 6px; height: 6px; background: #16a34a;"></span>
                        Official Receipt
                    </span>
                </div>

                <div class="small d-flex flex-column gap-2.5">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Nomor Pesanan</span>
                        <strong class="font-monospace text-dark">#{{ $pesanan->nomor_pesanan }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Waktu Transaksi</span>
                        <span class="text-dark fw-semibold">
                            {{ $pesanan->pembayaran?->waktu_pembayaran ? $pesanan->pembayaran->waktu_pembayaran->translatedFormat('d M Y, H:i') : now()->translatedFormat('d M Y, H:i') }} WIB
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Metode Bayar</span>
                        <span class="text-dark fw-bold">{{ $pesanan->pembayaran?->metode_pembayaran ?? 'BCA Virtual Account' }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Kode Pembayaran</span>
                        <span class="font-monospace fw-bold text-dark">{{ $pesanan->pembayaran?->nomor_referensi }}</span>
                    </div>

                    <!-- Divider Garis Putus -->
                    <hr class="my-2 border-secondary border-opacity-25">

                    <!-- Tujuan Pengiriman -->
                    <div>
                        <span class="small fw-bold text-muted text-uppercase d-block mb-1" style="font-size: 0.72rem;">TUJUAN PENGIRIMAN</span>
                        <div class="fw-bold text-dark" style="font-size: 0.88rem;">
                            {{ $pesanan->nama_penerima }} <span class="fw-normal text-muted">({{ $pesanan->telepon_penerima }})</span>
                        </div>
                        <div class="text-muted small mt-0.5" style="font-size: 0.78rem;">
                            {{ $pesanan->alamat_pengiriman }}, {{ $pesanan->kota }} - {{ $pesanan->kode_pos }}
                        </div>
                    </div>

                    <!-- Tombol Unduh Bukti Transaksi (Langsung Download PDF) -->
                    <button type="button" id="btnUnduhBukti" onclick="unduhBuktiPdf()" class="btn btn-dark w-100 py-2.5 fw-bold small mt-2 d-flex align-items-center justify-content-center gap-2 d-print-none shadow-sm" style="background: #0f172a; border-radius: 12px; height: 46px;">
                        <i class="bi bi-file-earmark-arrow-down-fill text-emerald-400 fs-5"></i>
                        <span id="btnUnduhBuktiText">Unduh Bukti Transaksi (PDF)</span>
                    </button>

                    <!-- Tombol Cetak Dokumen Fisik Alternatif -->
                    <button type="button" onclick="window.print()" class="btn btn-light w-100 py-1.5 fw-semibold small d-flex align-items-center justify-content-center gap-2 d-print-none border" style="border: 1.5px solid #e2e8f0; border-radius: 12px; color: #64748b; font-size: 0.78rem;">
                        <i class="bi bi-printer"></i>
                        <span>Cetak Dokumen Fisik</span>
                    </button>
                </div>
            </div>

            <!-- 2. Tombol Navigasi Aksi -->
            <div class="d-flex flex-column gap-2 mb-4 d-print-none">
                <a href="{{ route('pelanggan.beranda') }}" class="btn btn-dark w-100 py-3 fw-bold fs-6 shadow-sm d-flex align-items-center justify-content-center gap-2" style="background: #0f172a; height: 50px; border-radius: 14px;">
                    <span>Lihat Status Pesanan Saya</span>
                    <i class="bi bi-arrow-right"></i>
                </a>

                <a href="{{ route('produk.index') }}" class="btn btn-light w-100 py-2.5 fw-semibold small bg-white d-flex align-items-center justify-content-center border" style="border: 1.5px solid #e2e8f0; height: 48px; border-radius: 14px; color: #1e293b;">
                    <span>Kembali ke Katalog Belanja</span>
                </a>
            </div>

            <!-- 3. Card Garansi Resmi & Asuransi -->
            <div class="rounded-4 p-3.5 d-flex gap-3 align-items-start d-print-none" style="background: #f0fdf4; border: 1px solid #bbf7d0;">
                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; background: #dcfce7; color: #16a34a;">
                    <i class="bi bi-shield-check fs-5"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-dark mb-1" style="font-size: 0.85rem;">Garansi Resmi 2 Tahun & Asuransi 100%</h6>
                    <p class="text-muted small mb-0" style="font-size: 0.75rem; line-height: 1.45;">
                        Setiap pembelian di A1ORA Watch dilindungi garansi mekanis penuh dan jaminan penggantian unit baru apabila terjadi kerusakan saat pengiriman.
                    </p>
                </div>
            </div>

        </div>

    </div>

</div>

@php
    $logoPath = public_path('images/logo.png');
    $logoBase64 = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : asset('images/logo.png');
    $nomorCoa = 'KW-COA-' . strtoupper(substr(md5($pesanan->nomor_pesanan), 0, 4)) . '-' . strtoupper(substr($pesanan->nomor_pesanan, -3));
@endphp

<!-- ELEMEN KHUSUS GENERASI PDF BUKTI PEMBAYARAN RESMI (OFF-SCREEN) -->
<div id="buktiTransaksiPdf" style="display: none; position: fixed; top: 0; left: 0; width: 794px; background: #ffffff; color: #0f172a; font-family: 'Plus Jakarta Sans', Arial, sans-serif; padding: 40px 45px; box-sizing: border-box; z-index: -9999;">
    
    <!-- Header Kuitansi -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 22px; border-bottom: 2px solid #0f172a;">
        <div>
            <img src="{{ $logoBase64 }}" alt="A1ORA Watch" style="height: 44px; width: auto; object-fit: contain; margin-bottom: 8px;">
            <div style="font-size: 11px; font-weight: 800; letter-spacing: 1.5px; color: #0f172a; text-transform: uppercase;">A1ORA WATCH BOUTIQUE & HOROLOGY</div>
            <div style="font-size: 11px; color: #64748b; line-height: 1.4; margin-top: 2px;">
                Plaza Senayan Level 3, Jakarta Pusat, Indonesia<br>
                Layanan Pelanggan: concierge@a1orawatch.id | +62 21 5790 0123
            </div>
        </div>
        <div style="text-align: right;">
            <div style="font-size: 20px; font-weight: 800; letter-spacing: -0.5px; color: #0f172a;">BUKTI PEMBAYARAN RESMI</div>
            <div style="font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-top: 2px;">OFFICIAL PAYMENT RECEIPT</div>
            <div style="margin-top: 10px; display: inline-block; background: #ecfdf5; border: 1.5px solid #10b981; color: #065f46; font-size: 11px; font-weight: 800; padding: 4px 14px; border-radius: 999px; letter-spacing: 0.5px;">
                ✓ LUNAS & TERVERIFIKASI
            </div>
        </div>
    </div>

    <!-- Informasi Faktur & Penerima (Grid 2 Kolom) -->
    <div style="display: flex; justify-content: space-between; margin-top: 22px; padding: 18px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
        <!-- Kolom Data Pemesan / Tujuan Kirim -->
        <div style="width: 48%;">
            <div style="font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #64748b; margin-bottom: 6px;">DITERBITKAN KEPADA</div>
            <div style="font-size: 14px; font-weight: 700; color: #0f172a;">{{ $pesanan->nama_penerima }}</div>
            <div style="font-size: 12px; color: #475569; margin-top: 3px;">Telepon: <strong>{{ $pesanan->telepon_penerima }}</strong></div>
            <div style="font-size: 12px; color: #64748b; margin-top: 4px; line-height: 1.45;">
                {{ $pesanan->alamat_pengiriman }}<br>
                {{ $pesanan->kota }} - {{ $pesanan->kode_pos }}
            </div>
        </div>

        <!-- Kolom Data Transaksi -->
        <div style="width: 48%; border-left: 1px dashed #cbd5e1; padding-left: 20px;">
            <div style="font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #64748b; margin-bottom: 6px;">INFORMASI TRANSAKSI</div>
            <table style="width: 100%; font-size: 12px; border-collapse: collapse;">
                <tr>
                    <td style="color: #64748b; padding: 2px 0;">Nomor Pesanan</td>
                    <td style="text-align: right; font-weight: 800; font-family: monospace; color: #0f172a;">#{{ $pesanan->nomor_pesanan }}</td>
                </tr>
                <tr>
                    <td style="color: #64748b; padding: 2px 0;">Waktu Pembayaran</td>
                    <td style="text-align: right; font-weight: 600; color: #0f172a;">
                        {{ $pesanan->pembayaran?->waktu_pembayaran ? $pesanan->pembayaran->waktu_pembayaran->translatedFormat('d F Y, H:i') : now()->translatedFormat('d F Y, H:i') }} WIB
                    </td>
                </tr>
                <tr>
                    <td style="color: #64748b; padding: 2px 0;">Metode Pembayaran</td>
                    <td style="text-align: right; font-weight: 700; color: #0f172a;">{{ $pesanan->pembayaran?->metode_pembayaran ?? 'BCA Virtual Account' }}</td>
                </tr>
                <tr>
                    <td style="color: #64748b; padding: 2px 0;">Kode Referensi</td>
                    <td style="text-align: right; font-weight: 700; font-family: monospace; color: #0f172a;">{{ $pesanan->pembayaran?->nomor_referensi ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Tabel Rincian Jam Tangan -->
    <div style="margin-top: 22px;">
        <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
            <thead>
                <tr style="background: #0f172a; color: #ffffff;">
                    <th style="padding: 10px 12px; text-align: center; border-radius: 8px 0 0 0; width: 40px; font-weight: 700;">No</th>
                    <th style="padding: 10px 12px; text-align: left; font-weight: 700;">Model Jam Tangan</th>
                    <th style="padding: 10px 12px; text-align: left; font-weight: 700;">Varian & SKU</th>
                    <th style="padding: 10px 12px; text-align: center; width: 50px; font-weight: 700;">Qty</th>
                    <th style="padding: 10px 12px; text-align: right; width: 130px; font-weight: 700;">Harga Satuan</th>
                    <th style="padding: 10px 12px; text-align: right; border-radius: 0 8px 0 0; width: 130px; font-weight: 700;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesanan->detail as $index => $item)
                    <tr style="border-bottom: 1px solid #e2e8f0; background: {{ $index % 2 === 0 ? '#ffffff' : '#f8fafc' }};">
                        <td style="padding: 12px; text-align: center; color: #64748b;">{{ $index + 1 }}</td>
                        <td style="padding: 12px; font-weight: 700; color: #0f172a;">{{ $item->nama_produk }}</td>
                        <td style="padding: 12px; color: #475569;">
                            <div>{{ $item->nama_varian }}</div>
                            <div style="font-size: 10px; color: #94a3b8; font-family: monospace;">SKU: {{ $item->kode_sku }}</div>
                        </td>
                        <td style="padding: 12px; text-align: center; font-weight: 600; color: #0f172a;">{{ $item->jumlah }}</td>
                        <td style="padding: 12px; text-align: right; color: #475569;">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                        <td style="padding: 12px; text-align: right; font-weight: 700; color: #0f172a;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Ringkasan Perhitungan Total Biaya (Kanan Bawah) -->
    <div style="display: flex; justify-content: flex-end; margin-top: 18px;">
        <div style="width: 340px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px;">
            <div style="display: flex; justify-content: space-between; font-size: 12px; color: #64748b; margin-bottom: 8px;">
                <span>Subtotal Produk</span>
                <span style="font-weight: 600; color: #0f172a;">Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 12px; color: #64748b; margin-bottom: 8px;">
                <span>Ongkos Kirim (Asuransi Penuh)</span>
                <span style="font-weight: 600; color: #0f172a;">Rp {{ number_format($pesanan->ongkir, 0, ',', '.') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 12px; color: #64748b; margin-bottom: 12px;">
                <span>Biaya Layanan & VA</span>
                <span style="font-weight: 700; color: #10b981;">GRATIS</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 2px solid #0f172a; padding-top: 10px;">
                <div>
                    <div style="font-size: 13px; font-weight: 800; color: #0f172a; text-transform: uppercase;">Total Pembayaran</div>
                    <div style="font-size: 10px; color: #10b981; font-weight: 700;">STATUS: LUNAS (PAID)</div>
                </div>
                <div style="font-size: 18px; font-weight: 800; color: #059669; letter-spacing: -0.5px;">
                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Garansi Resmi & Sertifikat Keaslian -->
    <div style="margin-top: 22px; padding: 14px 18px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <div style="font-size: 11px; font-weight: 800; color: #166534; text-transform: uppercase; letter-spacing: 0.5px;">
                JAMINAN KEASLIAN 100% & GARANSI RESMI 2 TAHUN
            </div>
            <div style="font-size: 11px; color: #15803d; margin-top: 2px;">
                Dilindungi sertifikat keaslian digital A1ORA COA & garansi mesin internasional resmi.
            </div>
        </div>
        <div style="text-align: right;">
            <div style="font-size: 10px; color: #166534; font-weight: 600;">Nomor Seri Digital COA:</div>
            <div style="font-size: 12px; font-weight: 800; font-family: monospace; color: #0f172a;">{{ $nomorCoa }}</div>
        </div>
    </div>

    <!-- Catatan Penutup & Stempel Digital -->
    <div style="margin-top: 24px; padding-top: 16px; border-top: 1px dashed #cbd5e1; display: flex; justify-content: space-between; align-items: flex-end;">
        <div style="font-size: 10px; color: #94a3b8; line-height: 1.5; max-width: 520px;">
            * Kuitansi elektronik ini merupakan bukti transaksi yang sah dan diterbitkan otomatis oleh sistem A1ORA Watch tanpa memerlukan tanda tangan basah.<br>
            * Simpan bukti ini untuk keperluan klaim garansi, servis resmi butik, atau penukaran unit sesuai ketentuan berlaku.<br>
            * Waktu Cetak Dokumen: {{ now()->translatedFormat('d F Y, H:i:s') }} WIB
        </div>
        <div style="text-align: center; border: 1.5px solid #0f172a; padding: 6px 14px; border-radius: 8px; background: #ffffff;">
            <div style="font-size: 9px; font-weight: 800; letter-spacing: 1px; color: #0f172a; text-transform: uppercase;">A1ORA WATCH</div>
            <div style="font-size: 8px; font-weight: 700; color: #10b981;">OFFICIAL RECEIPT</div>
            <div style="font-size: 8px; color: #64748b; font-family: monospace;">VERIFIED SECURE</div>
        </div>
    </div>

</div>

<!-- Mode Cetak Khusus Saat Pengguna Menekan 'Cetak Dokumen Fisik' -->
<style>
    @media print {
        header, footer, .d-print-none {
            display: none !important;
        }
        body {
            background: #ffffff !important;
            color: #000000 !important;
        }
        .container {
            max-width: 100% !important;
            padding: 0 !important;
        }
        .card {
            border: 1px solid #cbd5e1 !important;
            box-shadow: none !important;
        }
    }
</style>

@push('scripts')
<!-- Library html2pdf lokal dengan fallback CDN -->
<script src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
<script>
    if (typeof html2pdf === 'undefined') {
        const cdnScript = document.createElement('script');
        cdnScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js';
        document.head.appendChild(cdnScript);
    }

    function unduhBuktiPdf() {
        const btn = document.getElementById('btnUnduhBukti');
        const btnText = document.getElementById('btnUnduhBuktiText');
        const originalContent = btnText.innerHTML;

        btn.disabled = true;
        btnText.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Menyiapkan PDF...';

        const element = document.getElementById('buktiTransaksiPdf');

        // Tampilkan elemen secara off-screen aman
        element.style.display = 'block';

        const opt = {
            margin:       [8, 8, 8, 8],
            filename:     'Bukti-Pembayaran-{{ $pesanan->nomor_pesanan }}.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { 
                scale: 2, 
                useCORS: true, 
                logging: false,
                letterRendering: true,
                windowWidth: 800
            },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        setTimeout(() => {
            if (typeof html2pdf !== 'function') {
                element.style.display = 'none';
                btn.disabled = false;
                btnText.innerHTML = originalContent;
                if (confirm('Library PDF sedang dimuat atau diblokir browser. Ingin membuka dialog cetak dokumen?')) {
                    window.print();
                }
                return;
            }

            html2pdf().set(opt).from(element).save().then(() => {
                element.style.display = 'none';
                btn.disabled = false;
                btnText.innerHTML = '<i class="bi bi-check2-circle text-emerald-400 me-1"></i>Unduh Ulang Bukti (PDF)';
            }).catch(err => {
                console.error('Gagal mengunduh PDF:', err);
                element.style.display = 'none';
                btn.disabled = false;
                btnText.innerHTML = originalContent;
                if (confirm('Unduhan otomatis mengalami kendala. Apakah Anda ingin mencetak dokumen secara langsung?')) {
                    window.print();
                }
            });
        }, 150);
    }
</script>
@endpush
@endsection
