<?php

declare(strict_types=1);

namespace HyperfTest\Unit\OrderState;

use App\Constants\OrderStatus;
use App\OrderState\RequestedOrderState;
use Hyperf\Testing\TestCase;

class RequestedOrderStateTest extends TestCase
{
    public function testGetStatus()
    {
        $requestedOrderState = new RequestedOrderState();
        $this->assertEquals(OrderStatus::REQUESTED, $requestedOrderState->getStatus());
    }
}

