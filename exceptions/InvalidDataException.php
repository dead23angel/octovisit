<?php

namespace CWTeam\OctoVisit\Exceptions;

use Exception;

class InvalidDataException extends Exception
{
    /**
     * Exception handling message
     *
     * @var string
     */
    protected $message = 'The incoming data was invalid';

    /**
     * Exception handling status code
     *
     * @var int
     */
    protected $code = 500;
}
