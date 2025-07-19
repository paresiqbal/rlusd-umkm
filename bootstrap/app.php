<?php

use App\Enums\LogDiscordTypeEnum;
use App\Utility\LogDiscordUtility;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\AuthRole::class,
            'verify-email' => \App\Http\Middleware\EmailVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->report(function (Exception $e) {
            if (!env("DISCORD_LOG_ENABLE")) {
                return;
            }

            $id = \Illuminate\Support\Str::uuid();
            $message = "**Message:** {$e->getMessage()}" . PHP_EOL;
            $message .= "**ID:** $id" . PHP_EOL;
            $message .= "Error on file {$e->getFile()}:{$e->getLine()}" . PHP_EOL . PHP_EOL;
            $message .= LogDiscordUtility::jTraceEx($e);
            LogDiscordUtility::sendLog(LogDiscordTypeEnum::ERROR, "Error server occured", $message);
        });
    })->create();
