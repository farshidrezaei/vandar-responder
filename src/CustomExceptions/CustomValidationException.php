<?php

namespace FarshidRezaei\VandarResponder\CustomExceptions;

use Exception;
use FarshidRezaei\VandarResponder\Concerns\ApiCustomExceptionInterface;
use FarshidRezaei\VandarResponder\Contracts\AbstractApiCustomException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class CustomValidationException extends AbstractApiCustomException implements ApiCustomExceptionInterface
{

    public function __construct(public null|Exception|ValidationException $exception)
    {
        $this->errorCode = Response::HTTP_UNPROCESSABLE_ENTITY;

        $this->stringErrorCode = config('responder.errors.VALIDATION_ERROR');

        $this->errorMessage = __('responder::exceptions.validation');

        $this->errors = collect($exception->errors())->map(fn($error)=> $error[0] )->filter()->toArray();

        parent::__construct();
    }
}
