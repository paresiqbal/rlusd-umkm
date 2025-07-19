<?php
namespace App\Http\Controllers\Partner;

use App\Enums\LogDiscordTypeEnum;
use App\Http\Contracts\AuthControllerWithGoogle;
use App\Http\Contracts\AuthControllerWithRegister;
use App\Http\Contracts\AuthControllerWithVerify;
use App\Http\Controllers\MainAuthController;
use App\Models\PartnerProfile;
use App\Models\Role;
use App\Models\User;
use App\Notifications\EmailVerifyToken;
use App\Utility\GlobalToastUtility;
use App\Utility\LogDiscordUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends MainAuthController implements AuthControllerWithRegister, AuthControllerWithGoogle
{
    public function indexRegister(): \Illuminate\Contracts\View\View|\Illuminate\View\Factory
    {
        return view("partner.auth.register");
    }

    public function register(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            "name" => ["required", "string", "min:2", "max:255"],
            "email" => ["required", "email", "unique:users,email"],
            "password" => ["required", "min:8", "max:255"],
        ]);

        $role = Role::where("role_name", "partner")->first();
        DB::beginTransaction();
        try {
            $newUser = new User();
            $newUser->email = $validated['email'];
            $newUser->password = $validated['password'];
            $newUser->generateUsername($validated['name']);
            $newUser->role_id = $role->role_id;
            $newUser->is_active = true;
            $newUser->save();

            $newProfile = new PartnerProfile();
            $newProfile->partner_name = $validated['name'];
            $newProfile->user_id = $newUser->user_id;
            $newProfile->save();
        } catch (\Throwable $th) {
            DB::rollBack();
            LogDiscordUtility::sendLog(LogDiscordTypeEnum::ERROR, "Error when register user", $th);
            return redirect(route("partners.auth.register.index"))->with("errorAlert", "Ada yang salah saat mendaftar, silakan coba lagi.");
        }
        DB::commit();

        // $newUser->notify(new EmailVerifyToken());

        GlobalToastUtility::success("Anda berhasil mendaftar. Silakan masuk ke akun anda untuk melanjutkan.");
        return redirect()->route("partners.auth.login.index");
    }

    public function handleGoogleCallback(Request $request, string $method): \Illuminate\Http\RedirectResponse
    {
        try {
            $user = Socialite::driver('google')->redirectUrl($this->withGoogleAuth($method))->stateless()->user();
            //code...
        } catch (\Throwable $th) {
            return redirect(route($method == "login" ? "partners.auth.login.index" : "partners.auth.register.index"))->with("errorAlert", "Ada yang salah saat masuk dengan akun google, silakan coba lagi.");
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
            $role = Role::where("role_name", "partner")->first();
            $newUser = new User();
            $newUser->email = $user->email;
            $newUser->password = Str::random("16");
            $newUser->generateUsername($user->name);
            $newUser->role_id = $role->role_id;
            $newUser->markEmailAsVerified();
            $newUser->is_active = true;
            $newUser->save();

            $newProfile = new PartnerProfile();
            $newProfile->partner_name = $user->name;
            $newProfile->user_id = $newUser->user_id;
            $newProfile->save();

        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            if ($method == "register") {
                return redirect(route("partners.auth.register.index"))->with("errorAlert", "Ada yang salah saat mendaftar dengan akun google, silakan coba lagi.");
            } else {
                return redirect(route("partners.auth.login.index"))->with("errorAlert", "Ada yang salah saat masuk dengan akun google, silakan coba lagi.");
            }
        }

        DB::commit();
        Auth::login($newUser);
        GlobalToastUtility::success("Anda berhasil masuk ke akun Anda!");
        return redirect()->intended(route("partners.dashboard"));

    }

    public function afterLogin(Request $request, bool $isForceRedirect): \Illuminate\Http\RedirectResponse
    {

        // if ($isForceRedirect) {
        //     return redirect("/");
        // }

        return redirect()->route('partners.dashboard');
    }

    // public function verifySuccess(Request $request): \Illuminate\Http\RedirectResponse
    // {
    //     return redirect()->route('partners.dashboard');
    // }

    // public function verifyFailed(Request $request): \Illuminate\Http\RedirectResponse
    // {
    //     return redirect()->route('partners.auth.need-verify.index');
    // }

    public function routeNameLogin(): array
    {
        return ["partners.auth.login.index", "partners.auth.login.post", "partners.auth.register.index", "partners.auth.google.redirect"];
    }

    public function role(): string
    {
        return 'partner';
    }

    public function withGoogleAuth($method): ?string
    {
        return route("partners.auth.google.callback", ['method' => $method]);
    }
}
