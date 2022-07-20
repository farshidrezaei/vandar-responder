<?php

namespace FarshidRezaei\VandarResponder\CustomExceptions;

use Exception;
use FarshidRezaei\VandarResponder\Concerns\ApiCustomExceptionInterface;
use FarshidRezaei\VandarResponder\Contracts\AbstractApiCustomException;
use Illuminate\Http\Response;

class CustomThrottleRequestsException extends AbstractApiCustomException implements ApiCustomExceptionInterface
{

    public function __construct(?Exception $exception)
    {
        $this->errorCode = Response::HTTP_TOO_MANY_REQUESTS;

        $this->stringErrorCode = config('responder.errors.TOO_MANY_REQUESTS_ERROR');

        $this->errorMessage = __('global_exceptions.throttleRequests');

        parent::__construct();
    }
}
