<?php

namespace Sammyjo20\Saloon\Exceptions;

use \Exception;

class NoMockedRequestsFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('You have not defined a mock request or you have not defined enough for the number of requests being made');
    }
}
