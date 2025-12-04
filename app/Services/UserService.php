<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Http\UploadedFile;

class UserService 
{
    protected UserRepository $repo;

    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function updateAvatarUrl($user, string $avatarUrl)
    {
        // Nếu bạn muốn, có thể thêm validate format URL ở đây
        return $this->repo->updateAvatarUrl($user, $avatarUrl);
    }

    public function updateInfo($user, array $data)
    {
        return $this->repo->update($user, $data);
    }
}
