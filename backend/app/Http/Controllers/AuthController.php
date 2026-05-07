<?php

namespace App\Http\Controllers;

use App\Enums\UserRolesEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (auth()->check() && auth()->user()->role->canAccessAdmin()) {
            return redirect('/admin');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (auth()->user()->role->canAccessAdmin()) {
                return redirect('/admin');
            }

            $token = auth()->user()->createToken('feed-token')->plainTextToken;
            $frontendUrl = config('app.frontend_url', 'http://localhost:3000');

            return redirect($frontendUrl . '?token=' . $token);
        }

        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
