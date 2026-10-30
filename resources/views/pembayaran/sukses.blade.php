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

                    <!-- Tombol Unduh Kuitansi (Window Print / PDF) -->
                    <button type="button" onclick="window.print()" class="btn btn-outline-secondary w-100 py-2.5 fw-semibold small mt-2 d-flex align-items-center justify-content-center gap-2 d-print-none" style="border: 1.5px solid #cbd5e1; border-radius: 12px; color: #334155;">
                        <i class="bi bi-download"></i>
                        <span>Unduh Bukti Transaksi (PDF)</span>
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

<!-- Mode Cetak Khusus Saat Pengguna Menekan 'Unduh Bukti Transaksi (PDF)' -->
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
@endsection
