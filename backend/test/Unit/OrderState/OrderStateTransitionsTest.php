<?php

declare(strict_types=1);

namespace App\OrderState;

use App\Model\Order;
use Hyperf\Testing\TestCase;
use HyperfTest\Unit\OrderState\OrderStateTransitionsTestProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;

class OrderStateTransitionsTest extends TestCase
{
    private Order $order;

    public function setUp(): void
    {
        parent::setUp();

        $this->order = new Order();
    }

    #[DataProviderExternal(OrderStateTransitionsTestProvider::class, 'approvedStateTransitionProvider')]
    #[DataProviderExternal(OrderStateTransitionsTestProvider::class, 'requestedStateTransitionProvider')]
    #[DataProviderExternal(OrderStateTransitionsTestProvider::class, 'cancelledStateTransitionProvider')]
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