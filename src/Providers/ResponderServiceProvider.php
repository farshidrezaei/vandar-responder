<?php

namespace FarshidRezaei\VandarResponder\Providers;

use FarshidRezaei\VandarResponder\Services\Responder;
use Illuminate\Support\ServiceProvider;

class ResponderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        foreach (glob(__DIR__.'/../Helpers'.'/*.php') as $file) {
            require_once $file;
        }

        $this->mergeConfigFrom(__DIR__.'/../Configs/config.php', 'responder');

        $this->app->bind('responder', function () {
            return new Responder();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../Languages', 'responder');


        if ($this->app->runningInConsole()) {
            //configs
            $this->publishes(
                [
                    __DIR__.'/../Configs/config.php' => config_path('responder.php'),
                ],
                'config'
            );

            //languages
            $this->publishes([
                __DIR__.'/../Languages' => $this->app->langPath('vendor/responder'),
            ],'language');

            //customExceptions
            $this->publishes([
                __DIR__.'/../CustomExceptions' => $this->app->basePath('app/Responder/customExceptions'),
            ],'customExceptions');
        }
    }
}
