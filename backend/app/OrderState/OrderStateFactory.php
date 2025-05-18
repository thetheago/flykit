<?php

declare(strict_types=1);

namespace App\OrderState;

use App\Constants\OrderStatus;

class OrderStateFactory
{
    public static function createFromStatus(string $status): OrderStateInterface
    {
        return match ($status) {
            OrderStatus::APPROVED => new ApprovedOrderState(),
            OrderStatus::REQUESTED => new RequestedOrderState(),
            OrderStatus::CANCELLED => new CancelledOrderState(),
            default => throw new \InvalidArgumentException("Invalid order status: {$status}")
        };
    }
} 