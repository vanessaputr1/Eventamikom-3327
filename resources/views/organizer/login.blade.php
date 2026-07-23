@extends('layouts.auth')

@section('title', 'Organizer Login')

@section('content')
<div class="min-h-screen flex items-center justify-center px-6 py-12">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-[2rem] shadow-xl border border-slate-200 p-8">
            <div class="text-center mb-8">
                <div class="mx-auto w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center text-white text-2xl font-black">AH</div>
                <h1 class="mt-4 text-3xl font-black text-slate-900">Login Organizer</h1>
                <p class="mt-2 text-sm text-slate-500">Masuk ke panel organisasi penyelenggara acara.</p>
            </div>

            @if($errors->any())
                <div class="mb-5 rounded-2xl bg-rose-50 text-rose-700 p-4 text-sm font-bold">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('organizer.login.post') }}" class="space-y-4">
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
                    Masuk ke Organizer
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
