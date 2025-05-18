<?php

declare(strict_types=1);

namespace HyperfTest\Unit\OrderState;

use App\Constants\OrderStatus;
use App\OrderState\CancelledOrderState;
use Hyperf\Testing\TestCase;

class CancelledOrderStateTest extends TestCase
{
    public function testGetStatus()
    {
        $cancelledOrderState = new CancelledOrderState();
        $this->assertEquals(OrderStatus::CANCELLED, $cancelledOrderState->getStatus());
    }
}

