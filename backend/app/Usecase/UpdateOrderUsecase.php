<?php

declare(strict_types=1);

namespace App\Usecase;

use App\Dto\Order\OrderUpdateInput;
use App\Exception\AccessDeniedException;
use App\Exception\OrderNotFoundException;
use App\Exception\UserNotFoundException;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;

class UpdateOrderUsecase
{
    private OrderRepositoryInterface $orderRepository;
    
    private UserRepositoryInterface $userRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
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

        $orderBelongsToUser = $order->belongsToUser($user->id);
        $userIsAdmin = $user->isAdmin();

        if (!$userIsAdmin) {
            if (!$orderBelongsToUser) {
                throw new AccessDeniedException('Your user cannot update this order.');
            }

            if ($orderBelongsToUser && $input->getStatus() !== $order->status) {
                throw new AccessDeniedException('Users cannot update own orders status.');
            }
        }

        $changesToUpdate = [
            'status' => $input->getStatus(),
        ];

        $this->orderRepository->update(order: $order, changesToUpdate: $changesToUpdate);
    }
}