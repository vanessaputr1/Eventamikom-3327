<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class UserAuthController extends Controller
{
    protected function isGoogleConfigured(): bool
    {
        return filled(config('services.google.client_id'))
            && filled(config('services.google.client_secret'))
            && filled(config('services.google.redirect'));
    }

    public function showLogin(Request $request)
    {
        if (Auth::check() && Auth::user()->role === 'user') {
            return redirect()->to($request->query('redirect', route('home')));
        }

        return view('auth.login', [
            'redirect' => $request->query('redirect', route('home')),
            'googleConfigured' => $this->isGoogleConfigured(),
        ]);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
            'redirect' => ['nullable', 'url'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);
        }

        if ($user->role !== 'user') {
            throw ValidationException::withMessages([
                'email' => 'Akses login pengguna hanya berlaku untuk akun pembeli.',
            ]);
        }

        Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ], $request->boolean('remember'));

        return redirect()->to($validated['redirect'] ?? route('home'));
    }

    public function redirectToGoogle(Request $request)
    {
        if (!$this->isGoogleConfigured()) {
            return redirect()->route('login')->withErrors([
                'email' => 'Google OAuth belum dikonfigurasi. Isi GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, dan GOOGLE_REDIRECT_URI di file .env terlebih dahulu.',
            ]);
        }

        session(['user_login_redirect' => $request->query('redirect', route('home'))]);

        return Socialite::driver('google')->redirect();
    //     dd(config('services.google.redirect'));

    // return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        if (!$this->isGoogleConfigured()) {
            return redirect()->route('login')->withErrors([
                'email' => 'Google OAuth belum dikonfigurasi. Isi GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, dan GOOGLE_REDIRECT_URI di file .env terlebih dahulu.',
            ]);
        }

        $googleUser = Socialite::driver('google')->user();
        $user = User::findOrCreateFromGoogle($googleUser);

        if ($user->role !== 'user') {
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Google ini tidak dapat digunakan untuk login pengguna.',
            ]);
        }

        Auth::login($user);

        $redirect = session('user_login_redirect', route('home'));
        session()->forget('user_login_redirect');

        return redirect()->to($redirect);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
