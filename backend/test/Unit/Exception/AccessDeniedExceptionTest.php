<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Exception;

use App\Exception\AccessDeniedException;
use Hyperf\Testing\TestCase;
use Symfony\Component\HttpFoundation\Response;

class AccessDeniedExceptionTest extends TestCase
{
    public function testAccessDeniedException()
    {
        $this->expectException(AccessDeniedException::class);
        throw new AccessDeniedException();
    }

    public function testAccessDeniedExceptionMessage()
    {
        $this->expectException(AccessDeniedException::class);
        $this->expectExceptionMessage('Access denied.');
        throw new AccessDeniedException();
    }

    public function testAccessDeniedExceptionCode()
    {
        $this->expectException(AccessDeniedException::class);
        $this->expectExceptionCode(Response::HTTP_FORBIDDEN);
        throw new AccessDeniedException();
    }
}
