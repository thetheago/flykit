<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Usecase;

use App\Constants\OrderStatus;
use App\Dto\Order\OrderUpdateInput;
use App\Dto\Order\OrderUpdateOutput;
use App\Exception\OrderNotFoundException;
use App\Exception\UserNotFoundException;
use App\Factory\OrderUpdateOutputFactory;
use App\Interfaces\OrderAuthorizationValidatorInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Model\Order;
use App\Model\User;
use App\Service\AmqpMailSender;
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
    private \Mockery\LegacyMockInterface&\Mockery\MockInterface&\App\Factory\OrderUpdateOutputFactory $orderUpdateOutputFactory;
    private \Mockery\LegacyMockInterface&\Mockery\MockInterface&\App\Service\AmqpMailSender $amqpMailSender;

    public function setUp(): void
    {
        parent::setUp();

        $this->orderRepository = Mockery::mock(OrderRepositoryInterface::class);
        $this->userRepository = Mockery::mock(UserRepositoryInterface::class);
        $this->orderAuthorizationValidator = Mockery::mock(OrderAuthorizationValidatorInterface::class);
        $this->orderUpdateOutputFactory = Mockery::mock(OrderUpdateOutputFactory::class);
        $this->amqpMailSender = Mockery::mock(AmqpMailSender::class);
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
        $this->orderRepository->shouldReceive('update')->andReturn($orderModelMock);

        $userModelMock = Mockery::mock(User::class);

        $this->userRepository->shouldReceive('getUserById')->andReturn($userModelMock);

        $this->orderAuthorizationValidator->shouldReceive('validateOrderUpdate')->andReturn(true);

        $orderUpdateOutputMock = Mockery::mock(OrderUpdateOutput::class);

        $this->orderUpdateOutputFactory->shouldReceive('createFromOrderModel')->andReturn($orderUpdateOutputMock);

        $updateOrderUsecase = new UpdateOrderUsecase(
            $this->orderRepository,
            $this->userRepository,
            $this->orderAuthorizationValidator,
            $this->orderUpdateOutputFactory,
            $this->amqpMailSender
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

        $orderUpdateOutputMock = Mockery::mock(OrderUpdateOutput::class);

        $this->orderUpdateOutputFactory->shouldReceive('createFromOrderModel')->andReturn($orderUpdateOutputMock);

        $updateOrderUsecase = new UpdateOrderUsecase(
            $this->orderRepository,
            $this->userRepository,
            $this->orderAuthorizationValidator,
            $this->orderUpdateOutputFactory,
            $this->amqpMailSender
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

        $orderUpdateOutputMock = Mockery::mock(OrderUpdateOutput::class);

        $this->orderUpdateOutputFactory->shouldReceive('createFromOrderModel')->andReturn($orderUpdateOutputMock);

        $updateOrderUsecase = new UpdateOrderUsecase(
            $this->orderRepository,
            $this->userRepository,
            $this->orderAuthorizationValidator,
            $this->orderUpdateOutputFactory,
            $this->amqpMailSender
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
        $status = 'Status qualquer';

        $orderModelMock = Mockery::mock(Order::class);
        $orderModelMock->shouldReceive('getAttribute')->with('status')->andReturn($status);

        $this->orderRepository->shouldReceive('findByOrderId')->andReturn($orderModelMock);

        $userModelMock = Mockery::mock(User::class);

        $this->userRepository->shouldReceive('getUserById')->andReturn($userModelMock);
        

        $this->orderAuthorizationValidator->shouldReceive('validateOrderUpdate')->andReturn(true);

        $orderUpdateOutputMock = Mockery::mock(OrderUpdateOutput::class);

        $this->orderUpdateOutputFactory->shouldReceive('createFromOrderModel')->andReturn($orderUpdateOutputMock);

        $updateOrderUsecase = new UpdateOrderUsecase(
            $this->orderRepository,
            $this->userRepository,
            $this->orderAuthorizationValidator,
            $this->orderUpdateOutputFactory,
            $this->amqpMailSender
        );

        $orderUpdateInputMock = Mockery::mock(OrderUpdateInput::class);
        $orderUpdateInputMock->shouldReceive('getOrderId')->andReturn(1);
        $orderUpdateInputMock->shouldReceive('getUserId')->andReturn(1);
        $orderUpdateInputMock->shouldReceive('getStatus')->andReturn($status);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid status: $status");

        $updateOrderUsecase->execute($orderUpdateInputMock);

        $this->assertTrue(true);
    }

    public function testUpdateOrderUsecaseWithMailNotificationRequestedToApproved()
    {
        $orderModelMock = Mockery::mock(Order::class);
        $orderModelMock->shouldReceive('approve');
        $orderModelMock->shouldReceive('getAttribute')->with('status')->andReturn(OrderStatus::REQUESTED);

        $orderModelMockAfterUpdate = Mockery::mock(Order::class);
        $orderModelMockAfterUpdate->shouldReceive('getAttribute')->with('status')->andReturn(OrderStatus::APPROVED);

        $this->orderRepository->shouldReceive('findByOrderId')->andReturn($orderModelMock);
        $this->orderRepository->shouldReceive('update')->andReturn($orderModelMockAfterUpdate);

        $userModelMock = Mockery::mock(User::class);
        $userModelMock->shouldReceive('getAttribute')->with('email')->andReturn('lilo@stitch.com');

        $this->userRepository->shouldReceive('getUserById')->andReturn($userModelMock);

        $this->orderAuthorizationValidator->shouldReceive('validateOrderUpdate')->andReturn(true);

        $orderUpdateOutputMock = Mockery::mock(OrderUpdateOutput::class);

        $this->orderUpdateOutputFactory->shouldReceive('createFromOrderModel')->andReturn($orderUpdateOutputMock);

        $this->amqpMailSender->shouldReceive('sendMail');

        $updateOrderUsecase = new UpdateOrderUsecase(
            $this->orderRepository,
            $this->userRepository,
            $this->orderAuthorizationValidator,
            $this->orderUpdateOutputFactory,
            $this->amqpMailSender
        );
        
        $orderUpdateInputMock = Mockery::mock(OrderUpdateInput::class);
        $orderUpdateInputMock->shouldReceive('getOrderId')->andReturn(1);
        $orderUpdateInputMock->shouldReceive('getUserId')->andReturn(1);
        $orderUpdateInputMock->shouldReceive('getStatus')->andReturn(OrderStatus::APPROVED);

        $updateOrderUsecase->execute($orderUpdateInputMock);

        $this->amqpMailSender->shouldHaveReceived('sendMail');
        $this->assertTrue(true);
    }

    public function testUpdateOrderUsecaseWithMailNotificationRequestedToCancelled()
    {
        $orderModelMock = Mockery::mock(Order::class);
        $orderModelMock->shouldReceive('cancel');
        $orderModelMock->shouldReceive('getAttribute')->with('status')->andReturn(OrderStatus::REQUESTED);

        $orderModelMockAfterUpdate = Mockery::mock(Order::class);
        $orderModelMockAfterUpdate->shouldReceive('getAttribute')->with('status')->andReturn(OrderStatus::CANCELLED);

        $this->orderRepository->shouldReceive('findByOrderId')->andReturn($orderModelMock);
        $this->orderRepository->shouldReceive('update')->andReturn($orderModelMockAfterUpdate);

        $userModelMock = Mockery::mock(User::class);
        $userModelMock->shouldReceive('getAttribute')->with('email')->andReturn('lilo@stitch.com');

        $this->userRepository->shouldReceive('getUserById')->andReturn($userModelMock);

        $this->orderAuthorizationValidator->shouldReceive('validateOrderUpdate')->andReturn(true);

        $orderUpdateOutputMock = Mockery::mock(OrderUpdateOutput::class);

        $this->orderUpdateOutputFactory->shouldReceive('createFromOrderModel')->andReturn($orderUpdateOutputMock);

        $this->amqpMailSender->shouldReceive('sendMail');

        $updateOrderUsecase = new UpdateOrderUsecase(
            $this->orderRepository,
            $this->userRepository,
            $this->orderAuthorizationValidator,
            $this->orderUpdateOutputFactory,
            $this->amqpMailSender
        );
        
        $orderUpdateInputMock = Mockery::mock(OrderUpdateInput::class);
        $orderUpdateInputMock->shouldReceive('getOrderId')->andReturn(1);
        $orderUpdateInputMock->shouldReceive('getUserId')->andReturn(1);
        $orderUpdateInputMock->shouldReceive('getStatus')->andReturn(OrderStatus::CANCELLED);

        $updateOrderUsecase->execute($orderUpdateInputMock);

        $this->amqpMailSender->shouldHaveReceived('sendMail');
        $this->assertTrue(true);
    }
}