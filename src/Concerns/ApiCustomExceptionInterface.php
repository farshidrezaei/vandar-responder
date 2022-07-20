<?php

namespace FarshidRezaei\VandarResponder\Concerns;

use Exception;

interface  ApiCustomExceptionInterface
{
    public function __construct(?Exception $exception);

}
