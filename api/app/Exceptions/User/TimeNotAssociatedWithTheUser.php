<?php

namespace App\Exceptions\User;

use Exception;

class TimeNotAssociatedWithTheUser extends Exception
{
    public function getStatusCode(): int
    {
        return 404;
    }
}
