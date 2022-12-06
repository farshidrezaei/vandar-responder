<?php

namespace FarshidRezaei\VandarResponder\CustomExceptions;

use FarshidRezaei\VandarResponder\Concerns\ApiCustomExceptionInterface;
use FarshidRezaei\VandarResponder\Contracts\AbstractApiCustomException;
use Illuminate\Http\Response;
use Throwable;

class CustomRouteNotFoundException extends AbstractApiCustomException implements ApiCustomExceptionInterface
{
    public function __construct(?Throwable $exception)
    {
        $this->errorCode = Response::HTTP_NOT_FOUND;

        $this->stringErrorCode = config('responder.errors.NOT_FOUND_ERROR');

        $this->errorMessage = __('responder::exceptions.modelNotFound');

        parent::__construct();
    }
}
