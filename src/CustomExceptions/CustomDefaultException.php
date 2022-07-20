<?php

namespace FarshidRezaei\VandarResponder\CustomExceptions;

use Exception;
use FarshidRezaei\VandarResponder\Concerns\ApiCustomExceptionInterface;
use FarshidRezaei\VandarResponder\Contracts\AbstractApiCustomException;
use Illuminate\Http\Response;
use Throwable;

class CustomDefaultException extends AbstractApiCustomException implements ApiCustomExceptionInterface
{
    public function __construct(?Exception $exception)
    {
        $this->errorCode = Response::HTTP_INTERNAL_SERVER_ERROR;

        $this->stringErrorCode = config('responder.errors.EXTERNAL_SERVICE_ERROR');

        $this->errorMessage = __('responder::exceptions.generalServerError');

        parent::__construct();
    }
}
