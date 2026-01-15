<?php

namespace App\Exceptions\User;

use Exception;
use Throwable;

class TimeNotAssociatedWithTheUser extends Exception
{
    public function __construct(
        string $message = ""
    ){}

    public function getStatusCode(): int
    {
        return 404;
    }
}
