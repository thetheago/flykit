<?php

declare(strict_types=1);

namespace App\Test\Unit\Dto\Login;

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
