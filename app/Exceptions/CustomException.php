<?php
namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    public function __construct($message = 'Unprocessable Entity', $code = 422)
    {
        parent::__construct($message, $code);
    }
}