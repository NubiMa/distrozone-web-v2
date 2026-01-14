<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     **/
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            // Jika request API, kembalikan JSON
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Belum login',
                ], 401);
            }
            // Jika request web, redirect ke login
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = $request->user();

        // Cek apakah akun aktif
        if (!$user->is_active) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun Anda telah dinonaktifkan',
                ], 403);
            }
            return redirect()->route('login')->with('error', 'Akun Anda telah dinonaktifkan.');
        }

        // Cek apakah user memiliki role yang dibutuhkan
        if (!$user->hasAnyRole($roles)) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak memiliki akses. Izin tidak mencukupi.',
                ], 403);
            }
            return redirect()->route('guest.home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return $next($request);
    }
}