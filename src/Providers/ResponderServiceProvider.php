<?php

namespace FarshidRezaei\VandarResponder\Providers;

use FarshidRezaei\VandarResponder\Services\Responder;
use FarshidRezaei\VandarResponder\Facades\Responder as ResponderFacade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;

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


        //macros 
        ResponseFactory::macro('success', fn(string $message, null|array $data=null) => ResponderFacade::success($message, $data));
        Response::macro('success', fn(string $message, null|array $data=null) => ResponderFacade::success($message, $data));

        ResponseFactory::macro('failure', fn(int $errorCode, string $stringErrorCode, null|string $message, null|array $errors = null, null|array $data = null) => ResponderFacade::failure($errorCode,$stringErrorCode,$message,$errors, $data));
        Response::macro('failure', fn(int $errorCode, string $stringErrorCode, null|string $message, null|array $errors = null, null|array $data = null) => ResponderFacade::failure($errorCode,$stringErrorCode,$message,$errors, $data));

        ResponseFactory::macro('successResourceCollection', fn(null|string $message, mixed $data = null) => ResponderFacade::successResourceCollection($message, $data));
        Response::macro('successResourceCollection', fn(null|string $message, mixed $data = null) => ResponderFacade::successResourceCollection($message, $data));

    }
}
