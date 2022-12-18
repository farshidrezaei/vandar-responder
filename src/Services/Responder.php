<?php

namespace FarshidRezaei\VandarResponder\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class Responder
{
    /**
     * for success responses call this function. every argument is optional, but please fill those.
     */
    public static function success(string $message, ?array $data = [] ): JsonResponse {
        return self::okJson(self::generatePayload($message, $data));
    }

    /**
     * for success Resource Collection responses call this function. every argument is optional, but please fill those.
     */
    public static function successResourceCollection(  string $message, AnonymousResourceCollection $data): AnonymousResourceCollection {
        return self::okResourceCollectionJson(self::generatePayload($message, $data));
    }

    private static function okJson(array $payload): JsonResponse
    {
        return response()->json($payload, Response::HTTP_OK);
    }


    private static function okResourceCollectionJson(array $payload): AnonymousResourceCollection
    {
        return $payload['data']->additional(['message' => $payload['message']]);
    }


    private static function generatePayload(string $message, mixed $data = []): array
    {
        return  [
            'message' => $message,
            'data'=> $data
        ];

    }


    private static function generateFailurePayload(string $stringErrorCode, string $message, ?array $errors = [], ?array $data = [] ): array
    {
        return  [
            'message' => $message,
            'data'=> $data,
            'code'=> $stringErrorCode,
            'errors'=> $errors,
        ];
    }

    /**
     * for failure responses call this function. every argument is optional, but please fill those.
     */
    public static function failure(
        int $errorCode,
        string $stringErrorCode,
        string $message,
        ?array $errors = [],
        ?array $data = []
    ): JsonResponse {
        return self::failJson($errorCode, self::generateFailurePayload($stringErrorCode, $message, $errors,$data));
    }


    private static function failJson(int $errorCode, array $payload): JsonResponse
    {
        return response()->json($payload, $errorCode);
    }

    public static function getStringError(string $error): string
    {
        return StringErrors::getError($error);
    }
}
