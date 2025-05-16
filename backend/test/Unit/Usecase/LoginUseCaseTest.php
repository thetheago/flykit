<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Usecase;

use App\Dto\Login\LoginInput;
use App\Dto\Login\LoginOutput;
use App\Exception\WrongAccessAttemptException;
use App\Interfaces\UserRepositoryInterface;
use App\Model\User;
use App\Usecase\LoginUseCase;
use Hyperf\Testing\TestCase;
use Mockery;

class LoginUseCaseTest extends TestCase
{
    public function testLoginUseCaseWithSuccess()
    {

        $email = 'steven@universo.com';
        $password = '123456';
        $encriptedPassword = password_hash($password, PASSWORD_BCRYPT);

        $userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $userRepositoryMock->shouldReceive('getUserByEmail')->andReturn(new User([
            'email' => $email,
            'password' => $encriptedPassword,
        ]));

        $loginInputMock = Mockery::mock(LoginInput::class);
        $loginInputMock->shouldReceive('getEmail')->andReturn($email);
        $loginInputMock->shouldReceive('getPassword')->andReturn($password);

        $loginUseCase = new LoginUseCase($userRepositoryMock);
        $loginOutput = $loginUseCase->execute($loginInputMock);

        $this->assertInstanceOf(LoginOutput::class, $loginOutput);
    }

    public function testLoginUseCaseWithNonExistentUser()
    {
        $this->expectException(WrongAccessAttemptException::class);

        $userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $userRepositoryMock->shouldReceive('getUserByEmail')->andReturn(null);

        $loginInputMock = Mockery::mock(LoginInput::class);
        $loginInputMock->shouldReceive('getEmail')->andReturn('peter@pan.com');
        $loginInputMock->shouldReceive('getPassword')->andReturn('123456');

        $loginUseCase = new LoginUseCase($userRepositoryMock);
        $loginUseCase->execute($loginInputMock);
    }

    public function testLoginUseCaseWithWrongPassword()
    {
        $this->expectException(WrongAccessAttemptException::class);

        $email = 'pater@parker.com';
        $password = '123456';
        $wrongPassword = 'abcdefg';
        $encriptedPassword = password_hash($password, PASSWORD_BCRYPT);

        $userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $userRepositoryMock->shouldReceive('getUserByEmail')->andReturn(new User([
            'email' => $email,
            'password' => $encriptedPassword,
        ]));

        $loginInputMock = Mockery::mock(LoginInput::class);
        $loginInputMock->shouldReceive('getEmail')->andReturn($email);
        $loginInputMock->shouldReceive('getPassword')->andReturn($wrongPassword);

        $loginUseCase = new LoginUseCase($userRepositoryMock);
        $loginUseCase->execute($loginInputMock);
    }
}
