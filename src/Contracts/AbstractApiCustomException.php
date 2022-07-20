<?php

namespace FarshidRezaei\VandarResponder\Contracts;

use FarshidRezaei\VandarResponder\Facades\Responder;
use Illuminate\Http\JsonResponse;

abstract class AbstractApiCustomException
{

    protected int|string $errorCode = 500;
    protected ?string $stringErrorCode = '';
    protected ?string $errorMessage = '';
    protected ?array $errors = null;


    public function __construct()
    {
    }

    public function render(): JsonResponse
    {
        return Responder::failure(
            errorCode: $this->getErrorCode(),
            stringErrorCode: $this->getStringErrorCode(),
            message: $this->getErrorMessage(),
            errors: $this->getErrors()

        );
    }

    protected function getErrorCode(): int|string
    {
        return $this->errorCode;
    }

    protected function getStringErrorCode(): ?string
    {
        return $this->stringErrorCode;
    }

    protected function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    protected function getErrors(): ?array
    {
        return $this->errors;
    }

}
