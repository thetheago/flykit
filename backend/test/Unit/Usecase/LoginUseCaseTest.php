<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Usecase;

use App\Dto\Login\LoginInput;
use App\Dto\Login\LoginOutput;
use App\Exception\WrongAccessAttemptException;
use App\Interfaces\AuthTokenInterface;
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
        $user = new User();
        $user->id = 1;
        $user->email = $email;
        $user->password = $encriptedPassword;
        $userRepositoryMock->shouldReceive('getUserByEmail')->andReturn($user);

        $loginInputMock = Mockery::mock(LoginInput::class);
        $loginInputMock->shouldReceive('getEmail')->andReturn($email);
        $loginInputMock->shouldReceive('getPassword')->andReturn($password);

        $jwtServiceMock = Mockery::mock(AuthTokenInterface::class);
        $jwtServiceMock->shouldReceive('generateToken')->andReturn('token');

        $loginUseCase = new LoginUseCase($userRepositoryMock, $jwtServiceMock);
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

        $jwtServiceMock = Mockery::mock(AuthTokenInterface::class);
        $jwtServiceMock->shouldReceive('generateToken')->andReturn('token');

        $loginUseCase = new LoginUseCase($userRepositoryMock, $jwtServiceMock);
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
        $user = new User();
        $user->id = 1;
        $user->email = $email;
        $user->password = $encriptedPassword;
        $userRepositoryMock->shouldReceive('getUserByEmail')->andReturn($user);

        $loginInputMock = Mockery::mock(LoginInput::class);
        $loginInputMock->shouldReceive('getEmail')->andReturn($email);
        $loginInputMock->shouldReceive('getPassword')->andReturn($wrongPassword);

        $jwtServiceMock = Mockery::mock(AuthTokenInterface::class);
        $jwtServiceMock->shouldReceive('generateToken')->andReturn('token');

        $loginUseCase = new LoginUseCase($userRepositoryMock, $jwtServiceMock);
        $loginUseCase->execute($loginInputMock);
    }
}
