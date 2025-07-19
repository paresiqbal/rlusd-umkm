<?php
namespace App\Http\Contracts;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * MainAuthControllerContract defines the structure for the main authentication controller.
 * This interface provides methods for handling login, registration, and Google authentication,
 * as well as retrieving route names and post-login processes.
 */
interface MainAuthControllerContract
{
    /**
     * Show the login view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function indexLogin(Request $request): Factory | View | RedirectResponse;

    /**
     * Handle user login request.
     *
     * @param \Illuminate\Http\Request $request The login request data.
     * @return \Illuminate\Http\RedirectResponse Redirect response after login attempt.
     */
    public function login(Request $request): RedirectResponse;

    /**
     * Handle user login request.
     *
     * @param \Illuminate\Http\Request $request The login request data.
     * @return \Illuminate\Http\RedirectResponse Redirect response after login attempt.
     */
    public function logout(Request $request): RedirectResponse;

    /**
     * Retrieve the login route names.
     * Returns an array with four items:
     *  - Index 0: Login index route name
     *  - Index 1: Post login route name
     *  - Index 2: Redirect to register if indexRegister defined, left it null if unused.
     *  - Index 3: Redirect google route name if set the google auth on.
     *
     * @return string[] Array containing the names of the login routes.
     */
    public function routeNameLogin(): array;

    /**
     * Get the role associated with the current controller. Accepts `freelancer`, `admin`, `partner`.
     *
     * @return string The role identifier string.
     */
    public function role(): string;

    /**
     * Perform actions after login validation is complete, for standard or Google login.
     *
     * @param \Illuminate\Http\Request $request The request data.
     * @param bool $isForceRedirect Indicates the user has been login but user force to login url.
     * @return \Illuminate\Http\RedirectResponse Redirect response post-login.
     */
    public function afterLogin(Request $request, bool $isForceRedirect): RedirectResponse;

    /**
     * Retrieve the login view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewLogin(): Factory | View;

    /**
     * Check if Google authentication is enabled. Define the route redirect after success google auth. Don't forget to implements AuthControllerWithGoogle
     *
     * @param string $method `login` or `register`. The redirect url is different when login and register so you must define this two redirect url.
     * @return string Route redirect after success google auth. It flag for active the Google authentication
     */
    public function withGoogleAuth(string $method): ?string;
}
