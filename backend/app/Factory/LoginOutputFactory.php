<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\Login\LoginOutput;
use App\Service\Jwt\JwtToken;

class LoginOutputFactory
{
    public function createFromLoginUseCase(bool $userIsAdmin, JwtToken $tokenPayload, string $token): LoginOutput
    {
        return new LoginOutput(
            email: $tokenPayload->getEmail(),
            isAdmin: $userIsAdmin,
            token: $token,
            expirationTime: $tokenPayload->getExp(),
        );
    }
}