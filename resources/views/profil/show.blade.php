@extends('layouts.app')

@section('title', 'Profil Saya - Kronos Watch')

@section('content')
@php
    $namaUsername = $user->username ?: $user->nama;
    $inisial = mb_strtoupper(mb_substr(trim($user->nama ?: $user->username), 0, 1));
    $tanggalBergabung = $user->created_at
        ? \Carbon\Carbon::parse($user->created_at)->locale('id')->translatedFormat('d F Y')
        : '-';
    $hasProfileErrors = $errors->hasAny(['nama_username', 'email', 'no_telepon', 'alamat']);
@endphp

<style>
    .profile-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1.25rem;
        box-shadow: 0 4px 20px -4px rgba(15, 23, 42, 0.05);
    }
    .profile-info-item {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 0.875rem;
        padding: 0.875rem 1.125rem;
    }
    .profile-form-control {
        border-radius: 0.75rem;
        border: 1px solid #cbd5e1;
        padding: 0.65rem 0.95rem;
        font-size: 0.9rem;
        background-color: #f8fafc;
        transition: all 0.2s ease;
    }
    .profile-form-control:focus {
        background-color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }
    .profile-form-control:disabled,
    .profile-form-control[readonly] {
        background-color: #f1f5f9;
        color: #64748b;
        cursor: not-allowed;
    }
</style>

