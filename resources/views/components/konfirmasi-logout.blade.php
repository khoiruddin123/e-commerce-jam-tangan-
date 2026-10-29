@auth
@php
    $isAdminLogout = (Auth::user()->role ?? '') === 'admin';
@endphp

<style>
    .kronos-logout-backdrop {
        position: fixed;
        inset: 0;
        z-index: 10000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        background-color: rgba(11, 17, 32, 0.62);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        opacity: 0;
        transition: opacity 0.2s ease;
        font-family: 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, sans-serif;
    }
    .kronos-logout-backdrop.is-open {
        display: flex;
    }
    .kronos-logout-backdrop.is-visible {
        opacity: 1;
    }
    .kronos-logout-card {
        position: relative;
        width: 100%;
        max-width: 420px;
        background: #ffffff;
        border-radius: 1rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 20px 45px -12px rgba(15, 23, 42, 0.28);
        padding: 1.75rem 1.5rem 1.5rem;
        text-align: center;
        transform: translateY(10px);
        transition: transform 0.2s ease;
    }
    .kronos-logout-backdrop.is-visible .kronos-logout-card {
        transform: translateY(0);
    }
    .kronos-logout-icon-warn {
        width: 54px;
        height: 54px;
        border-radius: 9999px;
        background-color: #fef3c7;
        border: 1px solid #fde68a;
        color: #d97706;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.45rem;
        margin: 0 auto 1rem;
    }
    .kronos-logout-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 0.45rem;
        letter-spacing: -0.3px;
    }
    .kronos-logout-desc {
        font-size: 0.86rem;
        line-height: 1.55;
        color: #475569;
        margin: 0 0 1.4rem;
    }
    .kronos-logout-actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .kronos-logout-btn {
        flex: 1;
        border-radius: 0.75rem;
        font-weight: 700;
        font-size: 0.86rem;
        padding: 0.68rem 1rem;
        cursor: pointer;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
    }
    .kronos-logout-btn-cancel {
        background: #ffffff;
        color: #334155;
        border: 1.5px solid #cbd5e1;
    }
    .kronos-logout-btn-cancel:hover:not(:disabled) {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a;
    }
    .kronos-logout-btn-confirm {
        background: #e11d48;
        color: #ffffff;
        border: 1.5px solid #e11d48;
        box-shadow: 0 6px 16px -4px rgba(225, 29, 72, 0.38);
    }
    .kronos-logout-btn-confirm:hover:not(:disabled) {
        background: #be123c;
        border-color: #be123c;
    }
    .kronos-logout-btn:disabled {
        opacity: 0.65;
        cursor: not-allowed;
    }
    .kronos-logout-btn:focus-visible {
        outline: 2px solid #2563eb;
        outline-offset: 2px;
    }
    @media (prefers-reduced-motion: reduce) {
        .kronos-logout-backdrop,
        .kronos-logout-card {
            transition: none !important;
            transform: none !important;
        }
    }
</style>

<form id="kronosLogoutForm" method="POST" action="{{ route('logout') }}" style="display: none;">
    @csrf
</form>

<div id="kronosLogoutModal"
     class="kronos-logout-backdrop no-print"
     role="dialog"
     aria-modal="true"
     aria-labelledby="kronosLogoutTitle"
     aria-describedby="kronosLogoutDesc"
     aria-hidden="true">
    <div id="kronosLogoutCard" class="kronos-logout-card">
        <div class="kronos-logout-icon-warn" aria-hidden="true">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>

        <h3 id="kronosLogoutTitle" class="kronos-logout-title">Keluar dari akun?</h3>

        <p id="kronosLogoutDesc" class="kronos-logout-desc">
            @if($isAdminLogout)
                Anda akan keluar dari panel admin. Pastikan semua pekerjaan sudah tersimpan.
            @else
                Anda akan keluar dari sesi ini. Pastikan semua pekerjaan sudah tersimpan.
            @endif
        </p>

        <div class="kronos-logout-actions">
            <button type="button" id="kronosLogoutCancelBtn" class="kronos-logout-btn kronos-logout-btn-cancel">
                Batal
            </button>
            <button type="button" id="kronosLogoutConfirmBtn" class="kronos-logout-btn kronos-logout-btn-confirm">
                Ya, Keluar
            </button>
        </div>
    </div>
</div>

<script>
    (function () {
        if (window.__kronosLogoutInitialized) return;
        window.__kronosLogoutInitialized = true;

        const modal = document.getElementById('kronosLogoutModal');
        const form = document.getElementById('kronosLogoutForm');
        const cancelBtn = document.getElementById('kronosLogoutCancelBtn');
        const confirmBtn = document.getElementById('kronosLogoutConfirmBtn');

        if (!modal || !form || !cancelBtn || !confirmBtn) return;

        let isOpen = false;
        let isSubmitting = false;
        let lastTrigger = null;
        let previousBodyOverflow = '';

        function getFocusableElements() {
            return Array.prototype.slice.call(
                modal.querySelectorAll('button:not([disabled]), [href], input:not([disabled]), [tabindex]:not([tabindex="-1"])')
            );
        }

        function openLogoutModal(triggerEl) {
            if (isOpen) return;
            isOpen = true;
            lastTrigger = triggerEl || document.activeElement;
            previousBodyOverflow = document.body.style.overflow;
            document.body.style.overflow = 'hidden';

            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');

            requestAnimationFrame(function () {
                modal.classList.add('is-visible');
                cancelBtn.focus();
            });
        }

        function closeLogoutModal() {
            if (!isOpen || isSubmitting) return;
            isOpen = false;
            modal.classList.remove('is-visible');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = previousBodyOverflow;

            setTimeout(function () {
                if (!isOpen) {
                    modal.classList.remove('is-open');
                }
            }, 200);

            if (lastTrigger && typeof lastTrigger.focus === 'function') {
                lastTrigger.focus();
            }
        }

        // Event delegation untuk semua tombol [data-logout-trigger]
        document.addEventListener('click', function (e) {
            const trigger = e.target.closest('[data-logout-trigger]');
            if (trigger) {
                e.preventDefault();
                openLogoutModal(trigger);
                return;
            }

            if (isOpen && e.target === modal) {
                closeLogoutModal();
            }
        });

        cancelBtn.addEventListener('click', function () {
            closeLogoutModal();
        });

        confirmBtn.addEventListener('click', function () {
            if (isSubmitting) return;
            isSubmitting = true;
            confirmBtn.disabled = true;
            cancelBtn.disabled = true;
            confirmBtn.textContent = 'Memproses...';
            form.submit();
        });

        document.addEventListener('keydown', function (e) {
            if (!isOpen) return;

            if (e.key === 'Escape') {
                e.preventDefault();
                closeLogoutModal();
                return;
            }

            if (e.key === 'Tab') {
                const focusables = getFocusableElements();
                if (focusables.length === 0) {
                    e.preventDefault();
                    return;
                }
                const first = focusables[0];
                const last = focusables[focusables.length - 1];

                if (e.shiftKey) {
                    if (document.activeElement === first || !modal.contains(document.activeElement)) {
                        e.preventDefault();
                        last.focus();
                    }
                } else {
                    if (document.activeElement === last || !modal.contains(document.activeElement)) {
                        e.preventDefault();
                        first.focus();
                    }
                }
            }
        });
    })();
</script>
@endauth

