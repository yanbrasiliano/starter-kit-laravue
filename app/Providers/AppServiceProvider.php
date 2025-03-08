<?php

declare(strict_types = 1);

namespace App\Providers;

use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\{
    OpenApi,
    SecurityScheme
};
use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Support\Facades\{Vite};
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
        $this->configureModelBehavior();
        $this->configureRequest();
        $this->configureScramble();
        $this->configureVite();
        $this->macros();
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

    /**
     * Register custom macro bindings to the Laravel framework.
     */
    protected function macros(): void
    {
        Builder::macro('whereILike', function ($column, $value) {
            /** @var \Illuminate\Database\Eloquent\Builder $this */
            return $this->where($column, 'ILIKE', "%{$value}%");
        });

        Builder::macro('orWhereILike', function ($column, $value) {
            /** @var \Illuminate\Database\Eloquent\Builder $this */
            return $this->orWhere($column, 'ILIKE', "%{$value}%");
        });
    }
}
