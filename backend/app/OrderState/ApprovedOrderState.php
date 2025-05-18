<?php

declare(strict_types=1);

namespace App\OrderState;

use App\Constants\OrderStatus;
use App\Model\Order;

class ApprovedOrderState extends AbstractOrderState
{
    public function request(Order $order): void
    {
        $this->throwInvalidTransition(OrderStatus::APPROVED, OrderStatus::REQUESTED);
    }

    public function cancel(Order $order): void
    {
        $this->throwInvalidTransition(OrderStatus::APPROVED, OrderStatus::CANCELLED);
    }

    public function getStatus(): string
    {
        return OrderStatus::APPROVED;
    }
} 