<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt login
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect based on role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'cashier':
                    return redirect()->route('cashier.dashboard');
                case 'customer':
                    // Redirect back to previous page or home
                    return redirect()->intended(route('home'));
                default:
                    return redirect()->route('home');
            }
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password salah.',
        ]);
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}