<?php

namespace FarshidRezaei\VandarResponder\CustomExceptions;

use Exception;
use FarshidRezaei\VandarResponder\Concerns\ApiCustomExceptionInterface;
use FarshidRezaei\VandarResponder\Contracts\AbstractApiCustomException;
use Illuminate\Http\Response;

class CustomNotFoundHttpException extends AbstractApiCustomException implements ApiCustomExceptionInterface
{
    public function __construct(?Exception $exception)
    {
        $this->errorCode = Response::HTTP_NOT_FOUND;

        $this->stringErrorCode = config('responder.errors.NOT_FOUND_ERROR');

        $this->errorMessage = __('responder::exceptions.modelNotFound');

        parent::__construct();
    }
}
