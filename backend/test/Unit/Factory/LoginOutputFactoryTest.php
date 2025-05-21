<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Factory;

use Hyperf\Testing\TestCase;
use App\Factory\LoginOutputFactory;
use App\Dto\Login\LoginOutput;
use App\Service\Jwt\JwtToken;
use Mockery;

class LoginOutputFactoryTest extends TestCase
{
    public function testCreateFromLoginUseCase()
    {
        $jwtTokenMock = Mockery::mock(JwtToken::class);
        $jwtTokenMock->shouldReceive('getExp');
        $jwtTokenMock->shouldReceive('getEmail');
        $jwtTokenMock->shouldReceive('getIsAdmin');

        $loginOutputFactory = new LoginOutputFactory();
        $loginOutput = $loginOutputFactory->createFromLoginUseCase(
            tokenPayload: $jwtTokenMock,
            token: 'tokenQualquer'
        );

        $this->assertInstanceOf(LoginOutput::class, $loginOutput);
    }
}
