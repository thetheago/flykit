<?php

namespace HyperfTest\Unit\Factory;

use App\Constants\OrderStatus;
use App\Dto\Order\ListAllOrderInput;
use App\Factory\ListAllOrderInputFactory;
use App\Model\User;
use App\Request\ListAllOrderRequest;
use Hyperf\Contract\ContainerInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

class ListAllOrderInputFactoryTest extends TestCase
{
    public function testCreateListAllOrderInput()
    {
        $requestMock = Mockery::mock(ListAllOrderRequest::class);
        $requestMock->shouldReceive('input')->with('status')->andReturn(OrderStatus::REQUESTED);
        $requestMock->shouldReceive('input')->with('departureDate')->andReturn('2025-01-01');
        $requestMock->shouldReceive('input')->with('arrivalDate')->andReturn('2025-01-02');
        $requestMock->shouldReceive('input')->with('destination')->andReturn('To com sede');

        $userMock = Mockery::mock(User::class);
        $userMock->shouldReceive('getAttribute')->with('id')->andReturn(1);

        $containerMock = Mockery::mock(ContainerInterface::class);
        $containerMock->shouldReceive('get')->with('user')->andReturn($userMock);

        $listAllOrderInputFactory = new ListAllOrderInputFactory();
        $listAllOrderInput = $listAllOrderInputFactory->createFromRequest(request: $requestMock, container: $containerMock);

        $this->assertInstanceOf(ListAllOrderInput::class, $listAllOrderInput);
    }
}
