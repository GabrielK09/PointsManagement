<?php

namespace App\Services\User;

use App\Exceptions\User\TimeNotAssociatedWithTheUser;
use App\Repositories\Interfaces\User\UserContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\UnauthorizedException;
class UserService
{
    public function __construct(
        protected UserContract $userRepository
    ){}

    public function store(array $data, string $userId)
    {
        $user = $this->findById($userId);

        if(!$user->is_a_leader)
        {
            throw new UnauthorizedException('Ação não permetida para esse usuário!');
        }

        return DB::transaction(fn() => $this->userRepository->store($data));
    }

    public function update(array $data, int $userId)
    {
        return DB::transaction(fn() => $this->userRepository->update($data, $userId));
    }

    public function updateGoal(array $data, int $userId)
    {
        return DB::transaction(fn() => $this->userRepository->updateGoal($data, $userId));
    }

    public function findById($userId)
    {
        return $this->userRepository->findById($userId);
    }

    public function findByMail($email)
    {
        $user = $this->userRepository->findByMail($email);

        if(!$user)
        {
            throw new \App\Exceptions\User\IncorrectCredentials('Credenciais incorretas.');
        }

        return $user;
    }

    public function resetAllGoal(string $team, int $userId)
    {
        $user = $this->findById($userId);

        if(!$user->is_a_leader)
        {
            throw new UnauthorizedException('Ação não permetida para esse usuário!');
        }

        if($user->team !== $team)
        {
            throw new TimeNotAssociatedWithTheUser('Time diferente do usuário!');
        }

        return DB::transaction(fn() => $this->userRepository->resetAllGoal($team, $userId));
    }

    public function delete(string $userId)
    {
        return DB::transaction(fn() => $this->userRepository->delete($userId));
    }
}
