<?php

declare(strict_types = 1);

namespace App\Providers;

use App\Models\User;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\{OpenApi, SecurityScheme};
use Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\{DB, Vite};
use Illuminate\Support\{ServiceProvider, Sleep};
use Laravel\Telescope\Telescope;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->environment() !== 'local' && class_exists(\Barryvdh\Debugbar\Facades\Debugbar::class)) {
            \Barryvdh\Debugbar\Facades\Debugbar::disable();
        }
    }

    public function boot(): void
    {
        $this->configureModelBehavior();
        $this->configureDatabase();
        $this->configureRequest();
        $this->configureScramble();
        $this->configureVite();

        Gate::define('viewPulse', fn (User $user) => $user->isAdmin());

        if ($this->app->runningUnitTests()) {
            Sleep::fake();
        }

        if (!class_exists(Telescope::class)) {
            return;
        }

        $app = $this->app;

        if (method_exists($app, 'runningInQueue') && $app->runningInQueue()) {
            Telescope::stopRecording();
        }
    }

    /**
     * @codeCoverageIgnore
     */
    public function configureDatabase(): void
    {
        DB::prohibitDestructiveCommands(app()->isProduction());
    }

    protected function configureModelBehavior(): void
    {
        Model::preventLazyLoading(!$this->app->isProduction());
        Model::shouldBeStrict();
        Model::automaticallyEagerLoadRelationships();
    }

    protected function configureRequest(): void
    {
        $this->app['request']->server->set('HTTPS', $this->app->environment() !== 'local');
    }

    protected function configureScramble(): void
    {
        Scramble::afterOpenApiGenerated(function (OpenApi $openApi) {
            $openApi->secure(
                SecurityScheme::http('bearer', 'JWT')
            );
        });
    }

    protected function configureVite(): void
    {
        Vite::useAggressivePrefetching();
    }
}
