<?php

namespace HyperfTest\Unit\Dto\Order;

use App\Constants\OrderStatus;
use App\Dto\Order\GetOrderOutput;
use App\Model\Order;
use PHPUnit\Framework\TestCase;

class GetOrderOutputTest extends TestCase
{
    public function testCreateGetOrderOutput()
    {
        $order = [
            'orderId' => 1,
            'requesterName' => 'Semáforo',
            'destination' => 'Sol',
            'status' => OrderStatus::REQUESTED,
            'departureDate' => '01-01-2025',
            'arrivalDate' => '05-01-2025'
        ];
        $output = new GetOrderOutput($order);

        $this->assertEquals($order, $output->getOrder());
    }
}
