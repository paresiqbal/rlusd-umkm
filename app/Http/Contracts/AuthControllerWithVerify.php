<?php
namespace App\Http\Contracts;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\Factory;

interface AuthControllerWithVerify
{
    public function indexVerify(Request $request): Factory|View;
    public function verifyEmail(Request $request): RedirectResponse;

    public function retrySendEmail(Request $request): RedirectResponse;

    /**
     * Handle when email verification is successful.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifySuccess(Request $request): RedirectResponse;

    /**
     * Handle when email verification is failed.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyFailed(Request $request): RedirectResponse;

    /**
     * Redirect to retry send email verification.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function retryRedirect(Request $request): RedirectResponse;
}
