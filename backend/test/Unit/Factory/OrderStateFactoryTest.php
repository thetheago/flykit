<?php

declare(strict_types=1);

namespace HyperfTest\Unit\OrderState;

use App\Constants\OrderStatus;
use App\Factory\OrderStateFactory;
use App\OrderState\{ApprovedOrderState, CancelledOrderState, RequestedOrderState};
use Hyperf\Testing\TestCase;

class OrderStateFactoryTest extends TestCase
{
    public function testCreateFromStatusApproved()
    {
        $orderStateFactory = new OrderStateFactory();
        $orderState = $orderStateFactory->createFromStatus(OrderStatus::APPROVED);
        $this->assertInstanceOf(ApprovedOrderState::class, $orderState);
    }

    public function testCreateFromStatusRequested()
    {
        $orderStateFactory = new OrderStateFactory();
        $orderState = $orderStateFactory->createFromStatus(OrderStatus::REQUESTED);
        $this->assertInstanceOf(RequestedOrderState::class, $orderState);
    }

    public function testCreateFromStatusCancelled()
    {
        $orderStateFactory = new OrderStateFactory();
        $orderState = $orderStateFactory->createFromStatus(OrderStatus::CANCELLED);
        $this->assertInstanceOf(CancelledOrderState::class, $orderState);
    }
}
