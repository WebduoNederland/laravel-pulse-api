<?php

namespace WebduoNederland\PulseApi;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PulseApiServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/pulse-api.php' => config_path('pulse-api.php'),
            ], 'config');
        }
    }

    public function register(): void
    {
        $this
            ->registerConfig()
            ->registerRoutes();
    }

    public function registerConfig(): static
    {
        $this->mergeConfigFrom(__DIR__.'/../config/pulse-api.php', 'pulse-api');

        return $this;
    }

    public function registerRoutes(): static
    {
        Route::prefix(config('pulse-api.route_prefix'))
            ->middleware(config('pulse-api.route_middleware'))
            ->group(function (): void {
                $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
            });

        return $this;
    }
}
