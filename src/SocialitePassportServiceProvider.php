<?php

namespace x96\SocialitePassport;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use x96\SocialitePassport\Http\Controllers\AuthenticationController;
use x96\SocialitePassport\Http\Controllers\LoginController;
use x96\SocialitePassport\Providers\EventServiceProvider;
use x96\SocialitePassport\Http\Middleware\EnsureUserHasRole;
use x96\SocialitePassport\Http\Middleware\EnsureUserHasAction;
use x96\SocialitePassport\Http\Middleware\EnsureUserHasPermission;

class SocialitePassportServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'../../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('role', EnsureUserHasRole::class);
        $router->aliasMiddleware('action', EnsureUserHasAction::class);
        $router->aliasMiddleware('permission', EnsureUserHasPermission::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('socialite-passport.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'socialite-passport');
        $this->mergeConfigFrom(__DIR__.'/../config/services.php', 'services');

        $this->app->register(EventServiceProvider::class);

        $this->app->bind('AuthenticationController', function () {
            return new AuthenticationController();
        });
        $this->app->bind('LoginController', function () {
            return new LoginController();
        });
    }
}
