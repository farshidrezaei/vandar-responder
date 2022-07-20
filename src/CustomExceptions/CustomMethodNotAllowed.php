<?php

namespace FarshidRezaei\VandarResponder\CustomExceptions;

use FarshidRezaei\VandarResponder\Concerns\ApiCustomExceptionInterface;
use FarshidRezaei\VandarResponder\Contracts\AbstractApiCustomException;
use Illuminate\Http\Response;
use Throwable;

class CustomMethodNotAllowed extends AbstractApiCustomException implements ApiCustomExceptionInterface
{
    public function __construct(?Throwable $exception)
    {
        $this->errorCode = Response::HTTP_METHOD_NOT_ALLOWED;

        $this->stringErrorCode = config('responder.errors.METHOD_NOT_ALLOWED');

        $this->errorMessage = __('global_exceptions.methodNotAllowed');

        parent::__construct();
    }
}
