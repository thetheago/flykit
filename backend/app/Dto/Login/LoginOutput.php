<?php

declare(strict_types=1);

namespace App\Dto\Login;

class LoginOutput
{
    public function __construct(
        private string $email,
        private bool $isAdmin,
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getIsAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'isAdmin' => $this->isAdmin,
        ];
    }
}
