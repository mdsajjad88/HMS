<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;

class CustomLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $log = new Logger('custom_daily');
        $log->pushHandler(new RotatingFileHandler(storage_path('logs/laravel.log'), 14, Logger::DEBUG));
        $this->app->instance('log', $log);
    }
}
