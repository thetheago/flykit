<?php

declare(strict_types=1);

namespace App\OrderState;

use App\Model\Order;
use HyperfTest\Unit\OrderState\OrderStateTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use App\Test\Unit\OrderState\OrderStateTestDataProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;

class OrderStateTransitionsTest extends OrderStateTestCase
{
    private Order $order;

    public function setUp(): void
    {
        parent::setUp();

        $this->order = new Order();
    }

    #[DataProvider('approvedStateTransitionProvider')]
    #[DataProvider('requestedStateTransitionProvider')]
    #[DataProvider('cancelledStateTransitionProvider')]
    public function testStateTransitions(
        string $method,
        string $initialStatus,
        ?string $expectedStatus = null,
        ?string $expectedException = null,
        ?string $expectedExceptionMessage = null
    ) {
        $this->order->status = $initialStatus;
        $this->order->initializeState();

        if ($expectedException) {
            $this->expectException($expectedException);
            $this->expectExceptionMessage($expectedExceptionMessage);
        }

        $this->order->$method();

        if (!$expectedException) {
            $this->assertEquals($expectedStatus, $this->order->status);
            $expectedStateClass = OrderStateFactory::createFromStatus($expectedStatus);
            $stateClass = $this->order->getState();
            $this->assertEquals($expectedStateClass::class, $stateClass::class);
        }
    }
}