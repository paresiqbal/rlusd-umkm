<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EmailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * @var User
         */
        $user = Auth::user();

        $roleName = $user->role->role_name;

        if (!$user->hasVerifiedEmail()) {
            return $this->redirectNeedVerify($roleName);
        }

        return $next($request);
    }

    private function redirectNeedVerify($role)
    {
        switch ($role) {
            case 'partner':
            case 'freelancer':
            default:
                $redirect = redirect()->route('users.auth.need-verify.index');
        }

        return $redirect->with('errorAlert', 'Ups! Sepertinya Anda belum masuk. Silakan masuk untuk melanjutkan.');
    }

}
