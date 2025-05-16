<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Dto;

use App\Dto\Login\LoginOutput;
use PHPUnit\Framework\TestCase;

class LoginOutputTest extends TestCase
{
    public function testDtoWithSuccess()
    {
        $token = 'tokenRandom';

        $output = new LoginOutput(token: $token);

        $this->assertEquals($token, $output->getToken());
    }
}
