<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * F1 - Menampilkan form login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * F1 - Memproses autentikasi login pengguna
     */
  public function login(Request $request)
 {
     // 1. Validasi input
     $request->validate([
         'login'    => 'required|string',
         'password' => 'required|string',
     ], [
         'login.required'    => 'Email atau username wajib diisi.',
         'password.required' => 'Password wajib diisi.',
     ]);

     // 2. Tentukan apakah input berupa email atau username
     $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

     $kredensial = [
         $fieldType => $request->login,
         'password' => $request->password,
     ];

     $remember = $request->boolean('remember');

     // 3. Coba login
     if (Auth::attempt($kredensial, $remember)) {
         $request->session()->regenerate();

         return redirect()->intended(route('produk.index'))
             ->with('success', 'Selamat datang kembali, ' . (Auth::user()->nama ?? Auth::user()->username) . '!');
     }

     // 4. Jika login gagal
     return back()->withErrors([
         'login' => 'Email/username atau password yang Anda masukkan salah.',
     ])->onlyInput('login');
 }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('produk.index')
            ->with('success', 'Anda telah berhasil keluar.');
    }
}
