@if(session('login_success'))
@php
    $loginData = session('login_success');
    $namaUser = is_array($loginData)
        ? ($loginData['nama'] ?? (Auth::user()->nama ?? 'Pengguna'))
        : (Auth::user()->nama ?? 'Pengguna');
    $roleUser = is_array($loginData)
        ? ($loginData['role'] ?? (Auth::user()->role ?? 'pelanggan'))
        : (Auth::user()->role ?? 'pelanggan');
    $isAdmin = $roleUser === 'admin';
@endphp

<style>
    .kronos-popup-backdrop {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        background-color: rgba(11, 17, 32, 0.62);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        opacity: 0;
        transition: opacity 0.22s ease;
        font-family: 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, sans-serif;
    }
    .kronos-popup-backdrop.is-visible {
        opacity: 1;
    }
    .kronos-popup-card {
        position: relative;
        width: 100%;
        max-width: 420px;
        background: #ffffff;
        border-radius: 1rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 20px 45px -12px rgba(15, 23, 42, 0.28);
        padding: 1.75rem 1.5rem 1.5rem;
        text-align: center;
        overflow: hidden;
        transform: translateY(10px);
        transition: transform 0.22s ease;
    }
    .kronos-popup-backdrop.is-visible .kronos-popup-card {
        transform: translateY(0);
    }
    .kronos-popup-close {
        position: absolute;
        top: 0.875rem;
        right: 0.875rem;
        width: 32px;
        height: 32px;
        border-radius: 9999px;
        border: none;
        background: transparent;
        color: #94a3b8;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.15s ease, color 0.15s ease;
    }
    .kronos-popup-close:hover {
        background-color: #f1f5f9;
        color: #0f172a;
    }
    .kronos-popup-icon-success {
        width: 56px;
        height: 56px;
        border-radius: 9999px;
        background-color: #dcfce7;
        border: 1px solid #bbf7d0;
        color: #16a34a;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        margin: 0 auto 1rem;
    }
    .kronos-popup-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 0.45rem;
        letter-spacing: -0.3px;
    }
    .kronos-popup-desc {
        font-size: 0.875rem;
        line-height: 1.55;
        color: #475569;
        margin: 0 0 1.35rem;
    }
    .kronos-popup-btn-primary {
        width: 100%;
        border: none;
        border-radius: 0.75rem;
        background: #2563eb;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.875rem;
        padding: 0.7rem 1.25rem;
        cursor: pointer;
        box-shadow: 0 6px 16px -4px rgba(37, 99, 235, 0.4);
        transition: background-color 0.15s ease;
    }
    .kronos-popup-btn-primary:hover {
        background: #1d4ed8;
    }
    .kronos-popup-btn-primary:focus-visible,
    .kronos-popup-close:focus-visible {
        outline: 2px solid #2563eb;
        outline-offset: 2px;
    }
    .kronos-popup-progress-track {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 4px;
        background-color: #e2e8f0;
        overflow: hidden;
    }
    .kronos-popup-progress-bar {
        height: 100%;
        width: 100%;
        background: linear-gradient(90deg, #2563eb 0%, #3b82f6 100%);
        transform-origin: left center;
        transform: scaleX(1);
    }
    @media (prefers-reduced-motion: reduce) {
        .kronos-popup-backdrop,
        .kronos-popup-card {
            transition: none !important;
            transform: none !important;
        }
    }
</style>

<div id="kronosLoginPopup"
     class="kronos-popup-backdrop no-print"
     role="dialog"
     aria-modal="true"
     aria-labelledby="kronosLoginPopupTitle"
     aria-describedby="kronosLoginPopupDesc">
    <div id="kronosLoginPopupCard" class="kronos-popup-card">
        <button type="button"
                id="kronosLoginPopupClose"
                class="kronos-popup-close"
                aria-label="Tutup">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="kronos-popup-icon-success" aria-hidden="true">
            <i class="bi bi-check-lg"></i>
        </div>

        <h3 id="kronosLoginPopupTitle" class="kronos-popup-title">Login Berhasil</h3>

        <p id="kronosLoginPopupDesc" class="kronos-popup-desc">
            @if($isAdmin)
                Selamat datang, <strong>{{ $namaUser }}</strong>. Anda masuk sebagai Admin.
            @else
                Selamat datang kembali, <strong>{{ $namaUser }}</strong>! Selamat berbelanja di A1ORA Watch.
            @endif
        </p>

        <button type="button" id="kronosLoginPopupAction" class="kronos-popup-btn-primary">
            Lanjutkan
        </button>

        <div class="kronos-popup-progress-track" aria-hidden="true">
            <div id="kronosLoginPopupProgress" class="kronos-popup-progress-bar"></div>
        </div>
    </div>
</div>

<script>
    (function () {
        const backdrop = document.getElementById('kronosLoginPopup');
        const card = document.getElementById('kronosLoginPopupCard');
        const closeBtn = document.getElementById('kronosLoginPopupClose');
        const actionBtn = document.getElementById('kronosLoginPopupAction');
        const progressBar = document.getElementById('kronosLoginPopupProgress');

        if (!backdrop || !card) return;

        const duration = 3000;
        let remaining = duration;
        let lastTick = performance.now();
        let paused = false;
        let closed = false;
        let rafId = null;

        requestAnimationFrame(function () {
            backdrop.classList.add('is-visible');
            if (actionBtn) actionBtn.focus();
        });

        function closePopup() {
            if (closed) return;
            closed = true;
            if (rafId) cancelAnimationFrame(rafId);
            backdrop.classList.remove('is-visible');
            setTimeout(function () {
                if (backdrop.parentNode) {
                    backdrop.parentNode.removeChild(backdrop);
                }
            }, 220);
        }

        function tick(now) {
            if (closed) return;
            if (!paused) {
                const delta = now - lastTick;
                remaining = Math.max(0, remaining - delta);
                if (progressBar) {
                    progressBar.style.transform = 'scaleX(' + (remaining / duration) + ')';
                }
                if (remaining <= 0) {
                    closePopup();
                    return;
                }
            }
            lastTick = now;
            rafId = requestAnimationFrame(tick);
        }

        rafId = requestAnimationFrame(tick);

        card.addEventListener('mouseenter', function () {
            paused = true;
        });

        card.addEventListener('mouseleave', function () {
            paused = false;
            lastTick = performance.now();
        });

        if (closeBtn) closeBtn.addEventListener('click', closePopup);
        if (actionBtn) actionBtn.addEventListener('click', closePopup);

        backdrop.addEventListener('click', function (e) {
            if (e.target === backdrop) {
                closePopup();
            }
        });

        document.addEventListener('keydown', function onKeyDown(e) {
            if (closed) {
                document.removeEventListener('keydown', onKeyDown);
                return;
            }
            if (e.key === 'Escape') {
                e.preventDefault();
                closePopup();
            }
        });
    })();
</script>
@endif

