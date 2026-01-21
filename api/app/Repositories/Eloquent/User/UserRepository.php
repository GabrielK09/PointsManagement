<?php

namespace App\Repositories\Eloquent\User;

use App\Enum\UseCase\UserGoal\TypeGoalUpdate;
use App\Models\User;
use App\Repositories\Interfaces\User\UserContract;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserContract
{
    public function getAllForTeam(string $team)
    {
        return User::where('team', $team)
                        ->select(
                            'id',
                            'name',
                            'is_a_leader',
                            'pulled',
                            'called',
                            'whatsApp',
                            'indicate',
                            'xremote',
                            'chat',
                        )
                        ->get();

    }
    
    public function store(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'team' => $data['team'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function update(array $data, int $userId): mixed
    {
        $user = $this->findById($userId);

        $user->update([
            'name' => $data['name'],
            'team' => $data['team'],
            'email' => $data['email']
        ]);

        return $user->only([
            'id',
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

    public function updateGoal(array $data, int $userId)
    {
        $user = $this->findById($userId);

        $user->update([
            'pulled' => (int) $data['pulled'],
            'called' => (int) $data['called'],
            'whatsApp' => (int) $data['whatsApp'],
            'indicate' => (int) $data['indicate'],
            'xremote' => (int) $data['xremote'],
            'chat' => (int) $data['chat'],
        ]);

        Log::debug($user);

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
        return User::find($id);
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

    public function resetAllGoal(string $team, int $userId)
    {
        $users = User::query()->where('team', $team)->get();

        foreach ($users as $user) {
            $user->update([
                'pulled' => 0,
                'called' => 0,
                'whatsApp' => 0,
                'indicate' => 0,
                'xremote' => 0,
                'chat' => 0,
            ]);
        }

        return $users->only([
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
}
