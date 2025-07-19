<?php

namespace App\Http\Controllers;

use App\Http\Contracts\MainAuthControllerContract;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Notifications\EmailVerifyToken;
use App\Utility\GlobalToastUtility;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\Factory as ViewFactory;
use Laravel\Socialite\Facades\Socialite;

abstract class MainAuthController extends Controller implements MainAuthControllerContract
{
    /**
     * Show the login view. The default one, you can override this function.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function indexLogin(Request $request): Factory|View|RedirectResponse
    {
        if ($request->user()) {
            return $this->afterLogin($request, true);
        }
        return $this->viewLogin();
    }

    /**
     * Handle user login request.
     * Validates the request credentials and checks if the specified role exists.
     * Attempts to authenticate the user and regenerate the session upon success.
     *
     * We don't recommended to override this. The main business of auth is same across the role.
     *
     * @param \Illuminate\Http\Request $request The login request data.
     * @return \Illuminate\Http\RedirectResponse Redirects after login or back to form with error.
     * @throws \Exception If the role is not defined on this route.
     */
    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email'        => ['required', 'email'],
            'password'     => ['required', 'min:8'],
            'approve_form' => ['accepted'],
        ], [
            'approve_form.accepted' => 'Anda harus menyetujui syarat dan ketentuan sebelum masuk.',
        ]);


        $credentials = [
            'email'    => $validated['email'],
            'password' => $validated['password'],
        ];

        if (!in_array($this->role(), ["freelancer", "partner", "admin"])) {
            throw new \Exception("No role has been defined or role not found on this route login.");
        }

        $role = Role::where("role_name", $this->role())->first();

        $credentials['role_id'] = $role->role_id;

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->afterLogin($request, false);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        if ($request->user()) {
            Auth::logout();
        }

        return redirect()->intended(route($this->routeNameLogin()[0]))->with("successAlert", "Logout successfully.");
    }

    // Verify service

    public function indexVerify(Request $request): ViewFactory|View
    {
        /**
         * @var User
         */
        $user = $request->user();
        if (!$user || $user->hasVerifiedEmail()) {
            $this->afterLogin($request, true);
        }

        return view("common.auth.need-verify-email");
    }

    public function verifyEmail(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'token_email' => 'required|string|digits:6|numeric',
        ]);
        if ($validator->fails()) {
            GlobalToastUtility::error('Token tidak valid');
            return $this->verifyFailed($request);
        }

        $validate = $validator->validated();

        if ($request->user()->verifyTokenEmail($validate['token_email'])) {
            $request->user()->markEmailAsVerified();
            $request->user()->save();
            return $this->verifySuccess($request);
        }

        return $this->verifyFailed($request);
    }

    public function retrySendEmail(Request $request): RedirectResponse
    {
        try {
            $request->user()->notify(new EmailVerifyToken());
            GlobalToastUtility::info('Email verifikasi baru telah dikirim.');
        } catch (Exception $e) {
            GlobalToastUtility::error("Email verifikasi gagal dikirim, harap coba lagi.");
        }
        return $this->retryRedirect($request);
    }

    public function verifySuccess(Request $request)
    {
        return redirect()->route('');
    }

    public function verifyFailed(Request $request)
    {
        return redirect()->route('');
    }

    public function retryRedirect(Request $request)
    {
        return redirect()->route('');
    }

    /**
     * Initiate Google login process.
     *
     * This is default, you can override with use of Socialite library.
     *
     * @param \Illuminate\Http\Request $request The Google login request data.
     * @return \Illuminate\Http\RedirectResponse Redirect response for Google authentication.
     */
    public function handleGoogleRedirect(Request $request, string $method): RedirectResponse
    {
        // dd( $this->withGoogleAuth($method));
        return Socialite::driver('google')->redirectUrl(url: $this->withGoogleAuth($method))->stateless()->redirect();
    }

    public function withGoogleAuth(string $method): ?string
    {
        return null;
    }

    /**
     * Retrieve the login view with necessary data.
     *
     * The default data provided is:
     * - *withGoogleAuth*: Check if Google authentication is enabled. It's good for decide the
     * login google disable or not on UI or default function.
     * - *role*: Get the role associated with the current controller. Accepts `freelancer`, `admin`, `partner`.
     * - *postLoginRoute*: Post login route name.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewLogin(): Factory|View
    {
        $withRegister = method_exists($this, "indexRegister");
        $view = view("common.auth.login")
            ->with('withGoogleAuth', $this->withGoogleAuth("login"))
            ->with('withRegister', $withRegister)
            ->with('role', $this->role())
            ->with('postLoginRoute', $this->routeNameLogin()[1] ?? null);

        if ($withRegister) {
            $view->with('redirectRegister', $this->routeNameLogin()[2] ?? null);
        }
        if ($this->withGoogleAuth("login")) {
            $view->with('redirectGoogleRoute', $this->routeNameLogin()[3] ?? null);
        }
        return $view;
    }
}
