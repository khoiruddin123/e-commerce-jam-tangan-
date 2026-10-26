<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Jam Tangan')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .product-card { transition: transform 0.2s; }
        .product-card:hover { transform: translateY(-4px); }
    </style>
</head>
<body>

    <!-- Navbar Sederhana -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('produk.index') }}">
                <i class="bi bi-watch me-1"></i> KRONOS WATCH
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('produk.index') }}">Katalog Produk</a>
                    </li>
                </ul>
                 <!-- Menu Kanan: Keranjang & Akun -->
                <div class="d-flex align-items-center gap-2">
                    <a href="#" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-cart3"></i> Keranjang
                    </a>

                    @guest
                        <!-- Tautan jika belum login -->
                        <a href="{{ route('login') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                        </a>
                    @else
                        <!-- Dropdown jika sudah login -->
                        <div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person me-1"></i> {{ Auth::user()->nama ?? Auth::user()->username }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                <li><span class="dropdown-item-text small text-muted">Role: {{ ucfirst(Auth::user()->role ?? 'Pelanggan') }}</span></li>
                                <li><hr class="dropdown-divider"></li>
                                @if(Auth::user()->role === 'admin')
                                    <li>
                                        <a href="{{ route('admin.dashboard') }}" class="dropdown-item small">
                                            <i class="bi bi-speedometer2 me-1"></i> Dashboard Admin
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ route('pelanggan.beranda') }}" class="dropdown-item small">
                                            <i class="bi bi-bag-check me-1"></i> Riwayat Pesanan Saya
                                        </a>
                                    </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger small">
                                            <i class="bi bi-box-arrow-right me-1"></i> Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
    <main class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-top py-3 text-center text-muted small mt-5">
        <div class="container">
            &copy; {{ date('Y') }} Kronos Watch - Proyek Sistem Informasi Toko Jam Tangan
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
