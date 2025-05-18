<?php

namespace HyperfTest\Unit\Dto\Order;

use App\Dto\Order\GetOrderInput;
use PHPUnit\Framework\TestCase;

class GetOrderInputTest extends TestCase
{
    public function testCreateGetOrderInput()
    {
        $orderId = 1;
        $userId = 1;
        $input = new GetOrderInput($orderId, $userId);

        $this->assertEquals($orderId, $input->getOrderId());
        $this->assertEquals($userId, $input->getUserId());
    }

    public function testCreateGetOrderInputWithOrderIdAsString()
    {
        $orderId = '1';
        $userId = 1;
        $input = new GetOrderInput($orderId, $userId);

        $this->assertEquals($orderId, $input->getOrderId());
        $this->assertIsInt($input->getOrderId());
        $this->assertEquals($userId, $input->getUserId());
    }
}
