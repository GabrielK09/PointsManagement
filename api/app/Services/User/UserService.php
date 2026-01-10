<?php

namespace App\Services\User;

use App\Repositories\Interfaces\User\UserContract;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function __construct(
        protected UserContract $userRepository
    ){}

    public function store(array $data)
    {
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
        return $this->userRepository->findByMail($email);
    }
}