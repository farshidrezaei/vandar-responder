<?php

namespace FarshidRezaei\VandarResponder\CustomExceptions;

use FarshidRezaei\VandarResponder\Concerns\ApiCustomExceptionInterface;
use FarshidRezaei\VandarResponder\Contracts\AbstractApiCustomException;
use Illuminate\Http\Response;
use Throwable;

class CustomUnexpectedException extends AbstractApiCustomException implements ApiCustomExceptionInterface
{
    /**
     * CustomUnexpectedException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param null $previous
     */
    public function __construct(Throwable $exception)
    {
        parent::__construct($exception);
        $this->exception = $exception;
    }

    /**
     * @param $code
     *
     * @return $this|CustomUnauthorizedException
     */
    public function setCode($code = null)
    {
        $this->code = $code ? $code : Response::HTTP_INTERNAL_SERVER_ERROR;

        return $this;
    }

    /**
     * @param $message
     *
     * @return $this|CustomUnauthorizedException
     */
    public function setMessage($message = null)
    {
        $this->message = !empty($message) ? $message : trans('errors::errors.unexpected');
        return $this;
    }
}
