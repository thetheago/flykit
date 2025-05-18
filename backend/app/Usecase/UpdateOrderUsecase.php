<?php

declare(strict_types=1);

namespace App\Usecase;

use App\Dto\Order\OrderUpdateInput;
use App\Exception\OrderNotFoundException;
use App\Exception\UserNotFoundException;
use App\Interfaces\OrderAuthorizationValidatorInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;

class UpdateOrderUsecase
{
    private OrderRepositoryInterface $orderRepository;
    private UserRepositoryInterface $userRepository;
    private OrderAuthorizationValidatorInterface $orderAuthorizationValidator;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        UserRepositoryInterface $userRepository,
        OrderAuthorizationValidatorInterface $orderAuthorizationValidator
    ) {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->orderAuthorizationValidator = $orderAuthorizationValidator;
    }

    public function execute(OrderUpdateInput $input): void
    {
        $orderId = $input->getOrderId();
        $order = $this->orderRepository->findByOrderId($orderId);

        if (!$order) {
            throw new OrderNotFoundException($orderId);
        }

        $user = $this->userRepository->getUserById($input->getUserId());

        if (!$user) {
            throw new UserNotFoundException();
        }

        $this->orderAuthorizationValidator->validateOrderUpdate(
            order: $order,
            user: $user,
            newStatus: $input->getStatus()
        );

        $changesToUpdate = [
            'status' => $input->getStatus(),
        ];

        $this->orderRepository->update(order: $order, changesToUpdate: $changesToUpdate);
    }
}