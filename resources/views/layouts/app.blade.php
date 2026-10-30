<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'A1ORA Watch - Luxury Timepiece')</title>

    <!-- Favicon Logo A1ORA -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-icon.png') }}">

    <!-- Google Fonts Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Mencegah layout shift (lompatan horizontal) saat berpindah antar halaman */
        html {
            overflow-y: scroll;
            scrollbar-gutter: stable;
        }
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background: linear-gradient(180deg, #edf4fe 0%, #f3f7fd 340px, #f8fafc 100%);
            background-attachment: fixed;
            color: #1e293b;
            min-height: 100vh;
        }
        /* Top Navbar Terkunci Presisi & Konsisten */
        .top-navbar {
            height: 68px;
            min-height: 68px;
            background-color: rgba(255, 255, 255, 0.96) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1030;
        }
        .top-navbar .navbar-container {
            width: 100% !important;
            max-width: 1440px !important;
            margin-left: auto !important;
            margin-right: auto !important;
            padding-left: clamp(1rem, 3.5vw, 2.5rem) !important;
            padding-right: clamp(1rem, 3.5vw, 2.5rem) !important;
        }

        /* 3-Kolom CSS Grid: Kolom Kiri Pinned, Kolom Tengah Centered, Kolom Kanan Pinned */
        .navbar-header-grid {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            width: 100%;
        }
        .navbar-brand-col {
            justify-self: start;
            display: flex;
            align-items: center;
        }
        .navbar-center-col {
            justify-self: center;
            display: flex;
            align-items: center;
        }
        .navbar-actions-col {
            justify-self: end;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        @media (max-width: 767.98px) {
            .navbar-header-grid {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
        }

        .brand-logo-box {
            width: 38px;
            height: 38px;
            min-width: 38px;
            min-height: 38px;
            flex-shrink: 0;
        }
        .navbar-brand-title {
            font-size: 1.18rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            line-height: 1.1;
            white-space: nowrap;
        }
        .navbar-brand-sub {
            font-size: 0.65rem;
            letter-spacing: 1.5px;
            font-weight: 600;
            color: #94a3b8;
            white-space: nowrap;
            line-height: 1;
            margin-top: 2px;
        }
        .nav-capsule {
            background-color: #f1f5f9;
            border-radius: 9999px;
            padding: 4px;
            display: inline-flex;
            gap: 4px;
            align-items: center;
        }
        .nav-capsule-link {
            padding: 6px 18px;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #64748b;
            text-decoration: none;
            transition: all 0.15s ease;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .nav-capsule-link:hover {
            color: #0f172a;
        }
        .nav-capsule-link.active {
            background-color: #ffffff;
            color: #0f172a;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }
        .product-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            border: 1px solid #e2e8f0;
        }
        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 24px -10px rgba(15, 23, 42, 0.12) !important;
            border-color: #cbd5e1;
        }
        .category-card {
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid #e2e8f0 !important;
        }
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px -8px rgba(15, 23, 42, 0.1) !important;
            border-color: #93c5fd !important;
        }
        .category-card:hover .category-img {
            transform: scale(1.06);
        }
        .category-card:hover .category-arrow-btn {
            background-color: #2563eb !important;
            color: #ffffff !important;
            transform: translateX(3px);
        }
        .badge-luxury {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: #ffffff;
        }
        .btn-luxury-primary {
            background: #2563eb;
            color: #ffffff;
            border: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .btn-luxury-primary:hover {
            background: #1d4ed8;
            color: #ffffff;
        }
        .footer-dark {
            background-color: #0f172a;
            color: #94a3b8;
        }
        .footer-dark a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s;
        }
        .footer-dark a:hover {
            color: #ffffff;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    @php
        $cartCount = 0;
        if (Auth::check()) {
            $cartCount = \App\Models\DetailKeranjang::whereHas('keranjang', function($q) {
                $q->where('user_id', Auth::id())->where('status', 'aktif');
            })->sum('jumlah');
        }
    @endphp

    <!-- Top Navbar Terkunci Presisi: Logo & Brand Tidak Akan Pernah Bergerak -->
    <header class="top-navbar border-bottom py-0 shadow-sm">
        <div class="navbar-container">
            <div class="navbar-header-grid">

                <!-- 1. Kolom Kiri: Brand & Logo (Anchor ke Kiri) -->
                <div class="navbar-brand-col">
                    <a class="d-flex align-items-center gap-2 text-decoration-none flex-shrink-0" href="{{ route('produk.index') }}" title="A1ORA Watch">
                        <img src="{{ asset('images/logo.png') }}" alt="A1ORA" style="height: 36px; width: auto; object-fit: contain;">
                        <div class="d-none d-xl-flex flex-column border-start ps-2" style="border-color: #cbd5e1 !important;">
                            <span style="font-size: 0.65rem; letter-spacing: 1.5px; font-weight: 700; color: #475569; line-height: 1;">HOROLOGY</span>
                            <span style="font-size: 0.58rem; letter-spacing: 1px; color: #94a3b8; line-height: 1; margin-top: 2px;">JAKARTA</span>
                        </div>
                    </a>
                </div>

                <!-- 2. Kolom Tengah: Segmented Capsule Nav (Anchor ke Center Layar) -->
                <div class="navbar-center-col">
                    <nav class="nav-capsule d-none d-md-flex">
                        <a href="{{ route('produk.index') }}" class="nav-capsule-link {{ request()->routeIs('produk.index') && !request()->hasAny(['kategori_id', 'merek_id']) ? 'active' : '' }}">
                            Beranda
                        </a>
                        <a href="{{ route('produk.katalog') }}" class="nav-capsule-link {{ request()->routeIs('produk.katalog') || request()->hasAny(['kategori_id', 'merek_id']) ? 'active' : '' }}">
                            Katalog
                        </a>
                        <a href="{{ Auth::check() ? route('pelanggan.beranda') : route('login') }}" class="nav-capsule-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
                            Pesanan
                        </a>
                    </nav>
                </div>

                <!-- 3. Kolom Kanan: Pencarian, Keranjang, Akun Sesuai Figma -->
                <div class="navbar-actions-col">
                    <a href="{{ route('produk.katalog') }}#searchSection" class="btn btn-light rounded-circle border-0 d-none d-sm-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" title="Cari Jam Tangan">
                        <i class="bi bi-search text-dark"></i>
                    </a>

                    <!-- Tombol Keranjang Belanja Bulat dengan Badge Sesuai Figma -->
                    <a href="{{ route('keranjang.index') }}" class="btn btn-light rounded-circle position-relative border d-flex align-items-center justify-content-center text-dark" style="width: 40px; height: 40px;" title="Keranjang Belanja">
                        <i class="bi bi-bag"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary fw-bold" style="font-size: 0.65rem; padding: 0.3em 0.5em;">
                            {{ $cartCount }}
                        </span>
                    </a>

                    <!-- User Account / Profil Sesuai Figma -->
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-light rounded-circle border d-flex align-items-center justify-content-center text-dark" style="width: 40px; height: 40px;" title="Masuk / Akun Saya">
                            <i class="bi bi-person fs-5"></i>
                        </a>
                    @else
                        <a href="{{ route('profil.show') }}" class="btn {{ request()->routeIs('profil.*') ? 'btn-primary text-white border-primary' : 'btn-light text-dark border' }} rounded-circle p-0 d-flex align-items-center justify-content-center overflow-hidden text-decoration-none" style="width: 40px; height: 40px;" title="Profil {{ Auth::user()->nama ?? Auth::user()->username }}">
                            <i class="bi bi-person-circle fs-5"></i>
                        </a>
                    @endguest
                </div>

            </div>
        </div>
    </header>

    <!-- Konten Utama -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- Footer Horologi Mewah Sesuai Mockup -->
    <footer class="footer-dark pt-5 pb-4 mt-5">
        <div class="container-fluid" style="max-width: 1440px; padding-left: clamp(1rem, 3.5vw, 2.5rem); padding-right: clamp(1rem, 3.5vw, 2.5rem);">
            <div class="row g-4 pb-4 border-bottom border-secondary border-opacity-25">
                
                <!-- Kolom 1: Brand & Filosofi -->
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <img src="{{ asset('images/logo-white.png') }}" alt="A1ORA" style="height: 34px; width: auto; object-fit: contain;">
                    </div>
                    <p class="small text-secondary mb-3 pe-lg-4" style="line-height: 1.6;">
                        Kurasi horologi presisi tinggi dan jam tangan mewah autentik untuk kolektor dan antusias terkemuka Indonesia. Standar pengerjaan Swiss dengan jaminan keaslian seumur hidup.
                    </p>
                    <div class="d-flex gap-2">
                        <span class="badge bg-secondary bg-opacity-25 text-white px-2.5 py-1.5 rounded-pill small">
                            <i class="bi bi-patch-check-fill text-primary me-1"></i> 100% Autentik
                        </span>
                        <span class="badge bg-secondary bg-opacity-25 text-white px-2.5 py-1.5 rounded-pill small">
                            <i class="bi bi-shield-check text-success me-1"></i> Bebas Asuransi
                        </span>
                    </div>
                </div>

                <!-- Kolom 2: Navigasi Koleksi -->
                <div class="col-6 col-lg-2">
                    <h6 class="fw-bold text-white text-uppercase small mb-3 tracking-wider">Koleksi</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2 mb-0">
                        <li><a href="{{ route('produk.katalog') }}">Katalog Lengkap</a></li>
                        <li><a href="{{ route('produk.katalog', ['q' => 'Automatic']) }}">Automatic Caliber</a></li>
                        <li><a href="{{ route('produk.katalog', ['q' => 'Classic']) }}">Chronograph Series</a></li>
                        <li><a href="{{ route('produk.katalog', ['q' => 'Analog']) }}">Dress Watches</a></li>
                    </ul>
                </div>

                <!-- Kolom 3: Layanan & Bantuan -->
                <div class="col-6 col-lg-3">
                    <h6 class="fw-bold text-white text-uppercase small mb-3 tracking-wider">Bantuan</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2 mb-0">
                        <li><a href="#">Butik Resmi Jakarta</a></li>
                        <li><a href="#">Garansi Internasional</a></li>
                        <li><a href="#">Autentikasi & Servis</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                    </ul>
                </div>

                <!-- Kolom 4: Newsletter / Warta Horologi -->
                <div class="col-lg-3">
                    <h6 class="fw-bold text-white text-uppercase small mb-3 tracking-wider">Warta Horologi</h6>
                    <p class="small text-secondary mb-3">
                        Dapatkan akses rilisan edisi terbatas dan kurasi eksklusif bulanan langsung ke email Anda.
                    </p>
                    <div class="input-group">
                        <input type="email" class="form-control form-control-sm bg-dark text-white border-secondary border-opacity-50" placeholder="Alamat surel Anda..." style="font-size: 0.8rem;">
                        <button class="btn btn-luxury-primary btn-sm px-3" type="button">
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright Bar -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-3 small text-secondary" style="font-size: 0.75rem;">
                <p class="mb-2 mb-md-0">&copy; {{ date('Y') }} A1ORA Watch. Hak Cipta Dilindungi. Horology Jakarta, Indonesia.</p>
                <p class="mb-0 text-secondary">JAKARTA PUSAT &bull; PLAZA SENAYAN LEVEL 3</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <x-popup-login />
    <x-konfirmasi-logout />

    @stack('scripts')
</body>
</html>
