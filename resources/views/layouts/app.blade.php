<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kronos Watch - Horology Jakarta')</title>

    <!-- Google Fonts Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            /* Gradasi biru muda lembut (Ice Blue Ambient) */
            background: linear-gradient(180deg, #edf4fe 0%, #f3f7fd 340px, #f8fafc 100%);
            background-attachment: fixed;
            color: #1e293b;
        }
        .top-navbar {
            background-color: rgba(255, 255, 255, 0.92) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .navbar-brand-title {
            font-size: 1.15rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            line-height: 1.1;
        }
        .navbar-brand-sub {
            font-size: 0.65rem;
            letter-spacing: 1.5px;
            font-weight: 600;
            color: #94a3b8;
        }
        .nav-capsule {
            background-color: #f1f5f9;
            border-radius: 9999px;
            padding: 4px;
            display: inline-flex;
            gap: 4px;
        }
        .nav-capsule-link {
            padding: 6px 18px;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #64748b;
            text-decoration: none;
            transition: all 0.2s ease;
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

    <!-- Top Navbar Sesuai Mockup -->
    <header class="top-navbar border-bottom sticky-top py-2 shadow-sm">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">

                <!-- Logo & Brand Title -->
                <a class="d-flex align-items-center gap-2 text-decoration-none text-dark" href="{{ route('produk.index') }}">
                    <div class="bg-dark text-white rounded-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="bi bi-watch fs-5"></i>
                    </div>
                    <div>
                        <div class="navbar-brand-title">KRONOS WATCH</div>
                        <div class="navbar-brand-sub">HOROLOGY JAKARTA</div>
                    </div>
                </a>

                <!-- Segmented Capsule Nav (Tengah) -->
                <nav class="nav-capsule d-none d-md-flex">
                    <a href="{{ route('produk.index') }}" class="nav-capsule-link {{ request()->routeIs('produk.index') && !request()->hasAny(['kategori_id', 'merek_id']) ? 'active' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('produk.katalog') }}" class="nav-capsule-link {{ request()->routeIs('produk.katalog') || request()->hasAny(['kategori_id', 'merek_id']) ? 'active' : '' }}">
                        Katalog
                    </a>
                    @auth
                        <a href="{{ route('pelanggan.beranda') }}" class="nav-capsule-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
                            Pesanan
                        </a>
                    @endauth
                </nav>

                <!-- Icon Kanan: Pencarian, Keranjang Belanja, & Akun -->
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('produk.katalog') }}#searchSection" class="btn btn-light rounded-circle border-0 d-none d-sm-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" title="Cari Jam Tangan">
                        <i class="bi bi-search text-dark"></i>
                    </a>

                    <!-- Tombol Keranjang Belanja dengan Badge -->
                    <a href="{{ route('keranjang.index') }}" class="btn btn-light rounded-pill position-relative px-3 py-2 border d-flex align-items-center gap-2 text-decoration-none text-dark" title="Keranjang Belanja">
                        <i class="bi bi-bag"></i>
                        @if($cartCount > 0)
                            <span class="badge bg-primary rounded-pill fw-bold" style="font-size: 0.75rem;">{{ $cartCount }}</span>
                        @endif
                    </a>

                    <!-- User Account Dropdown -->
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-dark rounded-pill px-3 py-1.5 fw-semibold small">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                        </a>
                    @else
                        <div class="dropdown">
                            <button class="btn btn-light rounded-circle border p-0 d-flex align-items-center justify-content-center overflow-hidden" type="button" data-bs-toggle="dropdown" style="width: 40px; height: 40px;" title="{{ Auth::user()->nama ?? Auth::user()->username }}">
                                <i class="bi bi-person-circle fs-4 text-dark"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-2 p-2" style="min-width: 220px;">
                                <li class="px-3 py-2 border-bottom">
                                    <span class="fw-bold d-block text-dark small">{{ Auth::user()->nama ?? Auth::user()->username }}</span>
                                    <span class="text-muted small" style="font-size: 0.75rem;">Role: {{ ucfirst(Auth::user()->role ?? 'Pelanggan') }}</span>
                                </li>
                                @if(Auth::user()->role === 'admin')
                                    <li>
                                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item rounded-2 py-2 small mt-1">
                                            <i class="bi bi-speedometer2 me-2 text-primary"></i> Dashboard Admin
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ route('pelanggan.beranda') }}" class="dropdown-item rounded-2 py-2 small mt-1">
                                            <i class="bi bi-bag-check me-2 text-success"></i> Riwayat Pesanan Saya
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ route('keranjang.index') }}" class="dropdown-item rounded-2 py-2 small">
                                        <i class="bi bi-cart3 me-2 text-info"></i> Keranjang Saya
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item rounded-2 py-2 text-danger small">
                                            <i class="bi bi-box-arrow-right me-2"></i> Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
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
        <div class="container">
            <div class="row g-4 pb-4 border-bottom border-secondary border-opacity-25">
                
                <!-- Kolom 1: Brand & Filosofi -->
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="bg-white text-dark rounded-3 d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                            <i class="bi bi-watch fs-5"></i>
                        </div>
                        <div>
                            <span class="fw-bold text-white fs-6 tracking-wide d-block">KRONOS WATCH</span>
                            <span class="text-secondary small" style="font-size: 0.65rem; letter-spacing: 1.5px;">HOROLOGY JAKARTA</span>
                        </div>
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
                <p class="mb-2 mb-md-0">&copy; {{ date('Y') }} Kronos Watch. Hak Cipta Dilindungi. Horology Jakarta, Indonesia.</p>
                <p class="mb-0 text-secondary">JAKARTA PUSAT &bull; PLAZA SENAYAN LEVEL 3</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
