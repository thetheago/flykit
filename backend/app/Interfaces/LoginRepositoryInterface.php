<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Request\LoginRequest;

interface LoginRepositoryInterface 
{
    public function login(LoginRequest $request): array;
}
