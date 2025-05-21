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
        $userEmail = 'juniperr@lee.com';
        $userIsAdmin = true;

        $output = new LoginOutput(
            email: $userEmail,
            isAdmin: $userIsAdmin,
            token: $token,
            expirationTime: $expirationTime
        );

        $this->assertEquals($token, $output->getToken());
        $this->assertEquals($expirationTime, $output->getExpirationTime());
        $this->assertEquals($userEmail, $output->getEmail());
        $this->assertEquals($userIsAdmin, $output->getIsAdmin());
    }

    public function testToArray()
    {
        $token = 'ESSA É A LENDA DO KUNG FU PANDAAAAAA!! TUNDUDNUDNDUNDUN.';
        $expirationTime = 100;
        $userEmail = 'po@kungfupanda.com';
        $userIsAdmin = true;

        $output = new LoginOutput(
            email: $userEmail,
            isAdmin: $userIsAdmin,
            token: $token,
            expirationTime: $expirationTime
        );

        $this->assertEquals([
            'email' => $userEmail,
            'isAdmin' => $userIsAdmin,
        ], $output->toArray());
    }
}
