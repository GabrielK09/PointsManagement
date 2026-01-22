<?php

namespace App\Exceptions\Auth;

use Exception;

class NotAuthException extends Exception
{
    public function getStatusCode(): int
    {
        return 401;
    }
}
