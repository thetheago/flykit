<?php

declare(strict_types=1);

namespace App\Dto\Order;

class OrderUpdateInput
{
    public function __construct(
        private readonly string $status,
        private readonly int|string $orderId,
        private readonly int $userId,
    ) {
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getOrderId(): int
    {
        return (int) $this->orderId;
    }
}
