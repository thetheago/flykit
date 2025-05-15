<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\LoginRequest;
use Hyperf\Di\Annotation\Inject;
use App\Interfaces\LoginRepositoryInterface;

class AuthController
{
    #[Inject]
    private LoginRepositoryInterface $loginRepository;

    public function login(LoginRequest $request)
    {
        return $this->loginRepository->login($request);
    }
}