<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Dto\Order;

use App\Dto\Order\OrderUpdateInput;
use Hyperf\Testing\TestCase;

class OrderUpdateInputTest extends TestCase
{
    public function testOrderUpdateInputDtoWithSuccess()
    {
        $orderId = 1;
        $userId = 1;
        $status = 'approved';

        $input = new OrderUpdateInput(
            orderId: $orderId,
            userId: $userId,
            status: $status,
        );

        $this->assertEquals($orderId, $input->getOrderId());
        $this->assertEquals($userId, $input->getUserId());
        $this->assertEquals($status, $input->getStatus());
    }

    public function testOrderUpdateInputDtoWithOrderIdString()
    {
        $orderId = '1';
        $userId = 1;
        $status = 'approved';

        $input = new OrderUpdateInput(
            orderId: $orderId,
            userId: $userId,
            status: $status,
        );

        $this->assertEquals($orderId, $input->getOrderId());
        $this->assertEquals($userId, $input->getUserId());
        $this->assertEquals($status, $input->getStatus());
    }
}
