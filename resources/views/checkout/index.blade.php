@extends('layouts.app')

@section('title', 'Checkout Pengiriman - A1ORA Watch')

@section('content')
<div class="container py-4">

    <!-- Stepper 4 Tahap Pembelian Sesuai Mockup -->
    <div class="card border-0 rounded-4 bg-white p-3 shadow-xs mb-4" style="border: 1px solid #e2e8f0 !important;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 px-md-3">
            <!-- Tahap 1: Keranjang (Selesai) -->
            <div class="d-flex align-items-center gap-2.5">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; border: 2px solid #2563eb; color: #2563eb;">
                    <i class="bi bi-check-lg fw-bold fs-6"></i>
                </div>
                <div>
                    <div class="text-uppercase text-muted fw-bold" style="font-size: 0.65rem; letter-spacing: 0.8px;">TAHAP 1</div>
                    <div class="fw-bold text-dark small">Keranjang</div>
                </div>
            </div>

            <!-- Garis Penghubung Aktif -->
            <div class="flex-grow-1 border-top d-none d-md-block" style="border-color: #2563eb !important; border-width: 2px !important; min-width: 30px;"></div>

            <!-- Tahap 2: Pengiriman (Sedang Aktif) -->
            <div class="d-flex align-items-center gap-2.5">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-xs" style="width: 36px; height: 36px; background: #1d4ed8;">
                    2
                </div>
                <div>
                    <div class="text-uppercase fw-bold text-primary" style="font-size: 0.65rem; letter-spacing: 0.8px;">SEDANG AKTIF</div>
                    <div class="fw-bold text-dark small">2. Pengiriman</div>
                </div>
            </div>

            <!-- Garis Penghubung Nonaktif -->
            <div class="flex-grow-1 border-top d-none d-md-block" style="border-color: #e2e8f0 !important; border-width: 2px !important; min-width: 30px;"></div>

            <!-- Tahap 3: Pembayaran -->
            <div class="d-flex align-items-center gap-2.5">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-muted fw-bold" style="width: 36px; height: 36px; background: #f1f5f9;">
                    3
                </div>
                <div>
                    <div class="text-uppercase text-muted fw-bold" style="font-size: 0.65rem; letter-spacing: 0.8px;">BERIKUTNYA</div>
                    <div class="text-muted fw-semibold small">3. Pembayaran</div>
                </div>
            </div>

            <!-- Garis Penghubung Nonaktif -->
            <div class="flex-grow-1 border-top d-none d-md-block" style="border-color: #e2e8f0 !important; border-width: 2px !important; min-width: 30px;"></div>

            <!-- Tahap 4: Selesai -->
            <div class="d-flex align-items-center gap-2.5">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-muted fw-bold" style="width: 36px; height: 36px; background: #f1f5f9;">
                    4
                </div>
                <div>
                    <div class="text-uppercase text-muted fw-bold" style="font-size: 0.65rem; letter-spacing: 0.8px;">KONFIRMASI</div>
                    <div class="text-muted fw-semibold small">4. Selesai</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Notifikasi Validasi Error -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4 border-0 shadow-xs" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4 border-0 shadow-xs" role="alert">
            <h6 class="fw-bold mb-1"><i class="bi bi-x-circle-fill me-1"></i> Mohon lengkapi data pengiriman berikut:</h6>
            <ul class="mb-0 small ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('checkout.proses') }}" method="POST" id="formCheckout">
        @csrf

        <div class="row g-4">
            <!-- Kolom Kiri: Formulir Alamat & Layanan Pengiriman -->
            <div class="col-lg-7">

                <!-- 1. Card Informasi Pengiriman -->
                <div class="card border-0 rounded-4 bg-white p-4 mb-4 shadow-sm" style="border: 1px solid #e2e8f0 !important;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center shadow-xs" style="width: 42px; height: 42px; background: #eff6ff; color: #2563eb;">
                                <i class="bi bi-geo-alt fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Informasi Pengiriman</h5>
                                <div class="text-muted small" style="font-size: 0.8rem;">Alamat tujuan sertifikat garansi & paket timepiece</div>
                            </div>
                        </div>
                        <div>
                            <span class="badge rounded-pill px-3 py-1.5 fw-semibold" style="background: #e0edfe; color: #1d4ed8; font-size: 0.72rem; letter-spacing: 0.5px;">
                                ● ALAMAT UTAMA
                            </span>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-uppercase text-muted fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                NAMA PENERIMA <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_penerima" class="form-control rounded-3 py-2 bg-light border-0" value="{{ old('nama_penerima', $user->nama ?? '') }}" placeholder="Contoh: Naufal Alif" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-uppercase text-muted fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                NOMOR TELEPON / WHATSAPP <span class="text-danger">*</span>
                            </label>
                            <input type="tel" name="telepon_penerima" class="form-control rounded-3 py-2 bg-light border-0" value="{{ old('telepon_penerima', $user->no_telepon ?? '') }}" placeholder="Contoh: 08123456789" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-uppercase text-muted fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                ALAMAT LENGKAP <span class="text-danger">*</span>
                            </label>
                            <textarea name="alamat_pengiriman" class="form-control rounded-3 py-2 bg-light border-0" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan" required>{{ old('alamat_pengiriman', $user->alamat ?? '') }}</textarea>
                        </div>
                        <div class="col-md-7">
                            <label class="form-label text-uppercase text-muted fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                KOTA / KABUPATEN <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="kota" class="form-control rounded-3 py-2 bg-light border-0" value="{{ old('kota') }}" placeholder="Contoh: Surakarta / Jawa Tengah" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label text-uppercase text-muted fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                KODE POS <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="kode_pos" class="form-control rounded-3 py-2 bg-light border-0" value="{{ old('kode_pos') }}" placeholder="Contoh: 57126">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-uppercase text-muted fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                CATATAN PESANAN <span class="text-muted fw-normal text-lowercase">(opsional)</span>
                            </label>
                            <input type="text" name="catatan" class="form-control rounded-3 py-2 bg-light border-0" value="{{ old('catatan') }}" placeholder="Contoh: Tolong bungkus ekstra bubble wrap, warna box hitam">
                        </div>
                    </div>
                </div>

                <!-- 2. Card Layanan Pengiriman Resmi -->
                <div class="card border-0 rounded-4 bg-white p-4 shadow-sm" style="border: 1px solid #e2e8f0 !important;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center shadow-xs" style="width: 42px; height: 42px; background: #eff6ff; color: #2563eb;">
                                <i class="bi bi-truck fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">Layanan Pengiriman</h5>
                                <div class="text-muted small" style="font-size: 0.8rem;">Pilih kurir tersertifikasi penanganan jam tangan mekanis</div>
                            </div>
                        </div>
                        <div>
                            <span class="text-primary fw-semibold small d-inline-flex align-items-center">
                                <i class="bi bi-shield-check fs-5 me-1"></i> 100% Diasuransikan
                            </span>
                        </div>
                    </div>

                    <!-- Kotak Opsi Kurir Terpilih -->
                    <div class="p-3.5 rounded-4 mb-3" style="background: #f0f6ff; border: 2px solid #2563eb;">
                        <div class="d-flex justify-content-between align-items-start gap-3">
                            <div class="d-flex align-items-start gap-2.5">
                                <div class="mt-1">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 18px; height: 18px; background: #2563eb; color: #ffffff;">
                                        <i class="bi bi-check fs-6 fw-bold"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                                        <span class="fw-bold text-dark fs-6">Kurir Khusus Jam Tangan</span>
                                        <span class="badge rounded-pill px-2.5 py-1 text-white fw-bold" style="background: #0f172a; font-size: 0.65rem; letter-spacing: 0.5px;">PALING AMAN</span>
                                    </div>
                                    <p class="text-muted small mb-2" style="font-size: 0.8rem; line-height: 1.45;">
                                        Asuransi Pengiriman Penuh, segel anti-rusak berhologram, & QC Check fisik sebelum pelepasan kurir.
                                    </p>
                                    <div class="d-flex flex-wrap gap-2">
                                        <span class="badge bg-white text-dark border rounded-pill px-2.5 py-1 small fw-semibold">
                                            <i class="bi bi-clock me-1 text-primary"></i> Estimasi tiba: 2 - 3 hari kerja
                                        </span>
                                        <span class="badge bg-white text-primary border border-primary-subtle rounded-pill px-2.5 py-1 small fw-semibold">
                                            <i class="bi bi-shield-check me-1"></i> Asuransi Fisik & Mesin Termasuk
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end text-nowrap">
                                <div class="fw-bold text-primary fs-5">Rp {{ number_format($ongkir, 0, ',', '.') }}</div>
                                <div class="text-muted" style="font-size: 0.7rem;">Tarif Khusus Horologi</div>
                            </div>
                        </div>
                    </div>

                    <!-- Banner Informasi Segel Digital -->
                    <div class="d-flex align-items-start gap-2.5 p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <i class="bi bi-shield-lock-fill text-primary fs-5 mt-0.5"></i>
                        <span class="text-muted small" style="font-size: 0.78rem; line-height: 1.45;">
                            Seluruh pengiriman A1ORA Watch dilengkapi segel <i>tamper-evident digital</i>. Buka paket wajib direkam video unboxing untuk klaim validitas penuh garansi 2 tahun.
                        </span>
                    </div>
                </div>

            </div>

            <!-- Kolom Kanan: Ringkasan Pesanan & Pembayaran -->
            <div class="col-lg-5">
                <div class="card border-0 rounded-4 bg-white p-4 shadow-sm sticky-top" style="top: 85px; border: 1px solid #e2e8f0 !important;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0">Ringkasan Pesanan</h5>
                        <span class="badge bg-light text-secondary border fw-bold px-2.5 py-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                            {{ $keranjang->total_item }} ITEM
                        </span>
                    </div>

                    <!-- Daftar Item Jam Tangan -->
                    <div class="mb-3" style="max-height: 280px; overflow-y: auto;">
                        @foreach($keranjang->detail as $item)
                            @php
                                $produk = $item->varian->produk ?? null;
                                $fotoUtama = $produk && $produk->galeri ? ($produk->galeri->where('foto_utama', 1)->first() ?? $produk->galeri->first()) : null;
                                $eyebrow = strtoupper($produk->merek->nama_merek ?? ($produk->kategori->nama_kategori ?? 'A1ORA HOROLOGY'));
                            @endphp
                            <div class="d-flex align-items-center gap-3 py-2.5 border-bottom">
                                <div class="rounded-3 overflow-hidden bg-light border d-flex align-items-center justify-content-center" style="width: 58px; height: 58px; flex-shrink: 0;">
                                    @if($fotoUtama && $fotoUtama->foto)
                                        <img src="{{ asset('storage/' . $fotoUtama->foto) }}" alt="{{ $produk->nama_produk ?? 'Jam' }}" class="w-100 h-100 object-fit-cover">
                                    @else
                                        <i class="bi bi-watch text-secondary fs-4"></i>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="text-uppercase fw-bold text-primary" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                                        {{ $eyebrow }}
                                    </div>
                                    <div class="fw-bold text-dark small text-truncate" style="max-width: 180px;">
                                        {{ $produk->nama_produk ?? 'Jam Tangan' }}
                                    </div>
                                    <div class="text-muted small" style="font-size: 0.75rem;">
                                        Varian: {{ $item->varian->nama_varian }} &times; {{ $item->jumlah }} unit
                                    </div>
                                </div>
                                <div class="text-end fw-bold small text-dark">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Rincian Biaya -->
                    <div class="pt-1">
                        <div class="d-flex justify-content-between text-muted small mb-2">
                            <span>Subtotal Produk ({{ $keranjang->total_item }} barang)</span>
                            <span class="text-dark fw-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted small mb-2">
                            <span>Biaya Pengiriman</span>
                            <span class="text-dark fw-semibold">Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted small mb-2">
                            <span>Asuransi Pengiriman <i class="bi bi-question-circle text-muted" title="Dilindungi garansi proteksi penuh selama perjalanan"></i></span>
                            <span class="text-primary fw-bold">BEBAS BIAYA (GRATIS)</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted small mb-3 pb-3 border-bottom">
                            <span>Biaya Penanganan Eksklusif</span>
                            <span class="text-dark fw-semibold">Rp 0</span>
                        </div>

                        <!-- Total Pembayaran -->
                        <div class="d-flex justify-content-between align-items-end mb-4">
                            <div>
                                <div class="fw-bold text-muted small text-uppercase" style="letter-spacing: 0.5px; font-size: 0.7rem;">TOTAL PEMBAYARAN</div>
                                <div class="text-muted" style="font-size: 0.72rem;">Sudah termasuk PPN 11%</div>
                            </div>
                            <div class="fw-bold text-primary" style="font-size: 1.65rem; letter-spacing: -0.5px;">
                                Rp {{ number_format($totalHarga, 0, ',', '.') }}
                            </div>
                        </div>

                        <!-- Tombol Aksi Checkout -->
                        <button type="submit" id="btnSubmitCheckout" class="btn btn-primary w-100 py-3 rounded-pill fw-bold fs-6 shadow-sm mb-2.5 d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-lock-fill"></i>
                            <span>Buat Pesanan & Lanjut Bayar</span>
                        </button>

                        <a href="{{ route('keranjang.index') }}" class="btn btn-light w-100 py-2 rounded-pill small fw-semibold text-muted border-0 mb-3">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Keranjang
                        </a>

                        <!-- 3 Poin Keamanan Horology Hub -->
                        <div class="pt-2 border-top">
                            <div class="d-flex align-items-center gap-2 small text-muted mb-2" style="font-size: 0.76rem;">
                                <i class="bi bi-patch-check-fill text-primary"></i>
                                <span>Jaminan Originalitas 100% Resmi & Nomor Seri Terdaftar</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 small text-muted mb-2" style="font-size: 0.76rem;">
                                <i class="bi bi-shield-check text-primary"></i>
                                <span>Garansi Pengiriman Aman & Pergantian Unit Baru Bila Rusak</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 small text-muted" style="font-size: 0.76rem;">
                                <i class="bi bi-lock-fill text-primary"></i>
                                <span>Transaksi Terenkripsi 256-Bit SSL Horology Payment Hub</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Bantuan WhatsApp Concierge -->
                <div class="card border-0 rounded-4 shadow-xs mt-3 bg-white p-3" style="border: 1px solid #e2e8f0 !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background: #eff6ff; color: #2563eb;">
                                <i class="bi bi-headset fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark small">Butuh Panduan Alamat?</div>
                                <div class="text-muted" style="font-size: 0.75rem;">WhatsApp Concierge aktif 24/7</div>
                            </div>
                        </div>
                        <a href="https://wa.me/6281234567890?text=Halo%20A1ORA%20Watch,%20saya%20butuh%20panduan%20pengisian%20alamat%20checkout." target="_blank" class="btn btn-sm btn-light border text-dark fw-bold px-3 py-1.5 rounded-pill" style="font-size: 0.75rem;">
                            HUBUNGI
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<!-- Script Efek Tombol Submit -->
<script>
    document.getElementById('formCheckout').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmitCheckout');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses Pesanan...';
    });
</script>
@endsection
