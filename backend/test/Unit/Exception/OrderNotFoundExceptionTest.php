<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Exception;

use App\Exception\OrderNotFoundException;
use Hyperf\Testing\TestCase;
use Symfony\Component\HttpFoundation\Response;

class OrderNotFoundExceptionTest extends TestCase
{
    public function testOrderNotFoundException()
    {
        $this->expectException(OrderNotFoundException::class);
        throw new OrderNotFoundException(1);
    }

    public function testOrderNotFoundExceptionMessage()
    {
        $orderId = 1;

        $this->expectException(OrderNotFoundException::class);
        $this->expectExceptionMessage("Order with id $orderId does not exist.");
        throw new OrderNotFoundException($orderId);
    }

    public function testOrderNotFoundExceptionCode()
    {
        $this->expectException(OrderNotFoundException::class);
        $this->expectExceptionCode(Response::HTTP_NOT_FOUND);
        throw new OrderNotFoundException(1);
    }
}
