<?php

declare(strict_types=1);

namespace App\Dto\Login;

class LoginOutput
{
    public function __construct(
        private string $token
    ) {
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
