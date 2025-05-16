<?php

namespace App\Service\Jwt;

use Firebase\JWT\JWT;
use function Hyperf\Support\env;

class JwtService
{
    private string $jwtSecretKey;

    public function __construct()
    {
        $this->jwtSecretKey = env('JWT_SECRET_KEY');
    }

    public function generateToken(JwtToken $jwtToken): string
    {
        return JWT::encode(
            payload: $jwtToken->toArray(),
            key: $this->jwtSecretKey,
            alg: 'HS256'
        );
    }
}
