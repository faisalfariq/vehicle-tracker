<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\AppLog;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // Redirect if already authenticated
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Log successful login
            AppLog::create([
                'user_id' => Auth::id(),
                'action' => 'login',
                'module' => 'auth',
                'ip_address' => $request->ip(),
            ]);

            return redirect()->intended('/dashboard');
        }

        // Log failed login attempt
        AppLog::create([
            'user_id' => null,
            'action' => 'login_failed',
            'module' => 'auth',
            'ip_address' => $request->ip(),
        ]);

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        // Log logout
        if (Auth::check()) {
            AppLog::create([
                'user_id' => Auth::id(),
                'action' => 'logout',
                'module' => 'auth',
                'ip_address' => $request->ip(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
} 