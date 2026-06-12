@extends('layouts.auth')

@section('title', 'Admin Login')

@section('content')
<div class="min-h-screen flex items-center justify-center px-6 py-12">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div
            class="absolute -top-40 -right-40 w-80 h-80 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
        </div>
        <div
            class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
        </div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border-2 border-green-200 rounded-xl flex items-start gap-3">
                <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <div>
                    <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-extrabold text-slate-900 mb-2">Login Admin</h1>
            <p class="text-slate-500 font-medium">Masuk ke dashboard admin</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-2xl p-8 md:p-10">
            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-6">
                @csrf

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

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:outline-none focus:border-indigo-600 focus:ring-2 focus:ring-indigo-100 transition @error('password') border-red-500 @enderror"
                        placeholder="••••••••">
                    @error('password')
                        <p class="text-red-500 text-sm font-medium mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" value="on"
                        class="w-4 h-4 border-2 border-slate-300 rounded accent-indigo-600 cursor-pointer">
                    <label for="remember" class="ml-2 text-sm text-slate-600 cursor-pointer">Ingat saya</label>
                </div>

                <!-- Login Button -->
                <button type="submit"
                    class="w-full py-3 bg-indigo-600 text-white font-bold rounded-xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:scale-105 transition-all duration-300">
                    Masuk ke Admin
                </button>

                <!-- Forgot Password Link -->
                <div class="text-center">
                    <a href="#"
                        class="text-sm text-indigo-600 font-semibold hover:text-indigo-700 transition">Lupa Password?</a>
                </div>
            </form>

            <!-- Divider -->
            <div class="my-8 flex items-center gap-4">
                <div class="flex-1 h-px bg-slate-200"></div>
                <span class="text-xs text-slate-500 font-medium">ATAU</span>
                <div class="flex-1 h-px bg-slate-200"></div>
            </div>

            <!-- Register Link -->
            <div class="text-center">
                <p class="text-slate-600 font-medium">Belum terdaftar?</p>
                <a href="{{ route('admin.register') }}"
                    class="inline-block mt-2 px-6 py-2 border-2 border-indigo-600 text-indigo-600 font-bold rounded-xl hover:bg-indigo-50 transition">
                    Daftar Sekarang
                </a>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="mt-8 text-center">
            <p class="text-xs text-slate-500">Hanya untuk admin terdaftar. Akses tidak sah akan dilaporkan.</p>
        </div>
    </div>
</div>
@endsection
