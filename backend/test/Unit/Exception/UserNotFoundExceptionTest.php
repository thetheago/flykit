<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Exception;

use App\Exception\UserNotFoundException;
use Hyperf\Testing\TestCase;
use Symfony\Component\HttpFoundation\Response;

class UserNotFoundExceptionTest extends TestCase
{
    public function testUserNotFoundExceptionException()
    {
        $this->expectException(UserNotFoundException::class);
        throw new UserNotFoundException();
    }

    public function testUserNotFoundExceptionMessage()
    {
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage('Usuário não encontrado.');
        throw new UserNotFoundException();
    }

    public function testUserNotFoundExceptionCode()
    {
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);
        throw new UserNotFoundException();
    }
}
