<?php

namespace HyperfTest\Unit\Factory;

use App\Dto\Order\GetOrderInput;
use App\Factory\GetOrderInputFactory;
use PHPUnit\Framework\TestCase;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Contract\ContainerInterface;
use Mockery;
use stdClass;

class GetOrderInputFactoryTest extends TestCase
{
    public function testCreateFromOrderModel()
    {
        $orderId = 1;
        $userId = 1;

        $requestMock = Mockery::mock(RequestInterface::class);
        $requestMock->shouldReceive('route')->with('orderId')->andReturn($orderId);

        $userMock = new stdClass();
        $userMock->id = $userId;

        $containerMock = Mockery::mock(ContainerInterface::class);
        $containerMock->shouldReceive('get')->with('user')->andReturn($userMock);

        $getOrderInputFactory = new GetOrderInputFactory();
        $getOrderInput = $getOrderInputFactory->createFromRequest($requestMock, $containerMock);

        $this->assertInstanceOf(GetOrderInput::class, $getOrderInput);
    }

    public function testCreateFromOrderModelWithOrderIdAsString()
    {
        $orderId = '1';
        $userId = 1;

        $requestMock = Mockery::mock(RequestInterface::class);
        $requestMock->shouldReceive('route')->with('orderId')->andReturn($orderId);

        $userMock = new stdClass();
        $userMock->id = $userId;

        $containerMock = Mockery::mock(ContainerInterface::class);
        $containerMock->shouldReceive('get')->with('user')->andReturn($userMock);

        $getOrderInputFactory = new GetOrderInputFactory();
        $getOrderInput = $getOrderInputFactory->createFromRequest($requestMock, $containerMock);

        $this->assertInstanceOf(GetOrderInput::class, $getOrderInput);
        $this->assertIsInt($getOrderInput->getOrderId());
    }
}
