<?php

use App\Http\Controllers\MainAuthController;
use App\Http\Controllers\RedirectGoogleController;
use App\Http\Controllers\SkillController;
use App\Services\Lightcast\LightcastSkillService;
use Illuminate\Support\Facades\Route;

Route::name("partners.")->domain("mitra." . env("APP_URL"))->group(function () {
    require __DIR__ . '/web/partner.php';
});

Route::name("admin.")->domain("admin." . env("APP_URL"))->group(function () {
    require __DIR__ . '/web/admin.php';
});

Route::name("users.")->domain("konsultan." . env("APP_URL"))->group(function () {
    require __DIR__ . '/web/user.php';
});

Route::get('/', function () {
    return redirect()->route('users.jobs.index-search');
});

Route::get('/login-as', function () {
    if ($user = request()->user()) {
        $role = $user->role?->role_name;
        return match ($role) {
            'admin' => redirect()->route('admin.auth.login.index'),
            'partner' => redirect()->route('partners.dashboard'),
            default => redirect()->route('users.jobs.index-search'),
        };
    }
    return view('login-as');
})->name('login-as');

// Route::redirect('/', '/users/profiles');

Route::get('/api/skill-list', [SkillController::class, 'index']);
