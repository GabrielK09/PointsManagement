<?php

namespace App\Services\Goal;

use App\Repositories\Interfaces\Goal\GoalContract;

class GoalService
{
    public function __construct(
        protected GoalContract $goalRepository
    ){}


}
