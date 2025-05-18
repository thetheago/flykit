<?php

declare(strict_types=1);

namespace App\OrderState;

class OrderStateFactory
{
    public static function createFromStatus(string $status): OrderStateInterface
    {
        return match ($status) {
            'approved' => new ApprovedOrderState(),
            'requested' => new RequestedOrderState(),
            'cancelled' => new CancelledOrderState(),
            default => throw new \InvalidArgumentException("Invalid order status: {$status}")
        };
    }
} 