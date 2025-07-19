<?php
namespace App\Http\Contracts;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\Factory;


interface AuthControllerWithRegister
{
    /**
     * Show the registration view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function indexRegister(): Factory | View;

    /**
     * Handle user registration request.
     *
     * @param \Illuminate\Http\Request $request The registration request data.
     * @return \Illuminate\Http\RedirectResponse Redirect response after registration.
     */
    public function register(Request $request): RedirectResponse;
}
