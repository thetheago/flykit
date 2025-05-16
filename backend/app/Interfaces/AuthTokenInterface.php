<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Service\Jwt\JwtToken;

interface AuthTokenInterface
{
    public function generateToken(JwtToken $jwtToken): string;
}
