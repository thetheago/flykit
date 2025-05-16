<?php

namespace App\Service\Jwt;

use Hyperf\Testing\TestCase;
use App\Service\Jwt\{JwtToken, JwtService};

class JwtServiceTest extends TestCase
{
    public function testGenerateToken()
    {
        $jwtService = new JwtService();
        $jwtToken = new JwtToken(id: 1, email: 'mario@super.com', iat: time());
        $token = $jwtService->generateToken($jwtToken);
        $this->assertNotEmpty($token);
    }
}
