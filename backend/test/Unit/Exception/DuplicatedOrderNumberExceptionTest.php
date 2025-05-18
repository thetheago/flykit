<?php

namespace HyperfTest\Unit\Exception;

use Hyperf\Testing\TestCase;
use App\Exception\DuplicatedOrderNumberException;
use Symfony\Component\HttpFoundation\Response;

class DuplicatedOrderNumberExceptionTest extends TestCase
{
    public function testDuplicatedOrderNumberException()
    {
        $this->expectException(DuplicatedOrderNumberException::class);
        throw new DuplicatedOrderNumberException();
    }

    public function testDuplicatedOrderNumberExceptionMessage()
    {
        $this->expectException(DuplicatedOrderNumberException::class);
        $this->expectExceptionMessage('Order number already exists.');
        throw new DuplicatedOrderNumberException();
    }

    public function testDuplicatedOrderNumberExceptionCode()
    {
        $this->expectException(DuplicatedOrderNumberException::class);
        $this->expectExceptionCode(Response::HTTP_CONFLICT);
        throw new DuplicatedOrderNumberException();
    }
}
