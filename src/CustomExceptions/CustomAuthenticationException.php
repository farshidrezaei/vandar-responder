<?php

namespace FarshidRezaei\VandarResponder\CustomExceptions;

use Exception;
use FarshidRezaei\VandarResponder\Concerns\ApiCustomExceptionInterface;
use FarshidRezaei\VandarResponder\Contracts\AbstractApiCustomException;
use Illuminate\Http\Response;

class CustomAuthenticationException extends AbstractApiCustomException implements ApiCustomExceptionInterface
{

    public function __construct(?Exception $exception)
    {
        $this->errorCode = Response::HTTP_UNAUTHORIZED;

        $this->stringErrorCode = config('responder.errors.UNAUTHENTICATED_ERROR');

        $this->errorMessage = __('global_exceptions.unauthenticated');

        parent::__construct();
    }
}
