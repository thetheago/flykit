<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\Login\LoginInput;
use App\Request\LoginRequest;

class LoginInputFactory
{
    public function createFromRequest(LoginRequest $request): LoginInput
    {
        $email = $request->input('email');
        $password = $request->input('password');

        return new LoginInput(email: $email, password: $password);
    }
}
