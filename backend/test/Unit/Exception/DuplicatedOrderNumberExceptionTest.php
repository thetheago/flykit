<?php

namespace App\Exception;

use Hyperf\Testing\TestCase;
use App\Exception\DuplicatedOrderNumberException;
use Symfony\Component\HttpFoundation\Response;

class DuplicatedOrderNumberExceptionTest extends TestCase
{
    public function testInvalidArrivalDateException()
    {
        $this->expectException(DuplicatedOrderNumberException::class);
        throw new DuplicatedOrderNumberException();
    }

    public function testUserNotFoundExceptionMessage()
    {
        $this->expectException(DuplicatedOrderNumberException::class);
        $this->expectExceptionMessage('Order number already exists.');
        throw new DuplicatedOrderNumberException();
    }

    public function testUserNotFoundExceptionCode()
    {
        $this->expectException(DuplicatedOrderNumberException::class);
        $this->expectExceptionCode(Response::HTTP_CONFLICT);
        throw new DuplicatedOrderNumberException();
    }
}
