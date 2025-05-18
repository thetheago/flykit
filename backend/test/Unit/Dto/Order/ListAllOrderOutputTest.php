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
                'departureDate' => '2023-01-01',
                'arrivalDate' => '2023-01-05',
                'status' => OrderStatus::REQUESTED,
            ],
            [
                'orderId' => 2,
                'requesterName' => 'Vanelope van swiiits',
                'destination' => 'Ilha doce',
                'departureDate' => '2023-01-02',
                'arrivalDate' => '2023-01-06',
                'status' => OrderStatus::APPROVED,
            ],
            [
                'orderId' => 3,
                'requesterName' => 'Sam marino',
                'destination' => 'Qualquer esquina',
                'departureDate' => '2021-01-03',
                'arrivalDate' => '2023-01-03',
                'status' => OrderStatus::CANCELLED,
            ]
        ];

        $output = new ListAllOrderOutput(
            orders: $orders,
        );

        $this->assertEquals($orders, $output->getOrders());
    }
}
