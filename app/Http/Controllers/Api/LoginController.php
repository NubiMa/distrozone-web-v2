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
     * Tampilkan form login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Coba login
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect berdasarkan role
            switch ($user->role) {
                case 'admin':
                    // Sementara redirect ke guest.home sampai admin dashboard dibuat
                    return redirect()->route('guest.home')->with('info', 'Dashboard admin belum tersedia.');
                case 'cashier':
                    // Sementara redirect ke guest.home sampai kasir dashboard dibuat
                    return redirect()->route('guest.home')->with('info', 'Dashboard kasir belum tersedia.');
                case 'customer':
                    // Redirect ke halaman sebelumnya atau home customer
                    return redirect()->intended(route('customer.home'));
                default:
                    return redirect()->route('guest.home');
            }
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password salah.',
        ]);
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('guest.home');
    }
}
