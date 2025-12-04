<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function createUser(array $data): User
    {
        return User::create($data);
    }
    public function updateAvatarUrl(User $user, string $avatarPath): User
    {
        $user->avatar_url = $avatarPath;
        $user->save();
        return $user;
    }
    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }
}
