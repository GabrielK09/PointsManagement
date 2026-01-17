<?php

namespace App\Services\Goal;

use App\Enum\Goal\GoalTypes;
use App\Exceptions\Goal\GoalTypeNotFound;
use App\Repositories\Interfaces\Goal\GoalContract;
use Illuminate\Support\Facades\DB;

class GoalService
{
    public function __construct(
        protected GoalContract $goalRepository
    ){}

    public function updateGoal(string $userId, string $goalType)
    {
        $map = [
            'pulled' => GoalTypes::PULLED->value,
            'called' => GoalTypes::CALLED->value,
            'whatsApp' => GoalTypes::WHATSAPP->value,
            'indicate' => GoalTypes::INDICATE->value,
            'xremote' => GoalTypes::XREMOTE->value,
            'chat' => GoalTypes::CHAT->value,
        ];

        if(!array_key_exists($goalType, $map))
        {
            throw new GoalTypeNotFound('Meta não especificada.');
        }

        return DB::transaction(fn() => $this->goalRepository->updateGoal($userId, $goalType));
    }
}
