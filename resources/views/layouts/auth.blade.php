<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Autentikasi - Kronos Watch')</title>

    <!-- Google Fonts: Plus Jakarta Sans (Sama dengan Beranda) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --kronos-blue: #2563eb;
            --kronos-blue-hover: #1d4ed8;
            --kronos-navy: #0b1120;
            --kronos-navy-card: #131c31;
            --kronos-input-bg: #eef2ff;
            --kronos-input-border: #dbe4ff;
            --kronos-error-bg: #fff1f2;
            --kronos-error-border: #fda4af;
            --kronos-error-text: #e11d48;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
        }

        /* Top Bar 56px */
        .auth-topbar {
            height: 56px;
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .brand-box-blue {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
        }

        .brand-title {
            font-size: 1rem;
            font-weight: 800;
            letter-spacing: -0.4px;
            line-height: 1.05;
            color: #0f172a;
        }

        .brand-subtitle {
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 1.4px;
            color: #94a3b8;
            text-transform: uppercase;
        }

        .back-store-link {
            font-size: 0.82rem;
            font-weight: 600;
            color: #475569;
            text-decoration: none;
            padding: 6px 14px;
            border-radius: 9999px;
            background-color: #f1f5f9;
            transition: all 0.2s ease;
        }

        .back-store-link:hover {
            background-color: #e2e8f0;
            color: #0f172a;
        }

        /* Split Screen Wrapper */
        .auth-split-wrapper {
            flex: 1;
            display: flex;
            min-height: calc(100vh - 56px);
        }

        /* Panel Kiri (~42%) */
        .auth-left-panel {
            width: 42%;
            background:
                radial-gradient(circle at 20% 20%, rgba(37, 99, 235, 0.22) 0%, transparent 48%),
                radial-gradient(circle at 85% 80%, rgba(59, 130, 246, 0.16) 0%, transparent 50%),
                linear-gradient(160deg, #0b1120 0%, #111827 55%, #0f172a 100%);
            color: #ffffff;
            padding: 2.5rem 2.75rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        /* Panel Kanan (Sisa lebar ~58%) */
        .auth-right-panel {
            flex: 1;
            background: linear-gradient(180deg, #f8faff 0%, #ffffff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.25rem 1.25rem;
        }

        .auth-form-container {
            width: 100%;
            max-width: 420px;
        }

        /* Input Styling (Biru-Lavender Muda) */
        .auth-input-group {
            position: relative;
            display: flex;
            align-items: center;
            background-color: var(--kronos-input-bg);
            border: 1.5px solid var(--kronos-input-border);
            border-radius: 14px;
            transition: all 0.2s ease;
        }

        .auth-input-group:focus-within {
            background-color: #ffffff;
            border-color: var(--kronos-blue);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .auth-input-group.is-error {
            background-color: var(--kronos-error-bg);
            border-color: var(--kronos-error-border);
        }

        .auth-input-group.is-error:focus-within {
            background-color: #fff5f6;
            border-color: var(--kronos-error-text);
            box-shadow: 0 0 0 4px rgba(225, 29, 72, 0.12);
        }

        .auth-input-icon {
            padding-left: 14px;
            padding-right: 10px;
            color: #64748b;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            pointer-events: none;
        }

        .auth-input-group.is-error .auth-input-icon {
            color: var(--kronos-error-text);
        }

        .auth-input {
            width: 100%;
            border: none;
            background: transparent;
            padding: 11px 14px 11px 0;
            font-size: 0.86rem;
            font-weight: 500;
            color: #0f172a;
            outline: none;
        }

        .auth-input::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        .auth-input-suffix {
            padding-right: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-eye-toggle {
            background: none;
            border: none;
            color: #64748b;
            padding: 2px 4px;
            cursor: pointer;
            font-size: 0.95rem;
            line-height: 1;
        }

        .btn-eye-toggle:hover {
            color: #0f172a;
        }

        /* Tombol Utama Pill Biru Royal */
        .btn-auth-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff;
            border: none;
            border-radius: 9999px;
            padding: 12px 24px;
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: 0.2px;
            box-shadow: 0 8px 20px -4px rgba(37, 99, 235, 0.45);
            transition: all 0.2s ease;
        }

        .btn-auth-primary:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 12px 24px -4px rgba(37, 99, 235, 0.55);
        }

        /* Showcase Kartu Jam di Panel Kiri */
        .watch-showcase-card {
            border-radius: 22px;
            background: radial-gradient(circle at 50% 35%, rgba(37, 99, 235, 0.28) 0%, rgba(15, 23, 42, 0.92) 75%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
            position: relative;
            min-height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.6);
        }

        .glass-feature-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.09);
            border-radius: 18px;
            backdrop-filter: blur(10px);
        }

        .btn-social-disabled {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 10px 14px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #475569;
            opacity: 0.75;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

    <!-- Top Bar Putih Setinggi ~56px -->
    <header class="auth-topbar d-flex align-items-center">
        <div class="container-fluid px-3 px-lg-5 d-flex justify-content-between align-items-center">
            <!-- Kiri: Logo Kotak Biru Membulat + KRONOS & HOROLOGY JAKARTA -->
            <a href="{{ route('produk.index') }}" class="d-flex align-items-center gap-2.5 text-decoration-none">
                <div class="brand-box-blue me-2">
                    <i class="bi bi-watch fs-6"></i>
                </div>
                <div>
                    <div class="brand-title">KRONOS</div>
                    <div class="brand-subtitle">HOROLOGY JAKARTA</div>
                </div>
            </a>

            <!-- Kanan: Link Kembali ke Toko -->
            <a href="{{ route('produk.index') }}" class="back-store-link d-inline-flex align-items-center gap-1">
                <span>&larr; Kembali ke Toko</span>
            </a>
        </div>
    </header>

    <!-- Layar Terbagi Dua (Panel Kiri 42% di lg+, Panel Kanan Sisa Lebar) -->
    <main class="auth-split-wrapper">
        <!-- Panel Kiri: Gelap Navy-Keabuan dengan Glow Biru (Disembunyikan di bawah lg) -->
        <aside class="auth-left-panel d-none d-lg-flex">
            @yield('left_panel')
        </aside>

        <!-- Panel Kanan: Form di Tengah (Max-width ~420px) -->
        <section class="auth-right-panel">
            <div class="auth-form-container">
                @yield('right_panel')
            </div>
        </section>
    </main>

    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (!input || !icon) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }
    </script>
    @stack('scripts')
</body>
</html>

