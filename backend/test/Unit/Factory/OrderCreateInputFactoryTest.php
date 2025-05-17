<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Factory;

use App\Dto\Order\OrderCreateInput;
use App\Factory\OrderCreateInputFactory;
use App\Request\OrderCreateRequest;
use Hyperf\Testing\TestCase;
use Mockery;

class OrderCreateInputFactoryTest extends TestCase
{
    public function testOrderCreateInputFactoryWithSuccess()
    {
        $orderId = 1;
        $requesterName = 'John Doe';
        $destination = 'New York';
        $departureDate = '01-01-2023';
        $arrivalDate = '05-01-2023';
        $status = 'pending';
        $userId = 1;

        $userMock = Mockery::mock();
        $userMock->id = $userId;

        $this->container->set('user', $userMock);

        $createRequestMock = Mockery::mock(OrderCreateRequest::class);
        $createRequestMock->shouldReceive('input')->with('orderId')->andReturn($orderId);
        $createRequestMock->shouldReceive('input')->with('requesterName')->andReturn($requesterName);
        $createRequestMock->shouldReceive('input')->with('destination')->andReturn($destination);
        $createRequestMock->shouldReceive('input')->with('departureDate')->andReturn($departureDate);
        $createRequestMock->shouldReceive('input')->with('arrivalDate')->andReturn($arrivalDate);
        $createRequestMock->shouldReceive('input')->with('status')->andReturn($status);

        $orderCreateInputFactory = new OrderCreateInputFactory();
        $orderCreateInput = $orderCreateInputFactory->createFromRequest($createRequestMock);

        $this->assertInstanceOf(OrderCreateInput::class, $orderCreateInput);
        $this->assertEquals($orderId, $orderCreateInput->getOrderId());
        $this->assertEquals($requesterName, $orderCreateInput->getRequesterName());
        $this->assertEquals($destination, $orderCreateInput->getDestination());
        $this->assertEquals($departureDate, $orderCreateInput->getDepartureDate()->format('d-m-Y'));
        $this->assertEquals($arrivalDate, $orderCreateInput->getArrivalDate()->format('d-m-Y'));
        $this->assertEquals($status, $orderCreateInput->getStatus());
        $this->assertEquals($userId, $orderCreateInput->getUserId());
    }
}
