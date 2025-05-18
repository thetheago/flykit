<?php

namespace HyperfTest\Unit\Factory;

use App\Dto\Order\GetOrderOutput;
use App\Factory\GetOrderOutputFactory;
use App\Model\Order;
use Carbon\Carbon;
use Mockery;
use PHPUnit\Framework\TestCase;

class GetOrderOutputFactoryTest extends TestCase
{
    public function testCreateFromOrderModel()
    {
        $orderId = 1;
        $requesterName = 'John Doe';
        $destination = 'New York';
        $departureDate = '2025-01-01';
        $arrivalDate = '2025-01-05';
        $status = 'pending';

        $orderMock = Mockery::mock(Order::class);
        $orderMock->shouldReceive('getAttribute')->with('order_id')->andReturn($orderId);
        $orderMock->shouldReceive('getAttribute')->with('requester_name')->andReturn($requesterName);
        $orderMock->shouldReceive('getAttribute')->with('destination')->andReturn($destination);
        $orderMock->shouldReceive('getAttribute')->with('departure_date')->andReturn($departureDate);
        $orderMock->shouldReceive('getAttribute')->with('arrival_date')->andReturn($arrivalDate);
        $orderMock->shouldReceive('getAttribute')->with('status')->andReturn($status);

        $getOrderOutputFactory = new GetOrderOutputFactory();
        $getOrderOutput = $getOrderOutputFactory->createFromOrderModel($orderMock);

        $this->assertInstanceOf(GetOrderOutput::class, $getOrderOutput);
        $order = $getOrderOutput->getOrder();

        $this->assertEquals($orderId, $order['orderId']);
        $this->assertEquals($requesterName, $order['requesterName']);
        $this->assertEquals($destination, $order['destination']);
        $this->assertEquals($order['departureDate'], Carbon::parse($order['departureDate'])->format('d-m-Y'));
        $this->assertEquals($order['arrivalDate'], Carbon::parse($order['arrivalDate'])->format('d-m-Y'));
    }
}
