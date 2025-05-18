<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Model\User;

class UserRepository implements UserRepositoryInterface
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUserByEmail(string $email): ?User
    {
        return $this->user->where('email', $email)->first();
    }

    public function getUserById(int $userId): ?User
    {
        return $this->user->find($userId);
    }
}
