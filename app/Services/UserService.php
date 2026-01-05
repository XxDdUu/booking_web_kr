<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;
use App\Repositories\FileRepository;


class UserService 
{
    protected UserRepository $user_repo;
    protected FileRepository $file_repo;
    public function __construct(UserRepository $user_repo, FileRepository $file_repo)
    {
        $this->user_repo = $user_repo;
        $this->file_repo = $file_repo;
    }

    public function updateAvatarPath(User $user, string $avatar_path)
    {
        // Nếu bạn muốn, có thể thêm validate format URL ở đây
        if ($user->avatar_path) {
            $this->file_repo->delete($user->avatar_path);
        }

        return $this->user_repo->updateAvatarPath($user, $avatar_path);
    }

    public function updateInfo($user, array $data)
    {
        return $this->user_repo->update($user, $data);
    }
}
