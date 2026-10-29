@extends('layouts.auth')

@section('title', 'Daftar Akun Baru - Kronos Watch')

@section('left_panel')
    <!-- Bagian Atas Panel Kiri: Pill KRONOS HOROLOGY PRIVÉ & Teks SWISS HERITAGE • JAKARTA -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span class="badge rounded-pill px-3 py-1.5 fw-bold"
              style="background: rgba(37, 99, 235, 0.22); color: #60a5fa; border: 1px solid rgba(96, 165, 250, 0.35); font-size: 0.65rem; letter-spacing: 1px;">
            KRONOS HOROLOGY PRIV&Eacute;
        </span>
        <span class="fw-bold text-uppercase" style="font-size: 0.62rem; letter-spacing: 1.4px; color: #94a3b8;">
            SWISS HERITAGE &bull; JAKARTA
        </span>
    </div>

    <!-- Bagian Tengah Panel Kiri: Kartu Foto Jam Tangan & Headline -->
    <div class="my-auto py-3">
        <div class="watch-showcase-card mb-4 p-4">
            {{--
                PANDUAN MENGGANTI GAMBAR:
                Simpan file foto jam tangan Anda di: public/images/auth-watch.jpg
                Jika file tersebut tersedia, gambar akan otomatis ditampilkan di bawah ini.
                Jika belum ada, kartu gradien gelap dengan ikon jam tangan akan tampil sebagai pengganti sementara.
            --}}
            @if(file_exists(public_path('images/auth-watch.jpg')))
                <img src="{{ asset('images/auth-watch.jpg') }}"
                     alt="Kronos Watch Calibre 9901"
                     class="w-100 h-100 object-fit-cover position-absolute top-0 start-0"
                     style="opacity: 0.85;">
            @else
                <div class="text-center py-3 position-relative" style="z-index: 2;">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2"
                         style="width: 104px; height: 104px; background: radial-gradient(circle, rgba(59,130,246,0.28) 0%, rgba(15,23,42,0.4) 75%); border: 1px solid rgba(148,163,184,0.2);">
                        <i class="bi bi-watch text-white" style="font-size: 3.4rem; filter: drop-shadow(0 8px 16px rgba(0,0,0,0.5));"></i>
                    </div>
                </div>
            @endif

            <!-- Keterangan Kecil di Kiri Bawah dan Kanan Bawah -->
            <div class="position-absolute bottom-0 start-0 end-0 p-3 d-flex justify-content-between align-items-center"
                 style="background: linear-gradient(180deg, transparent 0%, rgba(9, 14, 23, 0.88) 100%); z-index: 3;">
                <span class="fw-bold text-uppercase font-monospace"
                      style="color: #e2e8f0; font-size: 0.66rem; letter-spacing: 1px;">
                    CALIBRE 9901 PRECISION
                </span>
                <span class="badge rounded-pill px-2.5 py-1 fw-bold font-monospace"
                      style="background: rgba(37, 99, 235, 0.3); color: #93c5fd; border: 1px solid rgba(96, 165, 250, 0.3); font-size: 0.64rem;">
                    1/100 SEC
                </span>
            </div>
        </div>

        <h2 class="fw-bolder text-white mb-2" style="font-size: 1.65rem; letter-spacing: -0.6px; line-height: 1.2;">
            Mulai Perjalanan Horologi Anda
        </h2>
        <p class="mb-0" style="color: #94a3b8; font-size: 0.84rem; line-height: 1.6;">
            Bergabunglah bersama komunitas kolektor dan pecinta jam tangan autentik Indonesia.<br>
            Nikmati akses istimewa ke kurasi arloji mewah dan layanan purnajual prioritas.
        </p>
    </div>

    <!-- Bagian Bawah Panel Kiri: Kartu Semi-Transparan Berisi 3 Baris dengan Ikon -->
    <div class="glass-feature-card p-3.5 p-xl-4">
        <div class="d-flex flex-column gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width: 34px; height: 34px; background: rgba(37, 99, 235, 0.22); color: #60a5fa;">
                    <i class="bi bi-ticket-perforated-fill"></i>
                </div>
                <div>
                    <div class="fw-bold text-white" style="font-size: 0.8rem;">Voucher Eksklusif Member</div>
                    <div style="font-size: 0.7rem; color: #94a3b8;">Penawaran khusus untuk transaksi koleksi pilihan</div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width: 34px; height: 34px; background: rgba(16, 185, 129, 0.2); color: #34d399;">
                    <i class="bi bi-truck"></i>
                </div>
                <div>
                    <div class="fw-bold text-white" style="font-size: 0.8rem;">Pelacakan Pesanan Real-time</div>
                    <div style="font-size: 0.7rem; color: #94a3b8;">Pantau pengiriman berasuransi langsung dari akun Anda</div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width: 34px; height: 34px; background: rgba(245, 158, 11, 0.2); color: #fbbf24;">
                    <i class="bi bi-gem"></i>
                </div>
                <div>
                    <div class="fw-bold text-white" style="font-size: 0.8rem;">Akses Rilis Koleksi Terbatas</div>
                    <div style="font-size: 0.7rem; color: #94a3b8;">Prioritas pemesanan edisi terbatas sebelum rilis publik</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('right_panel')
    <!-- Header Form Register -->
    <div class="mb-3.5">
        <span class="badge rounded-pill px-2.5 py-1 fw-bold text-uppercase mb-2 d-inline-block"
              style="background-color: #dbeafe; color: #1d4ed8; font-size: 0.65rem; letter-spacing: 1px;">
            BERGABUNG BERSAMA KAMI
        </span>
        <h1 class="fw-bolder text-dark mb-1" style="font-size: 1.6rem; letter-spacing: -0.6px;">
            Daftar Akun Baru
        </h1>
        <p class="text-secondary mb-3" style="font-size: 0.83rem;">
            Lengkapi informasi di bawah ini untuk membuat akun Kronos Watch.
        </p>
    </div>

    <!-- Form Register -->
    <form action="{{ route('register') }}" method="POST" novalidate>
        @csrf

        <!-- 1. Nama / Username -->
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="nama_username" class="form-label fw-bold text-dark mb-0" style="font-size: 0.78rem;">
                    Nama / Username
                </label>
                @error('nama_username')
                    <span class="fw-bold" style="font-size: 0.68rem; color: #e11d48;">Periksa Kembali</span>
                @else
                    <span class="text-secondary fw-semibold" style="font-size: 0.68rem;">Wajib</span>
                @enderror
            </div>

            <div class="auth-input-group @error('nama_username') is-error @enderror">
                <span class="auth-input-icon">
                    <i class="bi bi-person"></i>
                </span>
                <input type="text" id="nama_username" name="nama_username" value="{{ old('nama_username') }}"
                       class="auth-input"
                       placeholder="Nama atau username Anda"
                       required autofocus>
                @error('nama_username')
                    <div class="auth-input-suffix">
                        <i class="bi bi-exclamation-circle-fill text-danger"></i>
                    </div>
                @enderror
            </div>

            <div class="text-secondary mt-1" style="font-size: 0.72rem;">
                Huruf, angka, titik, atau underscore. Dipakai untuk login.
            </div>

            @error('nama_username')
                <div class="d-flex align-items-center gap-1.5 mt-1" style="color: #e11d48; font-size: 0.74rem;">
                    <i class="bi bi-x-circle-fill me-1"></i>
                    <span>{{ $message }}</span>
                </div>
            @enderror
        </div>

        <!-- 2. Email -->
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="email" class="form-label fw-bold text-dark mb-0" style="font-size: 0.78rem;">
                    Email
                </label>
                @error('email')
                    <span class="fw-bold" style="font-size: 0.68rem; color: #e11d48;">Periksa Kembali</span>
                @enderror
            </div>

            <div class="auth-input-group @error('email') is-error @enderror">
                <span class="auth-input-icon">
                    <i class="bi bi-envelope"></i>
                </span>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                       class="auth-input"
                       placeholder="nama@email.com"
                       required>
                @error('email')
                    <div class="auth-input-suffix">
                        <i class="bi bi-exclamation-circle-fill text-danger"></i>
                    </div>
                @enderror
            </div>

            @error('email')
                <div class="d-flex align-items-center gap-1.5 mt-1" style="color: #e11d48; font-size: 0.74rem;">
                    <i class="bi bi-x-circle-fill me-1"></i>
                    <span>{{ $message }}</span>
                </div>
            @enderror
        </div>

        <!-- 3. No. Telepon (Prefix Statis +62) -->
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="no_telepon" class="form-label fw-bold text-dark mb-0" style="font-size: 0.78rem;">
                    No. Telepon
                </label>
                @error('no_telepon')
                    <span class="fw-bold" style="font-size: 0.68rem; color: #e11d48;">Periksa Kembali</span>
                @else
                    <span class="badge rounded-pill px-2 py-0.5 fw-semibold"
                          style="background-color: #dcfce7; color: #15803d; font-size: 0.65rem;">
                        WhatsApp Aktif
                    </span>
                @enderror
            </div>

            <div class="auth-input-group @error('no_telepon') is-error @enderror">
                <span class="auth-input-icon pe-1">
                    <i class="bi bi-telephone me-1.5"></i>
                </span>
                <span class="fw-bold pe-2 me-2 border-end"
                      style="font-size: 0.84rem; color: #334155; border-color: #cbd5e1 !important; user-select: none;">
                    +62
                </span>
                <input type="tel" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}"
                       class="auth-input"
                       placeholder="81234567890"
                       inputmode="numeric" required>
                @error('no_telepon')
                    <div class="auth-input-suffix">
                        <i class="bi bi-exclamation-circle-fill text-danger"></i>
                    </div>
                @enderror
            </div>

            @error('no_telepon')
                <div class="d-flex align-items-center gap-1.5 mt-1" style="color: #e11d48; font-size: 0.74rem;">
                    <i class="bi bi-x-circle-fill me-1"></i>
                    <span>{{ $message }}</span>
                </div>
            @enderror
        </div>

        <!-- 4. Password dan Konfirmasi Password (Sejajar Dua Kolom) -->
        <div class="row g-2.5 mb-3">
            <!-- Kolom Password -->
            <div class="col-sm-6">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="registerPassword" class="form-label fw-bold text-dark mb-0" style="font-size: 0.78rem;">
                        Password
                    </label>
                    @error('password')
                        <span class="fw-bold" style="font-size: 0.65rem; color: #e11d48;">Periksa Kembali</span>
                    @enderror
                </div>

                <div class="auth-input-group @error('password') is-error @enderror">
                    <span class="auth-input-icon">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" id="registerPassword" name="password"
                           class="auth-input"
                           placeholder="Min. 8 karakter"
                           required>
                    <div class="auth-input-suffix">
                        @error('password')
                            <i class="bi bi-exclamation-circle-fill text-danger" style="font-size: 0.85rem;"></i>
                        @enderror
                        <button type="button" class="btn-eye-toggle"
                                onclick="togglePasswordVisibility('registerPassword', 'registerPasswordEye')"
                                aria-label="Tampilkan atau sembunyikan password">
                            <i class="bi bi-eye" id="registerPasswordEye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Kolom Konfirmasi Password -->
            <div class="col-sm-6">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="registerPasswordConfirmation" class="form-label fw-bold text-dark mb-0" style="font-size: 0.78rem;">
                        Konfirmasi Password
                    </label>
                </div>

                <div class="auth-input-group @error('password') is-error @enderror">
                    <span class="auth-input-icon">
                        <i class="bi bi-shield-lock"></i>
                    </span>
                    <input type="password" id="registerPasswordConfirmation" name="password_confirmation"
                           class="auth-input"
                           placeholder="Ulangi password"
                           required>
                    <div class="auth-input-suffix">
                        <button type="button" class="btn-eye-toggle"
                                onclick="togglePasswordVisibility('registerPasswordConfirmation', 'registerPasswordConfirmEye')"
                                aria-label="Tampilkan atau sembunyikan konfirmasi password">
                            <i class="bi bi-eye" id="registerPasswordConfirmEye"></i>
                        </button>
                    </div>
                </div>
            </div>

            @error('password')
                <div class="col-12">
                    <div class="d-flex align-items-center gap-1.5 mt-0.5" style="color: #e11d48; font-size: 0.74rem;">
                        <i class="bi bi-x-circle-fill me-1"></i>
                        <span>{{ $message }}</span>
                    </div>
                </div>
            @enderror
        </div>

        <!-- Checkbox Persetujuan Syarat & Ketentuan -->
        <div class="mb-3.5">
            <div class="form-check d-flex align-items-start gap-2">
                <input class="form-check-input mt-1 @error('terms') is-invalid @enderror"
                       type="checkbox" id="terms" name="terms" value="1"
                       {{ old('terms') ? 'checked' : '' }} required>
                <label class="form-check-label text-secondary" for="terms" style="font-size: 0.76rem; line-height: 1.45;">
                    Saya menyetujui
                    <a href="javascript:void(0)" class="fw-semibold text-decoration-none" style="color: #2563eb; cursor: default;">Syarat &amp; Ketentuan</a>
                    serta
                    <a href="javascript:void(0)" class="fw-semibold text-decoration-none" style="color: #2563eb; cursor: default;">Kebijakan Privasi</a>
                    Kronos Watch.
                </label>
            </div>
            @error('terms')
                <div class="d-flex align-items-center gap-1.5 mt-1" style="color: #e11d48; font-size: 0.74rem;">
                    <i class="bi bi-x-circle-fill me-1"></i>
                    <span>{{ $message }}</span>
                </div>
            @enderror
        </div>

        <!-- Tombol Pill Biru Daftar -->
        <button type="submit" class="btn-auth-primary w-100 d-flex align-items-center justify-content-center gap-2 mt-3 mb-3">
            <span>Daftar</span>
            <span>&rarr;</span>
        </button>
    </form>

    <!-- Link ke Login -->
    <p class="text-center text-secondary mb-3" style="font-size: 0.83rem;">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: #2563eb;">
            Masuk
        </a>
    </p>

    <!-- Footer Kecil Keamanan & Keaslian -->
    <div class="d-flex justify-content-center align-items-center gap-4 pt-2 border-top text-secondary"
         style="font-size: 0.72rem; border-color: #e2e8f0 !important;">
        <span class="d-inline-flex align-items-center gap-1">
            <i class="bi bi-lock-fill text-primary"></i>
            <span>256-Bit SSL Enkripsi</span>
        </span>
        <span class="d-inline-flex align-items-center gap-1">
            <i class="bi bi-patch-check-fill text-success"></i>
            <span>100% Produk Original</span>
        </span>
    </div>
@endsection
