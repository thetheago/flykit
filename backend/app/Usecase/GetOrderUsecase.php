<?php

declare(strict_types=1);

namespace App\Usecase;

use App\Interfaces\{
    OrderRepositoryInterface,
    OrderAuthorizationValidatorInterface,
    UserRepositoryInterface
};
use App\Dto\Order\GetOrderInput;
use App\Dto\Order\GetOrderOutput;
use App\Exception\OrderNotFoundException;
use App\Exception\UserNotFoundException;
use App\Factory\GetOrderOutputFactory;

class GetOrderUsecase
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private UserRepositoryInterface $userRepository,
        private OrderAuthorizationValidatorInterface $orderAuthorizationValidator,
        private GetOrderOutputFactory $getOrderOutputFactory
    ) {}

    public function execute(GetOrderInput $input): GetOrderOutput
    {
        $orderId = $input->getOrderId();
        $userId = $input->getUserId();

        $user = $this->userRepository->getUserById($userId);

        if (!$user) {
            throw new UserNotFoundException();
        }

        $userCanListAllOrders = $this->orderAuthorizationValidator->canUserListAllOrders($user);

        if ($userCanListAllOrders) {
            $order = $this->orderRepository->findByOrderId($orderId);
        } else {
            $order = $this->orderRepository->findByOrderIdWithCheckUser($orderId, $userId);
        }

        if (!$order) {
            throw new OrderNotFoundException($orderId);
        }

        return $this->getOrderOutputFactory->createFromOrderModel($order);
    }
}
