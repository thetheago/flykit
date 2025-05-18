<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Exception;

use App\Exception\WrongAccessAttemptException;
use Hyperf\Testing\TestCase;
use Symfony\Component\HttpFoundation\Response;

class WrongAccessAttemptExceptionTest extends TestCase
{
    public function testWrongAccessAttemptExceptionException()
    {
        $this->expectException(WrongAccessAttemptException::class);
        throw new WrongAccessAttemptException();
    }

    public function testWrongAccessAttemptExceptionMessage()
    {
        $this->expectException(WrongAccessAttemptException::class);
        $this->expectExceptionMessage('Invalid access attempt.');
        throw new WrongAccessAttemptException();
    }

    public function testWrongAccessAttemptExceptionCode()
    {
        $this->expectException(WrongAccessAttemptException::class);
        $this->expectExceptionCode(Response::HTTP_UNAUTHORIZED);
        throw new WrongAccessAttemptException();
    }
}
