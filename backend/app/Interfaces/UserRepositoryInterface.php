<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Model\User;

interface UserRepositoryInterface 
{
    public function getUserByEmail(string $email): ?User;
}
