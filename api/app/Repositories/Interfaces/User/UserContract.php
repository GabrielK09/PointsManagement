<?php

namespace App\Repositories\Interfaces\User;

use App\Models\User;

interface UserContract
{
    public function getAllForTeam(string $team);
    public function store(array $data): User;
    public function update(array $data, int $userId): mixed;
    public function updateGoal(array $data, int $userId);
    public function findById(int $id): ?User;
    public function findByMail(string $email): ?User;
    public function delete(int $userId): void;
    public function resetAllGoal(string $team, int $userId);
}