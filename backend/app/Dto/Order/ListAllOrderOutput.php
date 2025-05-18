<?php

declare(strict_types=1);

namespace App\Dto\Order;

class ListAllOrderOutput
{
    public function __construct(
        private readonly array $orders,
    ) {}

    public function getOrders(): array
    {
        return $this->orders;
    }
}
