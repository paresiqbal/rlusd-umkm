<?php
namespace App\Http\Controllers\User;

use App\Enums\LogDiscordTypeEnum;
use App\Http\Contracts\AuthControllerWithGoogle;
use App\Http\Contracts\AuthControllerWithRegister;
use App\Http\Contracts\AuthControllerWithVerify;
use App\Http\Controllers\MainAuthController;
use App\Models\FreelancerProfile;
use App\Models\Role;
use App\Models\User;
use App\Notifications\EmailVerifyToken;
use App\Utility\GlobalToastUtility;
use App\Utility\LogDiscordUtility;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

/**
 * User Authentication Controller
 *
 * This controller handles user registration, login, and Google OAuth callback operations.
 */
class AuthController extends MainAuthController implements AuthControllerWithRegister, AuthControllerWithGoogle, AuthControllerWithVerify
{
    /**
     * Display the user registration page.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\View\Factory
     */
    public function indexRegister(): \Illuminate\Contracts\View\View|\Illuminate\View\Factory
    {
        return view("user.auth.register");
    }

    /**
     * Handle the user registration request.
     *
     * @param Request $request The incoming HTTP request.
     *
     * @return RedirectResponse Redirects the user to the home page after successful registration.
     *
     * @throws \Illuminate\Validation\ValidationException If validation fails.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            "name" => ["required", "string", "min:2", "max:255"],
            "email" => ["required", "email", "unique:users,email"],
            "password" => ["required", "min:8", "max:255"],
        ]);

        $role = Role::where("role_name", "freelancer")->first();
        DB::beginTransaction();
        try {
            $newUser = new User();
            $newUser->email = $validated['email'];
            $newUser->password = $validated['password'];
            $newUser->generateUsername($validated['name']);
            $newUser->role_id = $role->role_id;
            $newUser->is_active = true;
            $newUser->save();

            $newProfile = new FreelancerProfile();
            $newProfile->name = $validated['name'];
            $newProfile->user_id = $newUser->user_id;
            $newProfile->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            LogDiscordUtility::sendLog(LogDiscordTypeEnum::ERROR, "Error when register user", $th);
            return redirect(route("users.auth.register.index"))->with("errorAlert", "Ada yang salah saat mendaftar, silakan coba lagi.");
        }
        DB::commit();

        $newUser->notify(new EmailVerifyToken());

        GlobalToastUtility::success("Anda berhasil mendaftar. Silakan masuk ke akun anda untuk melanjutkan.");
        return redirect()->route("users.auth.login.index");
    }

    public function handleGoogleCallback(Request $request, string $method): RedirectResponse
    {
        try {
            $user = Socialite::driver('google')->redirectUrl($this->withGoogleAuth($method))->stateless()->user();
            //code...
        } catch (\Throwable $th) {
            return redirect(route($method == "login" ? "users.auth.login.index" : "users.auth.register.index"))->with("errorAlert", "Ada yang salah saat masuk dengan akun google, silakan coba lagi.");
        }

        $userExist = User::where("email", $user->email)->first();
        if ($userExist) {
            Auth::login($userExist);
            if ($method == "register") {
                GlobalToastUtility::info("Akun ini sudah terdaftar. Anda telah berhasil masuk menggunakan akun Google tersebut.");
            }
            return redirect()->intended(route("users.profiles.show"));
        } else if ($method == "login") {
            return redirect(route($this->routeNameLogin()[2]))->with("errorAlert", "Akun google Anda belum terdaftar di ABDSI, silakan daftar di sini.");
        }

        DB::beginTransaction();
        try {
            $role = Role::where("role_name", "freelancer")->first();
            $newUser = new User();
            $newUser->email = $user->email;
            $newUser->password = Str::random("16");
            $newUser->generateUsername($user->name);
            $newUser->role_id = $role->role_id;
            $newUser->markEmailAsVerified();
            $newUser->is_active = true;
            $newUser->save();

            $newProfile = new FreelancerProfile();
            $newProfile->name = $user->name;
            $newProfile->user_id = $newUser->user_id;
            $newProfile->save();

        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect(route("users.auth.register.index"))->with("errorAlert", "Ada yang salah saat mendaftar dengan akun google, silakan coba lagi.");
        }

        DB::commit();
        Auth::login($newUser);
        GlobalToastUtility::success("Anda berhasil masuk ke akun Anda!");
        return redirect()->intended(route("users.profiles.show"));
    }

    public function afterLogin(Request $request, bool $isForceRedirect): RedirectResponse
    {
        if ($isForceRedirect) {
            return redirect()->intended(route("users.profiles.show"));
        }

        return redirect()->route('users.profiles.show');
    }

    public function verifySuccess(Request $request): RedirectResponse
    {
        GlobalToastUtility::success("Verifikasi email berhasil");
        return redirect()->route('users.profiles.show');
    }

    public function verifyFailed(Request $request): RedirectResponse
    {
        GlobalToastUtility::error("Verifikasi email gagal, harap coba lagi.");
        return redirect()->route('users.auth.need-verify.index');
    }

    public function retryRedirect(Request $request): RedirectResponse
    {
        GlobalToastUtility::success("Email verifikasi baru telah dikirim.");
        return redirect()->route('users.auth.need-verify.index');
    }

    public function routeNameLogin(): array
    {
        return ["users.auth.login.index", "users.auth.login.post", "users.auth.register.index", "users.auth.google.redirect"];
    }

    public function role(): string
    {
        return "freelancer";
    }

    public function withGoogleAuth($method): ?string
    {
        return route("users.auth.google.callback", ['method' => $method]);
    }
}
