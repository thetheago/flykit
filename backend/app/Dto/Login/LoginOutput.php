<?php

declare(strict_types=1);

namespace App\Dto\Login;

class LoginOutput
{
    public function __construct(
        private string $token,
        private int $expirationTime,
    ) {
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getExpirationTime(): int
    {
        return $this->expirationTime;
    }
}
