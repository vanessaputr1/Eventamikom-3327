<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OrganizerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || Auth::user()->role !== 'organizer') {
            return redirect()->route('organizer.login');
        }

        if (!Auth::user()->organizer) {
            Auth::logout();
            return redirect()->route('organizer.login')->withErrors([
                'email' => 'Akun organizer belum aktif atau tidak terdaftar.',
            ]);
        }

        return $next($request);
    }
}
