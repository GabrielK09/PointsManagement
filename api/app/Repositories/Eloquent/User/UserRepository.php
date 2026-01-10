<?php

namespace App\Repositories\Eloquent\User;

use App\Enum\UseCase\UserGoal\TypeGoalUpdate;
use App\Models\User;
use App\Repositories\Interfaces\User\UserContract;
use Illuminate\Support\Facades\Hash;

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

    public function updateGoal(array $data, int $userId): User
    {
        $user = $this->findById($userId);
        
        switch ($data['goal']) {
            case TypeGoalUpdate::PULLED->value:
                $user->update([
                    TypeGoalUpdate::PULLED->value => $user->TypeGoalUpdate::PULLED->value ? $user->pulled + 1 : 1
                ]);

                $user->save();
                break;

            case TypeGoalUpdate::CALLED->value:
                $user->update([
                    TypeGoalUpdate::CALLED->value => $user->TypeGoalUpdate::CALLED->value ? $user->pulled + 1 : 1
                ]);

                $user->save();
                break;

            case TypeGoalUpdate::WHATSAPP->value:
                $user->update([
                    TypeGoalUpdate::WHATSAPP->value => $user->TypeGoalUpdate::WHATSAPP->value ? $user->pulled + 1 : 1
                ]);

                $user->save();
                break;

            case TypeGoalUpdate::INDICATE->value:
                $user->update([
                    TypeGoalUpdate::INDICATE->value => $user->TypeGoalUpdate::INDICATE->value ? $user->pulled + 1 : 1
                ]);

                $user->save();
                break;

            case TypeGoalUpdate::XREMOTE->value:
                $user->update([
                    TypeGoalUpdate::XREMOTE->value => $user->TypeGoalUpdate::XREMOTE->value ? $user->pulled + 1 : 1
                ]);

                $user->save();
                break;

            case TypeGoalUpdate::CHAT->value:
                $user->update([
                    TypeGoalUpdate::CHAT->value => $user->TypeGoalUpdate::CHAT->value ? $user->pulled + 1 : 1
                ]);

                $user->save();
                break;
    
            default:
                return $user;
        }
        return $user;
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