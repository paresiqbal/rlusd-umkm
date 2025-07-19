<?php
namespace App\Utility;

use Illuminate\Support\Facades\Route;

/**
 * Utility class to declare authentication-related routes.
 *
 * This utility provides a method to easily define login and registration routes,
 * with optional support for Google authentication if you using <a href="/app/Http/Controllers/MainAuthController.php">MainAuthController</a>.
 *
 */
class DeclareAuthRouteUtility
{

    /**
     * Declare authentication routes with optional registration and Google OAuth support.
     *
     * @param string $controllerClass The fully qualified class name of the controller handling the routes.
     * @param bool $withRegister Determines whether registration routes should be included (default: true).
     * @param bool $withGoogleAuth Determines whether Google authentication routes should be included (default: false).
     * @param string|null $withVerify Determines whether verify email routes should be included (default: null).
     *
     * @return void
     */
    public static function declareRoute(string $controllerClass, bool $withRegister = true, bool $withGoogleAuth = false, string $withVerify = null)
    {
        Route::prefix("auth")->name("auth.")->controller($controllerClass)
            ->group(function () use ($withRegister, $withGoogleAuth, $withVerify) {
                Route::get("/login", "indexLogin")->name("login.index");
                Route::post("/login", "login")->name("login.post");
                Route::post("/logout", "logout")->name("logout");
                if ($withGoogleAuth) {
                    Route::get("/{method}/google", "handleGoogleRedirect")->name("google.redirect")->whereIn('method', ['login', 'register']);
                    Route::get("/{method}/google/callback", "handleGoogleCallback")->name("google.callback")->whereIn('method', ['login', 'register']);
                }
                if ($withRegister) {
                    Route::get("/register", "indexRegister")->name("register.index");
                    Route::post("/register", "register")->name("register.post");
                }
                if (!empty($withVerify)) {
                    Route::middleware(["role:$withVerify"])->group(function () {
                        Route::get("/need-verify", "indexVerify")->name("need-verify.index");
                        Route::post("/need-verify", "verifyEmail")->name("need-verify.post");
                        Route::post("/need-verify/resend", "retrySendEmail")->name("need-verify.resend");
                    });
                }
            });
    }
}
