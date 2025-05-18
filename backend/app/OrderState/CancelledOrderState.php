<?php

declare(strict_types=1);

namespace App\OrderState;

use App\Model\Order;

class CancelledOrderState extends AbstractOrderState
{
    public function approve(Order $order): void
    {
        $this->throwInvalidTransition('cancelled', 'approved');
    }

    public function request(Order $order): void
    {
        $this->throwInvalidTransition('cancelled', 'requested');
    }

    public function getStatus(): string
    {
        return 'cancelled';
    }
} 