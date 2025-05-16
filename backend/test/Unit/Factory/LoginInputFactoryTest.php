<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Factory;

use App\Dto\Login\LoginInput;
use App\Factory\LoginInputFactory;
use App\Request\LoginRequest;
use Hyperf\Testing\TestCase;
use Mockery;

class LoginInputFactoryTest extends TestCase
{
    public function testLoginInputFactoryWithSuccess()
    {
        $email = 'meliodas@ban.com';
        $password = '123456';

        $loginRequestMock = Mockery::mock(LoginRequest::class);
        $loginRequestMock->shouldReceive('input')->with('email')->andReturn($email);
        $loginRequestMock->shouldReceive('input')->with('password')->andReturn($password);

        $loginInputFactory = new LoginInputFactory();
        $loginInput = $loginInputFactory->createFromRequest($loginRequestMock);

        $this->assertInstanceOf(LoginInput::class, $loginInput);
    }
}
