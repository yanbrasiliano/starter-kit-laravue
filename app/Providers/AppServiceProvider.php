<?php

namespace App\Providers;

use App\Repositories\Contracts\{
    PermissionRepositoryInterface,
    RoleRepositoryInterface,
    UserRepositoryInterface
};
use App\Repositories\EloquentRepository\{
    PermissionRepository,
    RoleRepository,
    UserRepository
};
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\{
    OpenApi,
    SecurityScheme
};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\{Vite};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->bindRepositories();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureModelBehavior();
        $this->configureRequest();
        $this->configureScramble();
        $this->configureVite();
    }

    /**
     * Bind repositories to their interfaces.
     */
    protected function bindRepositories(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
    }

    /**
     * Configure the behavior of Eloquent models.
     */
    protected function configureModelBehavior(): void
    {
        Model::preventLazyLoading(!$this->app->isProduction());
        Model::shouldBeStrict();
    }

    /**
     * Configure HTTPS for non-local environments.
     */
    protected function configureRequest(): void
    {
        $this->app['request']->server->set('HTTPS', $this->app->environment() != 'local');
    }

    /**
     * Configure the Scramble package.
     */
    protected function configureScramble(): void
    {
        Scramble::afterOpenApiGenerated(function (OpenApi $openApi) {
            $openApi->secure(
                SecurityScheme::http('bearer', 'JWT')
            );
        });
    }

    /**
     * Configure the Vite prefetch strategy.
     */
    protected function configureVite(): void
    {
        Vite::usePrefetchStrategy('aggresive');
    }

}
