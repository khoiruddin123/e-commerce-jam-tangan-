@extends('layouts.auth')

@section('title', 'Masuk ke Akun Anda - Kronos Watch')

@section('left_panel')
    <!-- Bagian Atas Panel Kiri: Brand & Pill Boutique Resmi -->
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2.5">
            <div class="rounded-3 d-flex align-items-center justify-content-center me-2"
                 style="width: 34px; height: 34px; background: rgba(37, 99, 235, 0.25); border: 1px solid rgba(96, 165, 250, 0.35); color: #60a5fa;">
                <i class="bi bi-watch"></i>
            </div>
            <div>
                <div class="fw-extrabold text-white" style="font-size: 0.85rem; font-weight: 800; letter-spacing: 0.5px; line-height: 1.1;">
                    KRONOS WATCH
                </div>
                <div style="font-size: 0.6rem; letter-spacing: 1.5px; color: #94a3b8; font-weight: 600;">
                    HAUTE HOROLOGERIE SUISSE
                </div>
            </div>
        </div>

        <span class="badge rounded-pill px-3 py-1.5 fw-bold"
              style="background: rgba(37, 99, 235, 0.2); color: #60a5fa; border: 1px solid rgba(96, 165, 250, 0.3); font-size: 0.65rem; letter-spacing: 1px;">
            BOUTIQUE RESMI
        </span>
    </div>

    <!-- Bagian Tengah Panel Kiri: Kartu Jam Tangan & Headline -->
    <div class="my-auto py-4">
        <div class="watch-showcase-card mb-4 p-4">
            {{--
                PANDUAN MENGGANTI GAMBAR:
                Simpan file foto jam tangan Anda di: public/images/auth-watch.jpg
                Jika file tersebut tersedia, gambar akan otomatis ditampilkan di bawah ini.
                Jika belum ada, kartu gradien gelap dengan ikon jam tangan akan tampil sebagai pengganti sementara.
            --}}
            @if(file_exists(public_path('images/auth-watch.jpg')))
                <img src="{{ asset('images/auth-watch.jpg') }}"
                     alt="Kronos Watch Luxury Timepiece"
                     class="w-100 h-100 object-fit-cover position-absolute top-0 start-0"
                     style="opacity: 0.85;">
            @else
                <div class="text-center py-3 position-relative" style="z-index: 2;">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2"
                         style="width: 110px; height: 110px; background: radial-gradient(circle, rgba(59,130,246,0.28) 0%, rgba(15,23,42,0.4) 75%); border: 1px solid rgba(148,163,184,0.2);">
                        <i class="bi bi-watch text-white" style="font-size: 3.6rem; filter: drop-shadow(0 8px 16px rgba(0,0,0,0.5));"></i>
                    </div>
                </div>
            @endif

            <div class="position-absolute bottom-0 start-0 end-0 p-3 d-flex justify-content-between align-items-center"
                 style="background: linear-gradient(180deg, transparent 0%, rgba(9, 14, 23, 0.85) 100%); z-index: 3;">
                <span class="badge rounded-pill px-2.5 py-1 fw-bold"
                      style="background: rgba(255,255,255,0.1); color: #cbd5e1; font-size: 0.62rem; letter-spacing: 1.2px;">
                    EDIZIONE LIMITATA
                </span>
                <span class="text-white-50 font-monospace" style="font-size: 0.68rem;">SWISS CHRONOMETER</span>
            </div>
        </div>

        <div class="text-uppercase fw-bold mb-1" style="font-size: 0.68rem; letter-spacing: 1.6px; color: #60a5fa;">
            EDIZIONE LIMITATA
        </div>
        <h2 class="fw-bolder text-white mb-2" style="font-size: 1.75rem; letter-spacing: -0.6px; line-height: 1.2;">
            Presisi Waktu, Kemewahan Abadi
        </h2>
        <p class="mb-0" style="color: #94a3b8; font-size: 0.85rem; line-height: 1.6;">
            Nikmati kurasi arloji mewah berstandar tinggi dengan keaslian terjamin.<br>
            Setiap detak dirancang untuk menyempurnakan momen berharga Anda.
        </p>
    </div>

    <!-- Bagian Bawah Panel Kiri: Dua Kartu Sejajar -->
    <div class="row g-2.5">
        <div class="col-6">
            <div class="glass-feature-card p-3 h-100 d-flex align-items-center gap-2.5">
                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0 me-2"
                     style="width: 36px; height: 36px; background: rgba(37, 99, 235, 0.22); color: #60a5fa;">
                    <i class="bi bi-patch-check-fill"></i>
                </div>
                <div>
                    <div class="fw-bold text-white" style="font-size: 0.78rem; line-height: 1.2;">100% Original</div>
                    <div style="font-size: 0.68rem; color: #94a3b8;">Sertifikasi Manufaktur</div>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="glass-feature-card p-3 h-100 d-flex align-items-center gap-2.5">
                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0 me-2"
                     style="width: 36px; height: 36px; background: rgba(16, 185, 129, 0.2); color: #34d399;">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div>
                    <div class="fw-bold text-white" style="font-size: 0.78rem; line-height: 1.2;">Garansi Resmi</div>
                    <div style="font-size: 0.68rem; color: #94a3b8;">Proteksi Internasional</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('right_panel')
    <!-- Header Form Login -->
    <div class="mb-4">
        <div class="d-inline-flex align-items-center gap-1.5 fw-bold text-uppercase mb-2"
             style="font-size: 0.7rem; letter-spacing: 1.2px; color: #2563eb;">
            <span class="rounded-circle d-inline-block me-1" style="width: 7px; height: 7px; background-color: #2563eb;"></span>
            <span>SELAMAT DATANG KEMBALI</span>
        </div>
        <h1 class="fw-bolder text-dark mb-1" style="font-size: 1.65rem; letter-spacing: -0.6px;">
            Masuk ke Akun Anda
        </h1>
        <p class="text-secondary mb-0" style="font-size: 0.85rem;">
            Masukkan detail akun Anda untuk melanjutkan berbelanja.
        </p>
    </div>

    <!-- Alert Sukses (Setelah Register / Logout) -->
    @if (session('success'))
        <div id="loginSuccessAlert"
             class="d-flex align-items-center justify-content-between p-3 mb-3 rounded-4"
             style="background-color: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; font-size: 0.82rem;">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill text-success fs-6"></i>
                <span class="fw-semibold">{{ session('success') }}</span>
            </div>
            <button type="button" onclick="document.getElementById('loginSuccessAlert').remove()"
                    class="btn p-0 border-0 text-success ms-2" style="line-height: 1;">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endif

    <!-- Alert Merah Muda Saat Login Gagal -->
    @if ($errors->any())
        <div id="loginErrorAlert"
             class="d-flex align-items-center justify-content-between p-3 mb-3 rounded-4"
             style="background-color: #fff1f2; border: 1px solid #fda4af; color: #be123c; font-size: 0.82rem;">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-triangle-fill text-danger fs-6"></i>
                <span class="fw-semibold">{{ $errors->first() }}</span>
            </div>
            <button type="button" onclick="document.getElementById('loginErrorAlert').remove()"
                    class="btn p-0 border-0 text-danger ms-2" style="line-height: 1;" aria-label="Tutup">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endif

    <!-- Form Login -->
    <form action="{{ route('login') }}" method="POST" novalidate>
        @csrf

        <!-- Field 1: Email atau Username -->
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1.5">
                <label for="login" class="form-label fw-bold text-dark mb-0" style="font-size: 0.8rem;">
                    Email atau Username
                </label>
                <span class="text-secondary fw-semibold" style="font-size: 0.7rem;">Wajib</span>
            </div>

            <div class="auth-input-group {{ $errors->has('login') ? 'is-error' : '' }}">
                <span class="auth-input-icon">
                    <i class="bi bi-person"></i>
                </span>
                <input type="text" id="login" name="login" value="{{ old('login') }}"
                       class="auth-input"
                       placeholder="nama@email.com atau username"
                       required autofocus>
                @if($errors->has('login'))
                    <div class="auth-input-suffix">
                        <i class="bi bi-exclamation-circle-fill text-danger"></i>
                    </div>
                @endif
            </div>
        </div>

        <!-- Field 2: Password -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-1.5">
                <label for="loginPassword" class="form-label fw-bold text-dark mb-0" style="font-size: 0.8rem;">
                    Password
                </label>
                <a href="javascript:void(0)" class="text-decoration-none fw-semibold"
                   style="font-size: 0.75rem; color: #2563eb; cursor: default;"
                   title="Segera hadir">
                    Lupa Password?
                </a>
            </div>

            <div class="auth-input-group {{ $errors->has('password') ? 'is-error' : '' }}">
                <span class="auth-input-icon">
                    <i class="bi bi-lock"></i>
                </span>
                <input type="password" id="loginPassword" name="password"
                       class="auth-input"
                       placeholder="Masukkan password Anda"
                       required>
                <div class="auth-input-suffix">
                    <button type="button" class="btn-eye-toggle"
                            onclick="togglePasswordVisibility('loginPassword', 'loginPasswordEye')"
                            aria-label="Tampilkan atau sembunyikan password">
                        <i class="bi bi-eye" id="loginPasswordEye"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Tombol Pill Biru MASUK -->
        <button type="submit" class="btn-auth-primary w-100 d-flex align-items-center justify-content-center gap-2 mb-4">
            <span>MASUK</span>
            <span>&rarr;</span>
        </button>
    </form>

    <!-- Link ke Register -->
    <p class="text-center text-secondary mb-0" style="font-size: 0.84rem;">
        Belum punya akun?
        <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color: #2563eb;">
            Daftar Sekarang
        </a>
    </p>
@endsection
