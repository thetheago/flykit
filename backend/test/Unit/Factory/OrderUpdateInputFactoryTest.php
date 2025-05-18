<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Factory;

use App\Constants\OrderStatus;
use App\Dto\Order\OrderUpdateInput;
use App\Factory\OrderUpdateInputFactory;
use App\Request\OrderUpdateRequest;
use Hyperf\Testing\TestCase;
use Mockery;

class OrderUpdateInputFactoryTest extends TestCase
{
    public function testOrderUpdateInputFactoryWithSuccess()
    {
        $orderId = 1;
        $userId = 1;
        $status = OrderStatus::APPROVED;

        $userMock = Mockery::mock();
        $userMock->id = $userId;

        $this->container->set('user', $userMock);

        $updateRequestMock = Mockery::mock(OrderUpdateRequest::class);
        $updateRequestMock->shouldReceive('route')->with('orderId')->andReturn($orderId);
        $updateRequestMock->shouldReceive('input')->with('status')->andReturn($status);

        $orderUpdateInputFactory = new OrderUpdateInputFactory();
        $orderUpdateInput = $orderUpdateInputFactory->createFromRequest($updateRequestMock);

        $this->assertInstanceOf(OrderUpdateInput::class, $orderUpdateInput);
    }
}
