<?php

namespace FarshidRezaei\VandarResponder\Services;

use Exception;
use FarshidRezaei\VandarResponder\Concerns\ApiCustomExceptionInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

class ApiExceptionHandler
{

    /**
     * @param  Exception|Throwable  $exception
     * @return JsonResponse|null
     */
    public static function handle(Exception|Throwable $exception): ?JsonResponse
    {
        /** @var null|ApiCustomExceptionInterface $customException */
        return static::getCustomException($exception)?->render();
    }


    /**
     * returns mapped laravel|lumen class with mapped custom class.
     */
    private static function getCustomException($exception): ?ApiCustomExceptionInterface
    {
        $mappedClasses = config('responder.customExceptions', []);
        $class = get_class($exception);
        return array_key_exists($class, $mappedClasses) ? new ($mappedClasses[$class])($exception) : null;
    }
}
