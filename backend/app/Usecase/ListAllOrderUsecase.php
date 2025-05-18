<?php

declare(strict_types=1);

namespace App\Usecase;

use App\Dto\Order\ListAllOrderOutput;
use App\Exception\UserNotFoundException;
use App\Factory\ListAllOrderOutputFactory;
use App\Interfaces\{
    OrderAuthorizationValidatorInterface,
    OrderRepositoryInterface,
    UserRepositoryInterface
};

class ListAllOrderUsecase
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private UserRepositoryInterface $userRepository,
        private OrderAuthorizationValidatorInterface $orderAuthorizationValidator,
        private ListAllOrderOutputFactory $listAllOrderOutputFactory
    )
    {}

    public function execute(int $userId): ListAllOrderOutput
    {
        $user = $this->userRepository->getUserById($userId);

        if (!$user) {
            throw new UserNotFoundException();
        }

        $userCanListAllOrders = $this->orderAuthorizationValidator->canUserListAllOrders($user);

        if ($userCanListAllOrders) {
            $orders = $this->orderRepository->findAll();
        } else {
            $orders = $this->orderRepository->findAllByUserId($userId);
        }

        return $this->listAllOrderOutputFactory->createFromModelCollection($orders);
    }
}
