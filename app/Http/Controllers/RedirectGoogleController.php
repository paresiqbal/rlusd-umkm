<?php
namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class RedirectGoogleController extends Controller
{
  /**
     * Handle the callback after Google login.
     *
     * This is default, you can override it.
     *
     * @param \Illuminate\Http\Request $request The Google callback request data.
     * @return \Illuminate\Http\RedirectResponse Redirect response post-Google login.
     */
    public function loginGoogleCallback(Request $request): RedirectResponse
    {
        $user = Socialite::driver('google')->stateless()->user();

        // if ()
        dd($request->query(), $user);
        return redirect();
    }
}
