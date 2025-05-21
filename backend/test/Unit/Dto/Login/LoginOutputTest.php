<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Dto\Login;

use App\Dto\Login\LoginOutput;
use PHPUnit\Framework\TestCase;

class LoginOutputTest extends TestCase
{
    public function testDtoWithSuccess()
    {
        $token = 'tokenRandom';
        $expirationTime = 100;
        $output = new LoginOutput(token: $token, expirationTime: $expirationTime);

        $this->assertEquals($token, $output->getToken());
        $this->assertEquals($expirationTime, $output->getExpirationTime());
    }
}
