<?php

namespace App\Providers;

use App\Services\Lightcast\LightcastSkillService;
use App\Services\Lightcast\LightcastSkillServiceImpl;
use Illuminate\Support\ServiceProvider;

class RegisterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(LightcastSkillService::class, function ($app) {
            return new LightcastSkillServiceImpl();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
