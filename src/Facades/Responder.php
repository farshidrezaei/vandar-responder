<?php

namespace FarshidRezaei\VandarResponder\Facades;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static JsonResponse success(null|string $message, $data = null)
 * @method static AnonymousResourceCollection successResourceCollection(null|string $message, $data = null)
 * @method static JsonResponse failure(int $errorCode, string $stringErrorCode, null|string $message, null|array $errors = null, null|array $data = null)
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
