<?php

namespace App\Repositories\Interfaces\Goal;

interface GoalContract
{
    public function updateGoal(string $userId, string $goalType);

}
