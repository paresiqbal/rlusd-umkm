<?php
namespace App\Utility;

use App\Enums\ToastTypeEnum;
use Illuminate\Support\Facades\Session;

/**
 * Handles global toast notifications in the application.
 * This class provides a method to show a toast notification when the page finishes loading.
 * If a new toast is defined, it will replace the previously defined toast.
 */
class GlobalToastUtility
{
    /**
     * Show a toast notification with the specified type and message.
     * The toast will be flashed to the session and shown on the next page load.
     *
     * @param \App\Enums\ToastTypeEnum $type    The type of toast notification (e.g., success, error, info, warning).
     * @param string $message                   The message to display in the toast notification.
     *
     * @return void
     */
    public static function show(ToastTypeEnum $type, string $message)
    {
        Session::flash("globalToast", [
            "type" => $type->value,
            "message" => $message,
        ]);
    }

    /**
     * Show a success toast notification.
     *
     * @param string $message The success message to display.
     *
     * @return void
     */
    public static function success(string $message)
    {
        self::show(ToastTypeEnum::SUCCESS, $message);
    }

    /**
     * Show an informational toast notification.
     *
     * @param string $message The informational message to display.
     *
     * @return void
     */
    public static function info(string $message)
    {
        self::show(ToastTypeEnum::INFO, $message);
    }

    /**
     * Show an error toast notification.
     *
     * @param string $message The error message to display.
     *
     * @return void
     */
    public static function error(string $message)
    {
        self::show(ToastTypeEnum::ERROR, $message);
    }

    /**
     * Show a warning toast notification.
     *
     * @param string $message The warning message to display.
     *
     * @return void
     */
    public static function warning(string $message)
    {
        self::show(ToastTypeEnum::WARNING, $message);
    }
}
