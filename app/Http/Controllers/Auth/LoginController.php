<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        // If already logged in, redirect to appropriate dashboard
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }
        
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirectToDashboard();
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Redirect to dashboard based on user role
     */
    protected function redirectToDashboard()
    {
        $user = Auth::user();
        
        return match($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'pendidikan' => redirect()->route('pendidikan.dashboard'),
            'sekretaris' => redirect()->route('sekretaris.dashboard'),
            'bendahara' => redirect()->route('bendahara.dashboard'),
            default => redirect()->route('pendidikan.dashboard'),
        };
    }
}
