<?php

declare(strict_types=1);

namespace App\Dto\Order;

class GetOrderInput
{
    public function __construct(
        private int $orderId,
        private int $userId,
    ) {}

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}