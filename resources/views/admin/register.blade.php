@extends('layouts.auth')

@section('title', 'Admin Register')

@section('content')
<div class="min-h-screen flex items-center justify-center px-6 py-12">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div
            class="absolute -top-40 -right-40 w-80 h-80 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
        </div>
        <div
            class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
        </div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-extrabold text-slate-900 mb-2">Daftar Admin</h1>
            <p class="text-slate-500 font-medium">Buat akun admin baru</p>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-2xl p-8 md:p-10">
            <form method="POST" action="{{ route('admin.register.post') }}" class="space-y-5">
                @csrf

                <!-- Name Input -->
                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 transition @error('name') border-red-500 @enderror"
                        placeholder="John Doe">
                    @error('name')
                        <p class="text-red-500 text-sm font-medium mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 transition @error('email') border-red-500 @enderror"
                        placeholder="admin@example.com">
                    @error('email')
                        <p class="text-red-500 text-sm font-medium mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Input -->
                <div>
                    <label for="phone" class="block text-sm font-bold text-slate-700 mb-2">Nomor Telepon</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                        class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 transition @error('phone') border-red-500 @enderror"
                        placeholder="+62 812 3456 7890">
                    @error('phone')
                        <p class="text-red-500 text-sm font-medium mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 transition @error('password') border-red-500 @enderror"
                        placeholder="••••••••">
                    @error('password')
                        <p class="text-red-500 text-sm font-medium mt-2">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-slate-500 mt-2">Minimal 8 karakter dengan kombinasi huruf & angka</p>
                </div>

                <!-- Confirm Password Input -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi
                        Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 transition @error('password_confirmation') border-red-500 @enderror"
                        placeholder="••••••••">
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm font-medium mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Agreement Checkbox -->
                <div class="flex items-start gap-3 pt-2">
                    <input type="checkbox" name="agree" id="agree" required
                        class="w-5 h-5 border-2 border-slate-300 rounded accent-indigo-600 cursor-pointer mt-0.5">
                    <label for="agree" class="text-sm text-slate-600 cursor-pointer">
                        Saya setuju dengan
                        <a href="#" class="text-indigo-600 font-semibold hover:text-indigo-700">Syarat & Ketentuan</a>
                        dan
                        <a href="#" class="text-indigo-600 font-semibold hover:text-indigo-700">Kebijakan Privasi</a>
                    </label>
                </div>

                <!-- Register Button -->
                <button type="submit"
                    class="w-full py-3 bg-indigo-600 text-white font-bold rounded-xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:scale-105 transition-all duration-300 mt-6">
                    Daftar Sekarang
                </button>
            </form>

            <!-- Divider -->
            <div class="my-8 flex items-center gap-4">
                <div class="flex-1 h-px bg-slate-200"></div>
                <span class="text-xs text-slate-500 font-medium">ATAU</span>
                <div class="flex-1 h-px bg-slate-200"></div>
            </div>

            <!-- Login Link -->
            <div class="text-center">
                <p class="text-slate-600 font-medium">Sudah punya akun?</p>
                <a href="{{ route('admin.login') }}"
                    class="inline-block mt-2 px-6 py-2 border-2 border-indigo-600 text-indigo-600 font-bold rounded-xl hover:bg-indigo-50 transition">
                    Masuk Sekarang
                </a>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="mt-8 text-center">
            <p class="text-xs text-slate-500">Akun admin memerlukan verifikasi. Hubungi super admin untuk persetujuan.</p>
        </div>
    </div>
</div>
@endsection
