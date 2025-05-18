<?php

namespace App\Test\Unit\Usecase;

use App\Dto\Order\GetOrderInput;
use App\Dto\Order\GetOrderOutput;
use App\Exception\OrderNotFoundException;
use App\Exception\UserNotFoundException;
use App\Factory\GetOrderOutputFactory;
use App\Interfaces\{
    OrderRepositoryInterface,
    UserRepositoryInterface,
    OrderAuthorizationValidatorInterface
};
use App\Model\Order;
use App\Model\User;
use App\Usecase\GetOrderUsecase;
use PHPUnit\Framework\TestCase;
use Mockery;

class GetOrderUsecaseTest extends TestCase
{
    public function testGetOrderUsecaseWithSuccess()
    {
        $orderId = 1;
        $userId = 1;
        $input = Mockery::mock(GetOrderInput::class);
        $input->shouldReceive('getOrderId')->andReturn($orderId);
        $input->shouldReceive('getUserId')->andReturn($userId);

        $orderMock = Mockery::mock(Order::class);

        $orderRepositoryMock = Mockery::mock(OrderRepositoryInterface::class);
        $orderRepositoryMock->shouldReceive('findByOrderIdWithCheckUser')->with($orderId, $userId)->andReturn($orderMock);

        $userMock = Mockery::mock(User::class);

        $userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $userRepositoryMock->shouldReceive('getUserById')->with($userId)->andReturn($userMock);

        $orderAuthorizationValidatorMock = Mockery::mock(OrderAuthorizationValidatorInterface::class);
        $orderAuthorizationValidatorMock->shouldReceive('canUserListAllOrders')->with($userMock)->andReturn(false);

        $getOrderOutputFactoryMock = Mockery::mock(GetOrderOutputFactory::class);
        $getOrderOutputFactoryMock->shouldReceive('createFromOrderModel')->with($orderMock);

        $usecase = new GetOrderUsecase(
            orderRepository: $orderRepositoryMock,
            userRepository: $userRepositoryMock,
            orderAuthorizationValidator: $orderAuthorizationValidatorMock,
            getOrderOutputFactory: $getOrderOutputFactoryMock
        );
        $output = $usecase->execute($input);

        $this->assertInstanceOf(GetOrderOutput::class, $output);
    }

    public function testGetOrderUsecaseWithUserAdmin()
    {
        $orderId = 1;
        $userId = 1;
        $input = Mockery::mock(GetOrderInput::class);
        $input->shouldReceive('getOrderId')->andReturn($orderId);
        $input->shouldReceive('getUserId')->andReturn($userId);

        $orderMock = Mockery::mock(Order::class);

        $orderRepositoryMock = Mockery::mock(OrderRepositoryInterface::class);
        $orderRepositoryMock->shouldReceive('findByOrderId')->with($orderId)->andReturn($orderMock);

        $userMock = Mockery::mock(User::class);

        $userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $userRepositoryMock->shouldReceive('getUserById')->with($userId)->andReturn($userMock);

        $orderAuthorizationValidatorMock = Mockery::mock(OrderAuthorizationValidatorInterface::class);
        $orderAuthorizationValidatorMock->shouldReceive('canUserListAllOrders')->with($userMock)->andReturn(true);

        $getOrderOutputFactoryMock = Mockery::mock(GetOrderOutputFactory::class);
        $getOrderOutputFactoryMock->shouldReceive('createFromOrderModel')->with($orderMock);

        $usecase = new GetOrderUsecase(
            orderRepository: $orderRepositoryMock,
            userRepository: $userRepositoryMock,
            orderAuthorizationValidator: $orderAuthorizationValidatorMock,
            getOrderOutputFactory: $getOrderOutputFactoryMock
        );
        $output = $usecase->execute($input);

        $this->assertInstanceOf(GetOrderOutput::class, $output);
    }

    public function testGetOrderUsecaseWithUserNotFound()
    {
        $orderId = 1;
        $userId = 1;
        $input = Mockery::mock(GetOrderInput::class);
        $input->shouldReceive('getOrderId')->andReturn($orderId);
        $input->shouldReceive('getUserId')->andReturn($userId);

        $orderAuthorizationValidatorMock = Mockery::mock(OrderAuthorizationValidatorInterface::class);
        $getOrderOutputFactoryMock = Mockery::mock(GetOrderOutputFactory::class);
        $orderRepositoryMock = Mockery::mock(OrderRepositoryInterface::class);
        $userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $userRepositoryMock->shouldReceive('getUserById')->with($userId)->andReturn(null);


        $usecase = new GetOrderUsecase(
            orderRepository: $orderRepositoryMock,
            userRepository: $userRepositoryMock,
            orderAuthorizationValidator: $orderAuthorizationValidatorMock,
            getOrderOutputFactory: $getOrderOutputFactoryMock
        );

        $this->expectException(UserNotFoundException::class);

        $usecase->execute($input);
    }

    public function testGetOrderUsecaseWithOrderNotFound()
    {
        $orderId = 1;
        $userId = 1;
        $input = Mockery::mock(GetOrderInput::class);
        $input->shouldReceive('getOrderId')->andReturn($orderId);
        $input->shouldReceive('getUserId')->andReturn($userId);

        $orderRepositoryMock = Mockery::mock(OrderRepositoryInterface::class);
        $orderRepositoryMock->shouldReceive('findByOrderIdWithCheckUser')->with($orderId, $userId)->andReturn(null);

        $userMock = Mockery::mock(User::class);

        $userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $userRepositoryMock->shouldReceive('getUserById')->with($userId)->andReturn($userMock);

        $orderAuthorizationValidatorMock = Mockery::mock(OrderAuthorizationValidatorInterface::class);
        $orderAuthorizationValidatorMock->shouldReceive('canUserListAllOrders')->with($userMock)->andReturn(false);

        $getOrderOutputFactoryMock = Mockery::mock(GetOrderOutputFactory::class);

        $usecase = new GetOrderUsecase(
            orderRepository: $orderRepositoryMock,
            userRepository: $userRepositoryMock,
            orderAuthorizationValidator: $orderAuthorizationValidatorMock,
            getOrderOutputFactory: $getOrderOutputFactoryMock
        );

        $this->expectException(OrderNotFoundException::class);

        $usecase->execute($input);
    }
}
