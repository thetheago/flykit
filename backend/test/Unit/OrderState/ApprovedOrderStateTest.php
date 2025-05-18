<?php

declare(strict_types=1);

namespace HyperfTest\Unit\OrderState;

use App\Constants\OrderStatus;
use App\OrderState\ApprovedOrderState;
use Hyperf\Testing\TestCase;

class ApprovedOrderStateTest extends TestCase
{
    public function testGetStatus()
    {
        $approvedOrderState = new ApprovedOrderState();
        $this->assertEquals(OrderStatus::APPROVED, $approvedOrderState->getStatus());
    }
}

