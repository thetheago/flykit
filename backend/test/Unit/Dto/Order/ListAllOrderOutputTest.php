<?php

namespace HyperfTest\Unit\Dto\Order;

use App\Dto\Order\ListAllOrderOutput;
use App\Constants\OrderStatus;
use PHPUnit\Framework\TestCase;

class ListAllOrderOutputTest extends TestCase
{
    public function testOrderCreateOutputDtoWithSuccess()
    {
        $orders = [
            [
                'orderId' => 1,
                'requesterName' => 'Lula molusco',
                'destination' => 'Fenda do biquini',
                'departureDate' => '01-01-2023',
                'arrivalDate' => '05-01-2023',
                'status' => OrderStatus::REQUESTED,
            ],
            [
                'orderId' => 2,
                'requesterName' => 'Vanelope van swiiits',
                'destination' => 'Ilha doce',
                'departureDate' => '02-01-2023',
                'arrivalDate' => '06-01-2023',
                'status' => OrderStatus::APPROVED,
            ],
            [
                'orderId' => 3,
                'requesterName' => 'Sam marino',
                'destination' => 'Qualquer esquina',
                'departureDate' => '03-01-2023',
                'arrivalDate' => '07-01-2023',
                'status' => OrderStatus::CANCELLED,
            ]
        ];

        $output = new ListAllOrderOutput(
            orders: $orders,
        );

        $this->assertEquals($orders, $output->getOrders());
    }
}
