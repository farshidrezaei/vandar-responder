<?php

namespace FarshidRezaei\VandarResponder\Facades;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static JsonResponse success(string $message, ?array $data = [])
 * @method static AnonymousResourceCollection successResourceCollection(string $message, mixed $data)
 * @method static JsonResponse failure(int $errorCode, string $stringErrorCode, string $message, null|array $errors = [], null|array $data = [])
 * @method static JsonResponse getStringError(string $stringErrorCode)
 *
 * @see  \FarshidRezaei\VandarResponder\Services\Responder;

 */
class Responder extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'responder';
    }

}
