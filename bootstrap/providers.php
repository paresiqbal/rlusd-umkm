<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\RegisterServiceProvider::class,
    // Laravel\Socialite\SocialiteServiceProvider::class
    \SocialiteProviders\Manager\ServiceProvider::class,
];
