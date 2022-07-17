<?php

use FarshidRezaei\VandarResponder\Services\Responder;

if (! function_exists('responder')) {
    /**
     * Generate the URL to a named responder.
     *
     * @return Responder
     */
    function responder(): Responder
    {
        return app('responder');
    }
}
