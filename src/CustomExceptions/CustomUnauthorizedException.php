<?php

namespace FarshidRezaei\VandarResponder\CustomExceptions;

use Exception;
use FarshidRezaei\VandarResponder\Concerns\ApiCustomExceptionInterface;
use FarshidRezaei\VandarResponder\Contracts\AbstractApiCustomException;
use Illuminate\Http\Response;
use Throwable;

class CustomUnauthorizedException extends AbstractApiCustomException implements ApiCustomExceptionInterface
{
    public function __construct(?Exception $exception)
    {
        $this->errorCode = Response::HTTP_FORBIDDEN;

        $this->stringErrorCode = config('responder.errors.UNAUTHORIZED_ERROR');

        $this->errorMessage = __('responder::exceptions.unauthorized');

        parent::__construct();
    }
}
