@extends('layouts.app')

@section('title', 'Masuk - Kronos Watch')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-5 col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <i class="bi bi-person-circle display-4 text-dark"></i>
                    <h4 class="fw-bold mt-2">Masuk Akun</h4>
                    <p class="text-muted small">Silakan masuk untuk melanjutkan belanja</p>
                </div>

                <form action="{{ route('login.proses') }}" method="POST">
                    @csrf

                  <!-- Input Email atau Username -->
                 <div class="mb-3">
                     <label for="login" class="form-label small fw-semibold">Email atau Username</label>
                     <input type="text" 
                            name="login" 
                            id="login" 
                            class="form-control form-control-sm @error('login') is-invalid @enderror" 
                            value="{{ old('login') }}" 
                            placeholder="Masukkan email atau username" 
                            required 
                            autofocus>
                     @error('login')
                         <div class="invalid-feedback small">{{ $message }}</div>
                     @enderror
                 </div>

                    <!-- Input Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label small fw-semibold">Kata Sandi</label>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               class="form-control form-control-sm @error('password') is-invalid @enderror" 
                               placeholder="Masukkan kata sandi" 
                               required>
                        @error('password')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ingat Saya -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label small text-muted" for="remember">
                            Ingat saya di perangkat ini
                        </label>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="btn btn-dark btn-sm w-100 py-2">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
