<?php

namespace App\Http\Controllers\Goal;

use App\Http\Controllers\Controller;
use App\Services\Goal\GoalService;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function __construct(
        protected GoalService $goalService
    ){}

    public function updateGoal(Request $req, string $goalType)
    {
        $id = !empty($req->input('user_id')) ? $req->input('user_id') : $req->user()->id;

        return apiSuccess('Ponto atualizado com sucesso!', $this->goalService->updateGoal($id, $goalType));
    }
}
