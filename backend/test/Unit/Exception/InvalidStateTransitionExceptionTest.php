<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Exception;

use App\Exception\InvalidStateTransitionException;
use Hyperf\Testing\TestCase;
use Symfony\Component\HttpFoundation\Response;

class InvalidStateTransitionExceptionTest extends TestCase
{
    public function testInvalidStateTransitionException()
    {
        $this->expectException(InvalidStateTransitionException::class);
        throw new InvalidStateTransitionException('Mensagem de state invalido.');
    }

    public function testInvalidStateTransitionExceptionMessage()
    {
        $message = 'Mensagem de state invalido.';

        $this->expectException(InvalidStateTransitionException::class);
        $this->expectExceptionMessage($message);
        throw new InvalidStateTransitionException($message);
    }

    public function testInvalidStateTransitionExceptionCode()
    {
        $this->expectException(InvalidStateTransitionException::class);
        $this->expectExceptionCode(Response::HTTP_BAD_REQUEST);
        throw new InvalidStateTransitionException('Mensagem de state invalido.');
    }
}
