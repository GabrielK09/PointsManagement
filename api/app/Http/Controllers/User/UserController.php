<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserGoalRequest;
use App\Http\Requests\User\UserRequest;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userSerivce
    ){}

    public function show(string $id)
    {
        return apiSuccess(null, $this->userSerivce->findById($id));
    }

    public function update(UserRequest $req)
    {
        $id = !empty($req->input('user_id')) ? $req->input('user_id') : $req->user()->id;

        return apiSuccess('Meta atualizada com sucesso!', $this->userSerivce->update($req->validated(), $id));
    }

    public function updateGoal(UserGoalRequest $req)
    {
        $id = !empty($req->input('user_id')) ? $req->input('user_id') : $req->user()->id;

        return apiSuccess('Meta atualizada com sucesso!', $this->userSerivce->updateGoal($req->validated(), $id));
    }

    public function resetAllGoal(Request $req)
    {
        return apiSuccess('Metas zeradas com sucesso!', $this->userSerivce->resetAllGoal($req->user()->team, $req->user()->id));
    }

    public function destroy(string $userId)
    {
        return apiSuccess('Usuário deletado com sucesso!', $this->userSerivce->delete($userId));
    }
}
