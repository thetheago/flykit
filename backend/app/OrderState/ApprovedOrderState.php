<?php

declare(strict_types=1);

namespace App\OrderState;

use App\Model\Order;

class ApprovedOrderState extends AbstractOrderState
{
    public function request(Order $order): void
    {
        $this->throwInvalidTransition('approved', 'requested');
    }

    public function cancel(Order $order): void
    {
        $this->throwInvalidTransition('approved', 'cancelled');
    }

    public function getStatus(): string
    {
        return 'approved';
    }
} 