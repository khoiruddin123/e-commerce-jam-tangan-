<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    /**
     * Menampilkan halaman profil pelanggan.
     */
    public function show()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('profil.show', compact('user'));
    }

    /**
     * Memperbarui informasi profil pelanggan (nama, email, no_telepon, alamat).
     */
    public function update(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $validated = $request->validate([
            'nama_username' => [
                'required',
                'string',
                'min:3',
                'max:30',
                'regex:/^[A-Za-z0-9._]+$/',
                Rule::unique('users', 'username')->ignore($user->user_id, 'user_id'),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->user_id, 'user_id'),
            ],
            'no_telepon' => [
                'nullable',
                'string',
                'regex:/^[0-9+\s]+$/',
                function ($attribute, $value, $fail) {
                    $digits = preg_replace('/\D/', '', (string) $value);
                    $length = strlen($digits);
                    if ($length < 8 || $length > 15) {
                        $fail('Nomor telepon harus terdiri dari 8 sampai 15 digit angka.');
                    }
                },
            ],
            'alamat' => ['nullable', 'string', 'max:500'],
        ], [
            'nama_username.required' => 'Nama / Username wajib diisi.',
            'nama_username.min' => 'Minimal 3 karakter.',
            'nama_username.max' => 'Maksimal 30 karakter.',
            'nama_username.regex' => 'Hanya boleh huruf, angka, titik, dan underscore (tanpa spasi).',
            'nama_username.unique' => 'Nama / Username sudah dipakai. Silakan pilih yang lain.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.max' => 'Alamat email maksimal 255 karakter.',
            'email.unique' => 'Email ini sudah digunakan oleh pengguna lain.',
            'no_telepon.regex' => 'Nomor telepon hanya boleh berisi angka, tanda +, atau spasi.',
            'alamat.max' => 'Alamat maksimal 500 karakter.',
        ]);

        $user->update([
            'nama' => $validated['nama_username'],
            'username' => $validated['nama_username'],
            'email' => $validated['email'],
            'no_telepon' => $validated['no_telepon'] ?: null,
            'alamat' => $validated['alamat'] ?: null,
        ]);

        return redirect()->route('profil.show')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Memperbarui password pelanggan.
     */
    public function updatePassword(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $validated = $request->validate([
            'password_lama' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('Password lama tidak cocok dengan password saat ini.');
                    }
                },
            ],
            'password_baru' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password_lama.required' => 'Password lama wajib diisi.',
            'password_baru.required' => 'Password baru wajib diisi.',
            'password_baru.min' => 'Password baru minimal 8 karakter.',
            'password_baru.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user->update([
            'password' => Hash::make($validated['password_baru']),
        ]);

        return redirect()->route('profil.show')->with('success', 'Password berhasil diperbarui.');
    }
}

