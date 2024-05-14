<?php

namespace App\Providers;

use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\ThematicAreaRepositoryInterface;
use App\Repositories\Contracts\UnitRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\EloquentRepository\PermissionRepository;
use App\Repositories\EloquentRepository\RoleRepository;
use App\Repositories\EloquentRepository\ThematicAreaRepository;
use App\Repositories\EloquentRepository\UnitRepository;
use App\Repositories\EloquentRepository\UserRepository;
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
        $this->app['request']->server->set('HTTPS', $this->app->environment() != 'local');
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            ThematicAreaRepositoryInterface::class,
            ThematicAreaRepository::class
        );

        $this->app->bind(
            RoleRepositoryInterface::class,
            RoleRepository::class
        );

        $this->app->bind(
            PermissionRepositoryInterface::class,
            PermissionRepository::class
        );

        $this->app->bind(
            UnitRepositoryInterface::class,
            UnitRepository::class
        );
    }
}
