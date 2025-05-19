<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Factory;

use App\Constants\OrderStatus;
use App\Dto\Order\OrderUpdateOutput;
use App\Factory\OrderUpdateOutputFactory;
use App\Model\Order;
use Carbon\Carbon;
use Mockery;
use PHPUnit\Framework\TestCase;

class OrderUpdateOutputFactoryTest extends TestCase
{
    private OrderUpdateOutputFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->factory = new OrderUpdateOutputFactory();
    }

    public function testCreateFromOrderModelShouldCreateCorrectOutput(): void
    {
        $orderId = 1;
        $requesterName = 'John Doe';
        $destination = 'New York';
        $departureDate = '2024-03-20';
        $arrivalDate = '2024-03-21';
        $status = OrderStatus::APPROVED;

        $orderModelMock = Mockery::mock(Order::class);
        $orderModelMock->shouldReceive('getAttribute')->with('order_id')->andReturn($orderId);
        $orderModelMock->shouldReceive('getAttribute')->with('requester_name')->andReturn($requesterName);
        $orderModelMock->shouldReceive('getAttribute')->with('destination')->andReturn($destination);
        $orderModelMock->shouldReceive('getAttribute')->with('departure_date')->andReturn($departureDate);
        $orderModelMock->shouldReceive('getAttribute')->with('arrival_date')->andReturn($arrivalDate);
        $orderModelMock->shouldReceive('getAttribute')->with('status')->andReturn($status);

        $output = $this->factory->createFromOrderModel($orderModelMock);

        $this->assertInstanceOf(OrderUpdateOutput::class, $output);
        $this->assertSame($orderId, $output->getOrderId());
        $this->assertSame($requesterName, $output->getRequesterName());
        $this->assertSame($destination, $output->getDestination());
        $this->assertEquals(Carbon::parse($departureDate)->format('d-m-Y'), $output->getDepartureDate());
        $this->assertEquals(Carbon::parse($arrivalDate)->format('d-m-Y'), $output->getArrivalDate());
        $this->assertSame($status, $output->getStatus());
    }
} 