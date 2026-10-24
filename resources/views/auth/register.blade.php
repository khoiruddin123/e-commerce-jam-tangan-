<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - E-Commerce Jam Tangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen py-10 px-4">
    <div class="w-full max-w-lg bg-white rounded-2xl shadow-lg p-8 border border-slate-200">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Daftar Akun Baru</h1>
            <p class="text-sm text-slate-500 mt-1">Buat akun pelanggan untuk mulai berbelanja jam tangan</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-rose-50 border border-rose-300 text-rose-700 text-sm rounded-lg">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" required autofocus
                    class="w-full px-4 py-2 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('nama') border-rose-500 @enderror"
                    placeholder="Contoh: Firaas Javier">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Username <span class="text-rose-500">*</span></label>
                    <input type="text" name="username" value="{{ old('username') }}" required
                        class="w-full px-4 py-2 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('username') border-rose-500 @enderror"
                        placeholder="firaas_javier">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Email <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-rose-500 @enderror"
                        placeholder="nama@email.com">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Password <span class="text-rose-500">*</span></label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('password') border-rose-500 @enderror"
                        placeholder="Minimal 6 karakter">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Konfirmasi Password <span class="text-rose-500">*</span></label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-4 py-2 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Ulangi password">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">No. Telepon</label>
                <input type="text" name="no_telepon" value="{{ old('no_telepon') }}"
                    class="w-full px-4 py-2 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Contoh: 081234567890">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Alamat Lengkap</label>
                <textarea name="alamat" rows="2"
                    class="w-full px-4 py-2 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="Alamat pengiriman...">{{ old('alamat') }}</textarea>
            </div>

            <button type="submit"
                class="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2.5 px-4 rounded-lg transition duration-150">
                Daftar Sekarang
            </button>
        </form>

        <p class="text-center text-sm text-slate-600 mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-semibold">Masuk di sini</a>
        </p>
    </div>
</body>
</html>