<?php

declare(strict_types=1);

namespace App\Service\Jwt;

class JwtToken
{
    public function __construct(
        private int $id,
        private string $email,
        private bool $isAdmin,
        private int $iat,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getIsAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function getIat(): int
    {
        return $this->iat;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'isAdmin' => $this->isAdmin,
            'iat' => $this->iat,
        ];
    }
}
