<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Pastikan pengguna sudah login
        if (!Auth::check()) {
            return $this->redirectLogin($role)->with("errorAlert", "Ups! Sepertinya Anda belum masuk. Silakan masuk untuk melanjutkan.");
        }

        // Ambil pengguna yang sedang login
        $user = Auth::user();
        // Periksa peran pengguna
        if ($user?->role?->role_name !== $role) {
            return $this->redirectLogin($role);
        }

        return $next($request);
    }

    private function redirectLogin($role)
    {
        switch ($role) {
            case 'admin':
                $redirect = redirect()->route('admin.auth.login.index');
            case 'partner':
            case 'freelancer':
            default:
                $redirect = redirect()->route('users.auth.login.index');
        }

        return $redirect->with('errorAlert', 'Ups! Sepertinya Anda belum masuk. Silakan masuk untuk melanjutkan.');
    }
}
