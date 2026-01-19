<?php

namespace App\Repositories\Eloquent\Goal;

use App\Repositories\Interfaces\Goal\GoalContract;
use App\Repositories\Interfaces\User\UserContract;
use Illuminate\Support\Facades\Log;

class GoalRepository implements GoalContract
{
    public function __construct(
        protected UserContract $userRepository
    ){}

    public function updateGoal(string $userId, string $goalType)
    {
        $user = $this->userRepository->findById($userId);

        Log::debug('$goalType += $user->$goalType', [
            'data' => $user->$goalType,
            'goalType' => $goalType

        ]);

        $user->update([
            $user->$goalType += 1
        ]);

        return $user->only([
            'name',
            'team',
            'pulled',
            'called',
            'whatsApp',
            'indicate',
            'xremote',
            'chat',
        ]);
    }
}
