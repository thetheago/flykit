<?php

declare(strict_types=1);

namespace App\Factory;

use App\Constants\OrderStatus;
use App\Interfaces\OrderStateInterface;
use App\OrderState\ApprovedOrderState;
use App\OrderState\CancelledOrderState;
use App\OrderState\RequestedOrderState;

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