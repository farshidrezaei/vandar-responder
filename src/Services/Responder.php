<?php

namespace FarshidRezaei\VandarResponder\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class Responder
{
    /**
     * for success responses call this function. every argument is optional, but please fill those.
     * @param  string|null  $message
     * @param  mixed  $data
     * @return JsonResponse
     */
    public static function success(
        ?string $message = null,
        mixed $data = null
    ): JsonResponse {
        return self::okJson(
            self::generatePayload($message, $data),
        );
    }

    /**
     * for success Resource Collection responses call this function. every argument is optional, but please fill those.
     * @param  string|null  $message
     * @param  mixed  $data
     * @return AnonymousResourceCollection
     */
    public static function successResourceCollection(
        ?string $message = null,
        AnonymousResourceCollection $data,
    ): AnonymousResourceCollection {
        return self::okResourceCollectionJson(
            self::generatePayload($message, $data),
        );
    }

    /**
     * @param  array  $payload
     * @return JsonResponse
     */
    private static function okJson(array $payload): JsonResponse
    {
        return response()->json(!empty($payload) ? $payload : null, Response::HTTP_OK);
    }

    /**
     * @param  array  $payload
     * @return AnonymousResourceCollection
     */
    private static function okResourceCollectionJson(array $payload): AnonymousResourceCollection
    {
        return isset($payload['message']) ? $payload['data']->additional(['message' => $payload['message']]) : $payload['data'];
    }

    /**
     * @param  string|null  $message
     * @param  array|null  $data
     * @return array
     */
    private static function generatePayload(?string $message = null, mixed $data = null): array
    {
        $payload = [];
        if ($message) {
            $payload['message'] = $message;
        }
        if ($data) {
            $payload['data'] = $data;
        }
        return $payload;
    }


    /**
     * @param  string  $stringErrorCode
     * @param  string|null  $message
     * @param  array|null  $errors
     * @return array
     */
    private static function generateFailurePayload(string $stringErrorCode, ?string $message = null, ?array $errors = null): array
    {
        $payload = [];
        if ($message) {
            $payload['message'] = $message;
        }
        if ($stringErrorCode) {
            $payload['code'] = $stringErrorCode;
        }
        if ($errors) {
            $payload['errors'] = $errors;
        }
        return $payload;
    }

    /**
     * for failure responses call this function. every argument is optional, but please fill those.
     * @param  int  $errorCode
     * @param  string  $stringErrorCode
     * @param  string|null  $message
     * @param  array|null  $errors
     * @return JsonResponse
     */
    public static function failure(
        int $errorCode,
        string $stringErrorCode,
        ?string $message = null,
        ?array $errors = []
    ): JsonResponse {
        return self::failJson($errorCode, self::generateFailurePayload($stringErrorCode, $message, $errors));
    }

    /**
     * @param  int  $errorCode
     * @param  array  $payload
     * @return JsonResponse
     */
    private static function failJson(int $errorCode, array $payload = []): JsonResponse
    {
        return response()->json(!empty($payload) ? $payload : null, $errorCode);
    }

    public static function getStringError(string $error): string
    {
        return StringErrors::getError($error);
    }
}
