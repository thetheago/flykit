<?php

declare(strict_types=1);

namespace App\OrderState;

use App\Model\Order;

class RequestedOrderState extends AbstractOrderState
{
    public function approve(Order $order): void
    {
        $this->transitionTo($order, new ApprovedOrderState());
    }

    public function cancel(Order $order): void
    {
        $this->transitionTo($order, new CancelledOrderState());
    }

    public function getStatus(): string
    {
        return 'requested';
    }
} 