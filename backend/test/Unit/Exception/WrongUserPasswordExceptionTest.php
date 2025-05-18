<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Exception;

use App\Exception\WrongUserPasswordException;
use Hyperf\Testing\TestCase;
use Symfony\Component\HttpFoundation\Response;

class WrongUserPasswordExceptionTest extends TestCase
{
    public function testWrongUserPasswordException()
    {
        $this->expectException(WrongUserPasswordException::class);
        throw new WrongUserPasswordException();
    }

    public function testWrongUserPasswordExceptionMessage()
    {
        $this->expectException(WrongUserPasswordException::class);
        $this->expectExceptionMessage('Wrong password.');
        throw new WrongUserPasswordException();
    }

    public function testWrongUserPasswordExceptionCode()
    {
        $this->expectException(WrongUserPasswordException::class);
        $this->expectExceptionCode(Response::HTTP_UNAUTHORIZED);
        throw new WrongUserPasswordException();
    }
}
