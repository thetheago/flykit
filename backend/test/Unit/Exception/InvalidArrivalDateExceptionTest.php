<?php

namespace App\Exception;

use Hyperf\Testing\TestCase;
use App\Exception\InvalidArrivalDateException;
use Symfony\Component\HttpFoundation\Response;

class InvalidArrivalDateExceptionTest extends TestCase
{
    public function testInvalidArrivalDateException()
    {
        $this->expectException(InvalidArrivalDateException::class);
        throw new InvalidArrivalDateException();
    }

    public function testUserNotFoundExceptionMessage()
    {
        $this->expectException(InvalidArrivalDateException::class);
        $this->expectExceptionMessage('Invalid arrival date. It must be greater than departure date.');
        throw new InvalidArrivalDateException();
    }

    public function testUserNotFoundExceptionCode()
    {
        $this->expectException(InvalidArrivalDateException::class);
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);
        throw new InvalidArrivalDateException();
    }
}
