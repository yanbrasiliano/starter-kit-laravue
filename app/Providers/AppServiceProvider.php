<?php

namespace App\Providers;

use App\Repositories\Contracts\{PermissionRepositoryInterface, RoleRepositoryInterface, UserRepositoryInterface};
use App\Repositories\EloquentRepository\{PermissionRepository, RoleRepository, UserRepository};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(!$this->app->isProduction());
        $this->app['request']->server->set('HTTPS', $this->app->environment() != 'local');
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            RoleRepositoryInterface::class,
            RoleRepository::class
        );

        $this->app->bind(
            PermissionRepositoryInterface::class,
            PermissionRepository::class
        );
    }
}