<div class="container py-4">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('produk.index') }}" class="text-decoration-none text-secondary">Beranda</a>
            </li>
            <li class="breadcrumb-item active fw-semibold text-dark" aria-current="page">Profil Pelanggan</li>
        </ol>
    </nav>

    <!-- Flash Message Sukses -->
    @if(session('success'))
        <div class="alert alert-success border-0 rounded-4 shadow-sm d-flex align-items-center justify-content-between py-3 px-4 mb-4"
             style="background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0 !important;">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                <span class="fw-semibold small">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- 1. KARTU HEADER PROFIL (Dark Luxury Navy Kehitaman seperti Hero Beranda) -->
    <div class="rounded-5 overflow-hidden shadow-lg p-4 p-md-5 mb-4 text-white position-relative"
         style="background: radial-gradient(circle at 80% 25%, #1e293b 0%, #090e17 100%); border: 1px solid rgba(255,255,255,0.08);">

        <div class="row align-items-center g-4">
            <div class="col-md-8">
                <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-3 gap-sm-4">
                    <!-- Avatar Huruf Pertama Nama -->
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bolder text-white flex-shrink-0 shadow-lg"
                         style="width: 84px; height: 84px; font-size: 2.1rem; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); border: 3px solid rgba(255,255,255,0.2);">
                        {{ $inisial }}
                    </div>

                    <div>
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                            <span class="badge rounded-pill px-3 py-1 fw-bold text-uppercase"
                                  style="background: rgba(37, 99, 235, 0.25); color: #60a5fa; border: 1px solid rgba(96, 165, 250, 0.35); font-size: 0.7rem; letter-spacing: 0.8px;">
                                <i class="bi bi-shield-check me-1"></i> {{ ucfirst($user->role) }}
                            </span>
                            <span class="text-white-50 small" style="font-size: 0.8rem;">
                                <i class="bi bi-calendar3 me-1"></i> Bergabung {{ $tanggalBergabung }}
                            </span>
                        </div>

                        <h2 class="fw-bolder text-white mb-1" style="letter-spacing: -0.6px;">
                            {{ $user->nama ?: $user->username }}
                        </h2>

                        <div class="d-flex flex-wrap align-items-center gap-3 text-white-50 small">
                            @if(!empty($user->username) && $user->username !== $user->nama)
                                <span>
                                    <i class="bi bi-at text-primary"></i>{{ $user->username }}
                                </span>
                                <span>&bull;</span>
                            @endif
                            <span>
                                <i class="bi bi-envelope me-1 text-primary"></i>{{ $user->email }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Link Cepat Pesanan Saya & Tombol Keluar -->
            <div class="col-md-4">
                <div class="d-flex flex-wrap justify-content-md-end gap-2">
                    <a href="{{ route('pelanggan.pesanan') }}"
                       class="btn btn-light rounded-pill px-3.5 py-2 fw-bold text-dark d-inline-flex align-items-center gap-2 shadow-sm"
                       style="font-size: 0.84rem;">
                        <i class="bi bi-bag-check-fill text-primary"></i>
                        <span>Pesanan Saya</span>
                    </a>

                    <button type="button"
                            data-logout-trigger
                            class="btn btn-outline-light rounded-pill px-3.5 py-2 fw-bold d-inline-flex align-items-center gap-2"
                            style="font-size: 0.84rem; border-color: rgba(255,255,255,0.25);">
                        <i class="bi bi-box-arrow-right text-danger"></i>
                        <span>Keluar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. KONTEN UTAMA: INFORMASI AKUN & UBAH PASSWORD -->
    <div class="row g-4">

        <!-- Kolom Kiri: Informasi Akun & Mode Edit Profil -->
        <div class="col-lg-7">
            <div class="profile-card p-4 p-md-4 h-100">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 pb-3 mb-4 border-bottom">
                    <div>
                        <span class="text-primary fw-bold text-uppercase d-block" style="font-size: 0.7rem; letter-spacing: 1px;">
                            DATA PERSONAL
                        </span>
                        <h5 class="fw-bolder text-dark mb-0">Informasi Akun</h5>
                    </div>

                    <button type="button" id="btnToggleEdit" onclick="toggleEditProfil()"
                            class="btn btn-luxury-primary rounded-pill px-3.5 py-2 small d-inline-flex align-items-center gap-1.5"
                            style="font-size: 0.82rem;">
                        <i class="bi {{ $hasProfileErrors ? 'bi-x-lg' : 'bi-pencil-square' }}" id="iconToggleEdit"></i>
                        <span id="textToggleEdit">{{ $hasProfileErrors ? 'Tutup Edit' : 'Edit Profil' }}</span>
                    </button>
                </div>

                <!-- Tampilan Informasi Akun (Mode Baca) -->
                <div id="viewProfilSection" class="{{ $hasProfileErrors ? 'd-none' : '' }}">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="profile-info-item h-100">
                                <span class="text-muted d-block small mb-1" style="font-size: 0.75rem;">Nama / Username</span>
                                <div class="fw-bold text-dark" style="font-size: 0.92rem;">{{ $namaUsername }}</div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="profile-info-item h-100">
                                <span class="text-muted d-block small mb-1" style="font-size: 0.75rem;">Alamat Email</span>
                                <div class="fw-bold text-dark text-break" style="font-size: 0.92rem;">{{ $user->email }}</div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="profile-info-item h-100">
                                <span class="text-muted d-block small mb-1" style="font-size: 0.75rem;">Nomor Telepon</span>
                                @if(!empty($user->no_telepon))
                                    <div class="fw-bold text-dark" style="font-size: 0.92rem;">{{ $user->no_telepon }}</div>
                                @else
                                    <div class="fst-italic text-secondary" style="font-size: 0.88rem;">Belum diisi</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="profile-info-item">
                                <span class="text-muted d-block small mb-1" style="font-size: 0.75rem;">Alamat Pengiriman Utama</span>
                                @if(!empty($user->alamat))
                                    <div class="fw-semibold text-dark" style="font-size: 0.92rem; line-height: 1.5;">{{ $user->alamat }}</div>
                                @else
                                    <div class="fst-italic text-secondary" style="font-size: 0.88rem;">Belum diisi</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Edit Profil (Mode Edit) -->
                <div id="editProfilSection" class="{{ $hasProfileErrors ? '' : 'd-none' }}">
                    <form action="{{ route('profil.update') }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="nama_username" class="form-label fw-bold small text-dark mb-1">
                                    Nama / Username <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="nama_username" name="nama_username"
                                       value="{{ old('nama_username', $namaUsername) }}"
                                       class="form-control profile-form-control @error('nama_username') is-invalid @enderror"
                                       placeholder="Nama atau username Anda" required>
                                <small class="text-muted d-block mt-1" style="font-size: 0.72rem;">Huruf, angka, titik, atau underscore. Dipakai untuk login.</small>
                                @error('nama_username')
                                    <div class="invalid-feedback d-block small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label for="email" class="form-label fw-bold small text-dark mb-1">
                                    Alamat Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" id="email" name="email"
                                       value="{{ old('email', $user->email) }}"
                                       class="form-control profile-form-control @error('email') is-invalid @enderror"
                                       placeholder="nama@email.com" required>
                                @error('email')
                                    <div class="invalid-feedback d-block small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label for="no_telepon" class="form-label fw-bold small text-dark mb-1">
                                    Nomor Telepon
                                </label>
                                <input type="text" id="no_telepon" name="no_telepon"
                                       value="{{ old('no_telepon', $user->no_telepon) }}"
                                       class="form-control profile-form-control @error('no_telepon') is-invalid @enderror"
                                       placeholder="Contoh: +62 812 3456 7890">
                                @error('no_telepon')
                                    <div class="invalid-feedback d-block small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="alamat" class="form-label fw-bold small text-dark mb-1">
                                    Alamat Lengkap
                                </label>
                                <textarea id="alamat" name="alamat" rows="3"
                                          class="form-control profile-form-control @error('alamat') is-invalid @enderror"
                                          placeholder="Masukkan alamat lengkap pengiriman jam tangan Anda...">{{ old('alamat', $user->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback d-block small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-2 border-top">
                            <button type="button" onclick="toggleEditProfil()"
                                    class="btn btn-light border rounded-pill px-4 py-2 fw-semibold small">
                                Batal
                            </button>
                            <button type="submit"
                                    class="btn btn-luxury-primary rounded-pill px-4 py-2 small d-inline-flex align-items-center gap-1.5">
                                <i class="bi bi-check2-circle"></i>
                                <span>Simpan Perubahan</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <!-- Kolom Kanan: Ubah Password & Akses Cepat -->
        <div class="col-lg-5">
            <div class="d-flex flex-column gap-4 h-100">

                <!-- Kartu Ubah Password -->
                <div class="profile-card p-4">
                    <div class="pb-3 mb-3 border-bottom">
                        <span class="text-primary fw-bold text-uppercase d-block" style="font-size: 0.7rem; letter-spacing: 1px;">
                            KEAMANAN AKUN
                        </span>
                        <h5 class="fw-bolder text-dark mb-0">Ubah Password</h5>
                    </div>

                    <form action="{{ route('profil.password') }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="password_lama" class="form-label fw-bold small text-dark mb-1">
                                Password Lama <span class="text-danger">*</span>
                            </label>
                            <input type="password" id="password_lama" name="password_lama"
                                   class="form-control profile-form-control @error('password_lama') is-invalid @enderror"
                                   placeholder="Masukkan password saat ini" required>
                            @error('password_lama')
                                <div class="invalid-feedback d-block small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_baru" class="form-label fw-bold small text-dark mb-1">
                                Password Baru <span class="text-danger">*</span>
                            </label>
                            <input type="password" id="password_baru" name="password_baru"
                                   class="form-control profile-form-control @error('password_baru') is-invalid @enderror"
                                   placeholder="Minimal 8 karakter" required>
                            @error('password_baru')
                                <div class="invalid-feedback d-block small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_baru_confirmation" class="form-label fw-bold small text-dark mb-1">
                                Konfirmasi Password Baru <span class="text-danger">*</span>
                            </label>
                            <input type="password" id="password_baru_confirmation" name="password_baru_confirmation"
                                   class="form-control profile-form-control"
                                   placeholder="Ulangi password baru" required>
                        </div>

                        <button type="submit"
                                class="btn btn-luxury-primary w-100 rounded-pill py-2.5 small d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-shield-lock-fill"></i>
                            <span>Perbarui Password</span>
                        </button>
                    </form>
                </div>

                <!-- Kartu Pintasan Akun -->
                <div class="profile-card p-4">
                    <span class="text-primary fw-bold text-uppercase d-block mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">
                        NAVIGASI CEPAT
                    </span>
                    <h6 class="fw-bolder text-dark mb-3">Aktivitas & Sesi</h6>

                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('pelanggan.pesanan') }}"
                           class="d-flex align-items-center justify-content-between p-3 rounded-4 text-decoration-none border bg-light-subtle"
                           style="border-color: #e2e8f0 !important;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 38px; height: 38px; background: #eff6ff; color: #2563eb;">
                                    <i class="bi bi-bag-check-fill"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark small">Pesanan Saya</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">Lihat status pengiriman & riwayat transaksi</div>
                                </div>
                            </div>
                            <i class="bi bi-chevron-right text-secondary"></i>
                        </a>

                        <button type="button"
                                data-logout-trigger
                                class="w-100 d-flex align-items-center justify-content-between p-3 rounded-4 border bg-white text-start"
                                style="border-color: #fecdd3 !important;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 38px; height: 38px; background: #fff1f2; color: #e11d48;">
                                    <i class="bi bi-box-arrow-right"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-danger small">Keluar dari Akun</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">Akhiri sesi login Anda saat ini</div>
                                </div>
                            </div>
                            <i class="bi bi-chevron-right text-danger"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

<script>
    function toggleEditProfil() {
        const viewSection = document.getElementById('viewProfilSection');
        const editSection = document.getElementById('editProfilSection');
        const textBtn = document.getElementById('textToggleEdit');
        const iconBtn = document.getElementById('iconToggleEdit');

        const isEditing = !editSection.classList.contains('d-none');

        if (isEditing) {
            editSection.classList.add('d-none');
            viewSection.classList.remove('d-none');
            textBtn.textContent = 'Edit Profil';
            iconBtn.className = 'bi bi-pencil-square';
        } else {
            viewSection.classList.add('d-none');
            editSection.classList.remove('d-none');
            textBtn.textContent = 'Tutup Edit';
            iconBtn.className = 'bi bi-x-lg';
        }
    }
</script>
@endsection

