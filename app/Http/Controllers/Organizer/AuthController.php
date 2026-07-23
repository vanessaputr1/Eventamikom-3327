<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (
            Auth::check() &&
            Auth::user()->role === 'organizer'
        ) {
            return redirect()->route('organizer.dashboard');
        }

        return view('organizer.login');
    }
    public function showRegister()
    {
        return view('organizer.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password organizer salah.',
            ]);
        }

        if ($user->role !== 'organizer') {
            throw ValidationException::withMessages([
                'email' => 'Akun ini bukan akun organizer.',
            ]);
        }

        if (!$user->organizer) {
            throw ValidationException::withMessages([
                'email' => 'Data organizer tidak ditemukan.',
            ]);
        }

        if ($user->organizer->status == 'pending') {
            throw ValidationException::withMessages([
                'email' => 'Akun organizer Anda masih menunggu persetujuan Superadmin.',
            ]);
        }

        if ($user->organizer->status == 'suspended') {
            throw ValidationException::withMessages([
                'email' => 'Akun organizer Anda sedang dinonaktifkan.',
            ]);
        }

        Auth::login($user, $request->boolean('remember'));

        return redirect()->route('organizer.dashboard');
    }
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|max:20',
            'organizer_name' => 'required|max:255',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => bcrypt($validated['password']),
            'role' => 'organizer',
        ]);

        $user->organizer()->create([
            'name' => $validated['organizer_name'],
            'slug' => \Illuminate\Support\Str::slug($validated['organizer_name']),
            'status' => 'pending',
        ]);

        return redirect()
            ->route('organizer.login')
            ->with(
                'success',
                'Registrasi berhasil. Menunggu persetujuan Superadmin.'
            );
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('organizer.login');
    }
}
