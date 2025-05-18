<?php

declare(strict_types=1);

namespace App\Dto\Order;

class GetOrderOutput
{
    public function __construct(
        private array $order
    ) {}

    public function getOrder(): array
    {
        return $this->order;
    }
}
