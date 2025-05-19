<?php

declare(strict_types=1);

namespace App\Usecase;

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
use InvalidArgumentException;

class UpdateOrderUsecase
{
    private OrderRepositoryInterface $orderRepository;
    private UserRepositoryInterface $userRepository;
    private OrderAuthorizationValidatorInterface $orderAuthorizationValidator;
    private OrderUpdateOutputFactory $orderUpdateOutputFactory;
    private AmqpMailSender $amqpMailSender;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        UserRepositoryInterface $userRepository,
        OrderAuthorizationValidatorInterface $orderAuthorizationValidator,
        OrderUpdateOutputFactory $orderUpdateOutputFactory,
        AmqpMailSender $amqpMailSender
    ) {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->orderAuthorizationValidator = $orderAuthorizationValidator;
        $this->orderUpdateOutputFactory = $orderUpdateOutputFactory;
        $this->amqpMailSender = $amqpMailSender;
    }

    public function execute(OrderUpdateInput $input): OrderUpdateOutput
    {
        $orderId = $input->getOrderId();
        $order = $this->getOrder($orderId);

        $userId = $input->getUserId();
        $user = $this->getUser($userId);

        $this->orderAuthorizationValidator->validateOrderUpdate(
            order: $order,
            user: $user,
            newStatus: $input->getStatus()
        );

        $statusBeforeUpdate = $order->status;

        $newStatus = $input->getStatus();
        match ($newStatus) {
            OrderStatus::APPROVED => $order->approve(),
            OrderStatus::REQUESTED => $order->request(),
            OrderStatus::CANCELLED => $order->cancel(),
            default => throw new InvalidArgumentException("Invalid status: $newStatus")
        };

        $updatedOrder = $this->orderRepository->update(order: $order, changesToUpdate: ['status' => $order->status]);

        $statusAfterUpdate = $updatedOrder->status;

        if (
            ($statusBeforeUpdate !== $statusAfterUpdate) &&
            ($statusAfterUpdate === OrderStatus::APPROVED || $statusAfterUpdate === OrderStatus::CANCELLED)
        ) {
            $this->amqpMailSender->sendMail(
                email: $user->email,
                subject: 'Order status updated',
                body: "The order $orderId status has been updated to $statusAfterUpdate"
            );
        }

        return $this->orderUpdateOutputFactory->createFromOrderModel($order);
    }

    private function getOrder(int $orderId): Order
    {
        $order = $this->orderRepository->findByOrderId($orderId);

        if (!$order) {
            throw new OrderNotFoundException($orderId);
        }

        return $order;
    }

    private function getUser(int $userId): User
    {
        $user = $this->userRepository->getUserById($userId);

        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}