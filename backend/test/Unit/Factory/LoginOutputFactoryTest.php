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
    $jwtTokenMock = Mockery::mock(JwtToken::class);
    $jwtTokenMock->shouldReceive('getExp');

    $loginOutputFactory = new LoginOutputFactory();
    $loginOutput = $loginOutputFactory->createFromLoginUseCase($jwtTokenMock, 'tokenQualquer');

    $this->assertInstanceOf($loginOutput, LoginOutput::class);
}
