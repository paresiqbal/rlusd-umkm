<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\MainAuthController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends MainAuthController
{
    public function afterLogin(Request $request, bool $isForceRedirect): RedirectResponse
    {
        return redirect("/admin/dashboard");
    }

    public function routeNameLogin(): array
    {
        return ["admin.auth.login.index", "admin.auth.login.post"];
    }

    public function role(): string
    {
        return "admin";
    }
}
