<?php

namespace App\Exceptions;

use Exception;

class RedirectExceptions extends Exception
{
    public $redirectTo;
    public $message;
    public $statusCode;

    public function __construct(string $redirectTo, string $message, string $statusCode)
    {
        $this->redirectTo = $redirectTo;
        $this->message = $message;
        $this->statusCode = $statusCode;
    }
}
