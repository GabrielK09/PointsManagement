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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $req)
    {
        //
    }

    public function updateGoal(UserGoalRequest $req)
    {
        $id = !empty($req->input('user_id')) ? $req->input('user_id') : $req->user()->id;

        return apiSuccess('Meta atualizada com sucesso!', $this->userSerivce->updateGoal($req->validated(), $id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
