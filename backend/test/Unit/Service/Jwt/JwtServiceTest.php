<?php

namespace HyperfTest\Unit\Service\Jwt;

use Hyperf\Testing\TestCase;
use App\Service\Jwt\{JwtToken, JwtService};

class JwtServiceTest extends TestCase
{
    public function testGenerateToken()
    {
        $jwtService = new JwtService();
        $jwtToken = new JwtToken(id: 1, email: 'mario@super.com', isAdmin: true, iat: time());
        $token = $jwtService->generateToken($jwtToken);
        $this->assertNotEmpty($token);
    }
}
