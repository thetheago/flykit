<?php

declare(strict_types=1);

namespace App\Service\Jwt;

class JwtToken
{
    public const EXPIRATION_TIME = 3600;

    public function __construct(
        private int $id,
        private string $email,
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

    public function getExp(): int
    {
        return $this->iat + self::EXPIRATION_TIME;
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
            'exp' => $this->getExp(),
            'iat' => $this->iat,
        ];
    }
}
