<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Commerce Jam Tangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8 border border-slate-200">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Toko Jam Tangan</h1>
            <p class="text-sm text-slate-500 mt-1">Silakan masuk menggunakan akun Admin atau Pelanggan</p>
        </div>

        @if (session('success'))
            <div class="mb-4 p-3 bg-emerald-50 border border-emerald-300 text-emerald-700 text-sm rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 bg-rose-50 border border-rose-300 text-rose-700 text-sm rounded-lg">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Email atau Username</label>
                <input type="text" name="login" value="{{ old('login') }}" required autofocus
                    class="w-full px-4 py-2.5 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('login') border-rose-500 @enderror"
                    placeholder="nama@email.com atau username">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2.5 bg-slate-50 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="••••••••">
            </div>

            <button type="submit"
                class="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2.5 px-4 rounded-lg transition duration-150">
                Masuk
            </button>
        </form>
    </div>
</body>
</html>
