<?php

namespace App\Repositories\Eloquent\User;

use App\Enum\UseCase\UserGoal\TypeGoalUpdate;
use App\Models\User;
use App\Repositories\Interfaces\User\UserContract;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserContract
{
    public function store(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'team' => $data['team'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function update(array $data, int $userId): User
    {
        $user = $this->findById($userId);
        $user->update([
            'name' => $data['name'],
            'team' => $data['team'],
            'email' => $data['email']
        ]);

        $user->save();

        return $user;
    }

    public function updateGoal(array $data, int $userId)
    {
        $user = $this->findById($userId);
        
        $map = [
            TypeGoalUpdate::PULLED->value   => 'pulled',
            TypeGoalUpdate::CALLED->value   => 'called',
            TypeGoalUpdate::WHATSAPP->value => 'whatsApp',
            TypeGoalUpdate::INDICATE->value => 'indicate',
            TypeGoalUpdate::XREMOTE->value  => 'xremote',
            TypeGoalUpdate::CHAT->value     => 'chat',
        ];

        if (!isset($map[$data['goal']])) {
            return $user;
        }

        $user->increment(
            $map[$data['goal']],
            $data['value_goal']
        );

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

    public function findById(int $id): ?User
    {
        return User::query()->where('id', $id)->first();
    }

    public function findByMail(string $email): ?User
    {
        return User::query()->where('email', $email)->first();
    }

    public function delete(int $userId): void
    {
        $user = $this->findById($userId);
        $user->delete();
    }
}