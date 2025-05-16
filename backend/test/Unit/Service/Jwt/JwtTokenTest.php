<?php

declare(strict_types=1);

namespace App\Service\Jwt;

use Hyperf\Testing\TestCase;

class JwtTokenTest extends TestCase
{
    public function testAttributesJwtToken()
    {
        $id = 1;
        $email = 'jogos@mortais.com';
        $iat = time();

        $jwtToken = new JwtToken(id: $id, email: $email, iat: $iat);
        $this->assertEquals($id, $jwtToken->getId());
        $this->assertEquals($email, $jwtToken->getEmail());
        $this->assertEquals($iat, $jwtToken->getIat());
    }

    public function testToArrayJwtToken()
    {
        $id = 1;
        $email = 'patricia@abravanel.com';
        $iat = time();

        $jwtToken = new JwtToken(id: $id, email: $email, iat: $iat);
        $this->assertEquals([
            'id' => $id,
            'email' => $email,
            'iat' => $iat,
        ], $jwtToken->toArray());
    }
}
