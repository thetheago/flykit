<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Usecase;

use App\Constants\OrderStatus;
use App\Dto\Order\OrderCreateInput;
use App\Dto\Order\OrderCreateOutput;
use App\Exception\DuplicatedOrderNumberException;
use App\Exception\InvalidArrivalDateException;
use App\Interfaces\OrderRepositoryInterface;
use App\Model\Order;
use App\Usecase\CreateOrderUsecase;
use Carbon\Carbon;
use Hyperf\Testing\TestCase;
use Mockery;

class CreateOrderUsecaseTest extends TestCase
{
    public function testCreateOrderUsecaseWithSuccess()
    {
        $orderId = 1;
        $requesterName = 'Rick do rick and morty';
        $destination = 'New York';
        $departureDate = '01-01-2023';
        $arrivalDate = '05-01-2023';
        $status = OrderStatus::REQUESTED;

        $order = new Order();
        $order->order_id = $orderId;
        $order->requester_name = $requesterName;
        $order->destination = $destination;
        $order->departure_date = $departureDate;
        $order->arrival_date = $arrivalDate;
        $order->status = $status;

        $orderRepositoryMock = Mockery::mock(OrderRepositoryInterface::class);
        $orderRepositoryMock->shouldReceive('findByOrderId')->andReturn(null);
        $orderRepositoryMock->shouldReceive('create')->andReturn($order);

        $orderCreateInputMock = Mockery::mock(OrderCreateInput::class);
        $orderCreateInputMock->shouldReceive('getOrderId')->andReturn($orderId);
        $orderCreateInputMock->shouldReceive('getDepartureDate')->andReturn(Carbon::parse($departureDate));
        $orderCreateInputMock->shouldReceive('getArrivalDate')->andReturn(Carbon::parse($arrivalDate));

        $createOrderUsecase = new CreateOrderUsecase($orderRepositoryMock);
        $orderCreateOutput = $createOrderUsecase->execute($orderCreateInputMock);

        $this->assertInstanceOf(OrderCreateOutput::class, $orderCreateOutput);
    }

    public function testCreateOrderUsecaseWithDuplicatedOrderId()
    {
        $orderId = 1;
        $order = new Order();
        $order->order_id = $orderId;

        $orderRepositoryMock = Mockery::mock(OrderRepositoryInterface::class);
        $orderRepositoryMock->shouldReceive('findByOrderId')->andReturn($order);

        $orderCreateInputMock = Mockery::mock(OrderCreateInput::class);
        $orderCreateInputMock->shouldReceive('getOrderId')->andReturn($orderId);

        $createOrderUsecase = new CreateOrderUsecase($orderRepositoryMock);

        $this->expectException(DuplicatedOrderNumberException::class);
        $createOrderUsecase->execute($orderCreateInputMock);
    }

    public function testCreateOrderUsecaseWithInvalidArrivalDate()
    {
        $orderId = 1;
        $departureDate = '01-01-2023';
        $arrivalDate = '05-01-2022';

        $orderRepositoryMock = Mockery::mock(OrderRepositoryInterface::class);
        $orderRepositoryMock->shouldReceive('findByOrderId')->andReturn(null);

        $orderCreateInputMock = Mockery::mock(OrderCreateInput::class);
        $orderCreateInputMock->shouldReceive('getOrderId')->andReturn($orderId);
        $orderCreateInputMock->shouldReceive('getDepartureDate')->andReturn(Carbon::parse($departureDate));
        $orderCreateInputMock->shouldReceive('getArrivalDate')->andReturn(Carbon::parse($arrivalDate));

        $createOrderUsecase = new CreateOrderUsecase($orderRepositoryMock);

        $this->expectException(InvalidArrivalDateException::class);
        $createOrderUsecase->execute($orderCreateInputMock);
    }
}