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
use InvalidArgumentException;

class UpdateOrderUsecase
{
    private OrderRepositoryInterface $orderRepository;
    private UserRepositoryInterface $userRepository;
    private OrderAuthorizationValidatorInterface $orderAuthorizationValidator;
    private OrderUpdateOutputFactory $orderUpdateOutputFactory;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        UserRepositoryInterface $userRepository,
        OrderAuthorizationValidatorInterface $orderAuthorizationValidator,
        OrderUpdateOutputFactory $orderUpdateOutputFactory
    ) {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->orderAuthorizationValidator = $orderAuthorizationValidator;
        $this->orderUpdateOutputFactory = $orderUpdateOutputFactory;
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

        $newStatus = $input->getStatus();
        match ($newStatus) {
            OrderStatus::APPROVED => $order->approve(),
            OrderStatus::REQUESTED => $order->request(),
            OrderStatus::CANCELLED => $order->cancel(),
            default => throw new InvalidArgumentException("Invalid status: $newStatus")
        };

        $this->orderRepository->update(order: $order, changesToUpdate: ['status' => $order->status]);

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