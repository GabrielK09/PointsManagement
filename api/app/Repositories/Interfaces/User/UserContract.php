<?php

namespace App\Repositories\Interfaces\User;

use App\Models\User;

interface UserContract
{
    public function store(array $data): User;
    public function update(array $data, int $userId): User;
    public function updateGoal(array $data, int $userId): User;
    public function findById(int $id): ?User;
    public function findByMail(string $email): ?User;
    public function delete(int $userId): void;
}