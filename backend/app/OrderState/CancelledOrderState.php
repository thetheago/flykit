<?php

declare(strict_types=1);

namespace App\OrderState;

use App\Constants\OrderStatus;
use App\Model\Order;

class CancelledOrderState extends AbstractOrderState
{
    public function approve(Order $order): void
    {
        $this->throwInvalidTransition(OrderStatus::CANCELLED, OrderStatus::APPROVED);
    }

    public function request(Order $order): void
    {
        $this->throwInvalidTransition(OrderStatus::CANCELLED, OrderStatus::REQUESTED);
    }

    public function getStatus(): string
    {
        return OrderStatus::CANCELLED;
    }
} 