<?php
namespace App\Http\Contracts;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

interface AuthControllerWithGoogle
{
    /**
     * Initiate Google login process.
     *
     * @param \Illuminate\Http\Request $request The request data.
     * @param string $name "login" or "register"
     * @return \Illuminate\Http\RedirectResponse Redirect response for Google authentication.
     */
    public function handleGoogleRedirect(Request $request, string $method): RedirectResponse;

    /**
     * Handle the callback after Google login.
     *
     * This is default, you can override it.
     *
     * @param \Illuminate\Http\Request $request The Google callback request data.
     * @param string $name "login" or "register"
     * @return \Illuminate\Http\RedirectResponse Redirect response post-Google login.
     *
     * @see https://discord.com/channels/1246756692142723164/1302155605699592192/1304729180675506176 object user structure from
     * `Socialite::driver('google')->stateless()->user();`.
     */
    public function handleGoogleCallback(Request $request, string $method): RedirectResponse;
}
