<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Usecase;

use App\Constants\OrderStatus;
use App\Dto\Order\OrderUpdateInput;
use App\Exception\OrderNotFoundException;
use App\Exception\UserNotFoundException;
use App\Interfaces\OrderAuthorizationValidatorInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Model\Order;
use App\Model\User;
use Hyperf\Testing\TestCase;
use App\Usecase\UpdateOrderUsecase;
use InvalidArgumentException;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;

class UpdateOrderUsecaseTest extends TestCase
{
    private \Mockery\LegacyMockInterface&\Mockery\MockInterface&\App\Interfaces\OrderRepositoryInterface $orderRepository;
    private \Mockery\LegacyMockInterface&\Mockery\MockInterface&\App\Interfaces\UserRepositoryInterface $userRepository;
    private \Mockery\LegacyMockInterface&\Mockery\MockInterface&\App\Interfaces\OrderAuthorizationValidatorInterface $orderAuthorizationValidator;

    public function setUp(): void
    {
        parent::setUp();

        $this->orderRepository = Mockery::mock(OrderRepositoryInterface::class);
        $this->userRepository = Mockery::mock(UserRepositoryInterface::class);
        $this->orderAuthorizationValidator = Mockery::mock(OrderAuthorizationValidatorInterface::class);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public static function orderStatusProvider(): array
    {
        return [
            'approveOrder' => [
                'status' => OrderStatus::APPROVED,
                'methodToCall' => 'approve',
                'expectedStatus' => OrderStatus::APPROVED
            ],
            'requestOrder' => [
                'status' => OrderStatus::REQUESTED,
                'methodToCall' => 'request',
                'expectedStatus' => OrderStatus::REQUESTED
            ],
            'cancelOrder' => [
                'status' => OrderStatus::CANCELLED,
                'methodToCall' => 'cancel',
                'expectedStatus' => OrderStatus::CANCELLED
            ],
        ];
    }

    #[DataProvider('orderStatusProvider')]
    public function testUpdateOrderUsecaseWithDifferentStatuses(
        string $status,
        string $methodToCall,
        string $expectedStatus
    ) {
        $orderModelMock = Mockery::mock(Order::class);
        $orderModelMock->shouldReceive($methodToCall);
        $orderModelMock->shouldReceive('getAttribute')->with('status')->andReturn($expectedStatus);

        $this->orderRepository->shouldReceive('findByOrderId')->andReturn($orderModelMock);
        $this->orderRepository->shouldReceive('update');

        $userModelMock = Mockery::mock(User::class);

        $this->userRepository->shouldReceive('getUserById')->andReturn($userModelMock);

        $this->orderAuthorizationValidator->shouldReceive('validateOrderUpdate')->andReturn(true);

        $updateOrderUsecase = new UpdateOrderUsecase(
            $this->orderRepository,
            $this->userRepository,
            $this->orderAuthorizationValidator
        );
        
        $orderUpdateInputMock = Mockery::mock(OrderUpdateInput::class);
        $orderUpdateInputMock->shouldReceive('getOrderId')->andReturn(1);
        $orderUpdateInputMock->shouldReceive('getUserId')->andReturn(1);
        $orderUpdateInputMock->shouldReceive('getStatus')->andReturn($status);

        $updateOrderUsecase->execute($orderUpdateInputMock);

        $this->assertTrue(true);
    }

    public function testUpdateOrderUsecaseWithOrderNotFound()
    {
        $this->orderRepository->shouldReceive('findByOrderId')->andReturn(null);
        $this->orderRepository->shouldReceive('update');

        $updateOrderUsecase = new UpdateOrderUsecase(
            $this->orderRepository,
            $this->userRepository,
            $this->orderAuthorizationValidator
        );
        
        $orderUpdateInputMock = Mockery::mock(OrderUpdateInput::class);
        $orderUpdateInputMock->shouldReceive('getOrderId')->andReturn(1);
        $orderUpdateInputMock->shouldReceive('getUserId')->andReturn(1);
        $orderUpdateInputMock->shouldReceive('getStatus')->andReturn(OrderStatus::APPROVED);

        $this->expectException(OrderNotFoundException::class);

        $updateOrderUsecase->execute($orderUpdateInputMock);

        $this->assertTrue(true);
    }

    public function testUpdateOrderUsecaseWithUserNotFound()
    {
        $orderModelMock = Mockery::mock(Order::class);

        $this->orderRepository->shouldReceive('findByOrderId')->andReturn($orderModelMock);

        $this->userRepository->shouldReceive('getUserById')->andReturn(null);

        $updateOrderUsecase = new UpdateOrderUsecase(
            $this->orderRepository,
            $this->userRepository,
            $this->orderAuthorizationValidator
        );
        
        $orderUpdateInputMock = Mockery::mock(OrderUpdateInput::class);
        $orderUpdateInputMock->shouldReceive('getOrderId')->andReturn(1);
        $orderUpdateInputMock->shouldReceive('getUserId')->andReturn(1);
        $orderUpdateInputMock->shouldReceive('getStatus')->andReturn(OrderStatus::APPROVED);

        $this->expectException(UserNotFoundException::class);

        $updateOrderUsecase->execute($orderUpdateInputMock);

        $this->assertTrue(true);
    }

    public function testUpdateOrderUsecaseWithInvalidStatus()
    {
        $orderModelMock = Mockery::mock(Order::class);

        $this->orderRepository->shouldReceive('findByOrderId')->andReturn($orderModelMock);

        $userModelMock = Mockery::mock(User::class);

        $this->userRepository->shouldReceive('getUserById')->andReturn($userModelMock);

        $this->orderAuthorizationValidator->shouldReceive('validateOrderUpdate')->andReturn(true);

        $updateOrderUsecase = new UpdateOrderUsecase(
            $this->orderRepository,
            $this->userRepository,
            $this->orderAuthorizationValidator
        );
        
        $status = 'Status qualquer';

        $orderUpdateInputMock = Mockery::mock(OrderUpdateInput::class);
        $orderUpdateInputMock->shouldReceive('getOrderId')->andReturn(1);
        $orderUpdateInputMock->shouldReceive('getUserId')->andReturn(1);
        $orderUpdateInputMock->shouldReceive('getStatus')->andReturn($status);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid status: $status");

        $updateOrderUsecase->execute($orderUpdateInputMock);

        $this->assertTrue(true);
    }
}