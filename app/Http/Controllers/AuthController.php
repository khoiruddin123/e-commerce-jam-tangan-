<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Email atau username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $throttleKey = Str::lower($request->input('login')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()->withErrors([
                'login' => "Terlalu banyak percobaan masuk. Silakan coba lagi dalam {$seconds} detik.",
            ])->onlyInput('login');
        }

        $loginInput = trim((string) $request->input('login'));
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $loginInput,
            'password' => $request->input('password'),
        ];

        // Jangan gunakan fitur remember karena tabel users tidak memiliki kolom remember_token
        if (Auth::attempt($credentials, false)) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            session()->flash('login_success', [
                'nama' => Auth::user()->nama,
                'role' => Auth::user()->role,
            ]);

            return $this->redirectByRole(Auth::user()->role);
        }

        RateLimiter::hit($throttleKey, 60);

        return back()->withErrors([
            'login' => 'Email atau password salah',
        ])->onlyInput('login');
    }

    // --- FITUR REGISTRASI PELANGGAN (F2) ---
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Bersihkan awalan 0 pada nomor telepon bila pengguna mengetik 0 di depan
        $rawPhone = trim((string) $request->input('no_telepon'));
        $cleanPhone = ltrim($rawPhone, '0');
        $request->merge(['no_telepon' => $cleanPhone]);

        // Validasi kelengkapan dan keunikan data dalam bahasa Indonesia
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'min:3', 'max:30', 'regex:/^[A-Za-z0-9._]+$/', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'no_telepon' => ['required', 'string', 'regex:/^[0-9]+$/', 'digits_between:9,13'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['accepted'],
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'nama.max' => 'Nama lengkap maksimal 100 karakter.',
            'username.required' => 'Username wajib diisi.',
            'username.min' => 'Username minimal 3 karakter.',
            'username.max' => 'Username maksimal 30 karakter.',
            'username.regex' => 'Username hanya boleh berisi huruf, angka, titik, dan underscore (tanpa spasi).',
            'username.unique' => 'Username sudah dipakai. Silakan pilih username lain.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.max' => 'Alamat email maksimal 255 karakter.',
            'email.unique' => 'Email sudah terdaftar. Silakan gunakan email lain atau masuk.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'no_telepon.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'no_telepon.digits_between' => 'Nomor telepon harus terdiri dari 9 sampai 13 digit setelah +62.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok dengan password.',
            'terms.accepted' => 'Anda wajib menyetujui Syarat & Ketentuan serta Kebijakan Privasi.',
        ]);

        // Simpan ke database (role selalu pelanggan, username disimpan huruf kecil)
        User::create([
            'nama' => trim($validated['nama']),
            'username' => strtolower(trim($validated['username'])),
            'email' => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
            'role' => 'pelanggan',
            'no_telepon' => '+62' . $validated['no_telepon'],
            'alamat' => '',
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan masuk dengan email atau username Anda.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Sesi berakhir, Anda telah logout.');
    }

    private function redirectByRole(string $role)
    {
        if ($role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('produk.index'));
    }
}
