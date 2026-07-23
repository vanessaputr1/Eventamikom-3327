@extends('layouts.auth')

@section('title', 'Login User')

@section('content')
<main class="min-h-screen flex items-center justify-center px-6 py-12">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-[2rem] shadow-xl border border-slate-200 p-8">
            <div class="text-center mb-8">
                <div class="mx-auto w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center text-white text-2xl font-black">AH</div>
                <h1 class="mt-4 text-3xl font-black text-slate-900">Masuk ke AmikomEventHub</h1>
                <p class="mt-2 text-sm text-slate-500">Gunakan akun Google atau login email lama Anda.</p>
            </div>

            @if($errors->any())
                <div class="mb-5 rounded-2xl bg-rose-50 text-rose-700 p-4 text-sm font-bold">
                    {{ $errors->first() }}
                </div>
            @endif

            @if(!$googleConfigured)
                <div class="mb-5 rounded-2xl bg-amber-50 text-amber-700 p-4 text-sm font-bold">
                    Google OAuth belum aktif. Isi variabel environment GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, dan GOOGLE_REDIRECT_URI di .env agar tombol Continue with Google bisa berfungsi.
                </div>
            @endif

            <a href="{{ route('user.login.google', ['redirect' => $redirect]) }}"
               class="w-full inline-flex items-center justify-center gap-3 rounded-2xl border border-slate-200 bg-white px-5 py-4 font-bold text-slate-800 hover:border-indigo-400 hover:bg-indigo-50 transition {{ !$googleConfigured ? 'opacity-60 pointer-events-none' : '' }}">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M21.35 11.1h-9.17v2.98h5.45c-.24 1.26-.93 2.32-1.98 3.03v2.52h3.2c1.88-1.73 2.96-4.28 2.96-7.53 0-.73-.07-1.43-.21-2.1z"/>
                    <path d="M12.18 21c2.67 0 4.92-.88 6.56-2.39l-3.2-2.52c-.89.6-2.03.95-3.36.95-2.58 0-4.77-1.74-5.55-4.08H1.44v2.6A9.96 9.96 0 0 0 12.18 21z"/>
                    <path d="M6.63 13.96c-.2-.6-.31-1.24-.31-1.9s.11-1.3.31-1.9V7.56H1.44A9.96 9.96 0 0 0 1 12c0 1.61.39 3.13 1.08 4.44l5.55-2.48z"/>
                    <path d="M12.18 4.73c1.45 0 2.75.5 3.78 1.49l2.84-2.84C17.1 1.19 14.85 0 12.18 0 8.05 0 4.48 2.76 2.52 6.67l5.55 2.48c.78-2.34 2.97-4.42 5.55-4.42z"/>
                </svg>
                Continue with Google
            </a>

            <div class="my-6 flex items-center gap-3">
                <div class="h-px flex-1 bg-slate-200"></div>
                <span class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">atau</span>
                <div class="h-px flex-1 bg-slate-200"></div>
            </div>

            <form method="POST" action="{{ route('user.login.post', ['redirect' => $redirect]) }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                    <input type="password" name="password" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                </div>

                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" value="1">
                    Ingat saya
                </label>

                <button type="submit" class="w-full rounded-2xl bg-indigo-600 py-4 font-black text-white hover:bg-indigo-700 transition">
                    Masuk
                </button>
            </form>
        </div>
    </div>
</main>
@endsection
