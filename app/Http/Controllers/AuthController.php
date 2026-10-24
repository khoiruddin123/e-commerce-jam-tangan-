<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $loginInput = $request->input('login');
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $loginInput,
            'password' => $request->input('password'),
        ];

        // False pada parameter kedua karena remember_token ditiadakan di skema SQL
        if (Auth::attempt($credentials, false)) {
            $request->session()->regenerate();

            return $this->redirectByRole(Auth::user()->role);
        }

        return back()->withErrors([
            'login' => 'Email/username atau password salah.',
        ])->onlyInput('login');
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

        return redirect()->intended(route('pelanggan.beranda'));
    }
}
