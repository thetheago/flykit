<?php

declare(strict_types=1);

namespace App\OrderState;

use App\Exception\InvalidStateTransitionException;
use App\Model\Order;

abstract class AbstractOrderState implements OrderStateInterface
{
    public function approve(Order $order): void {}

    public function request(Order $order): void {}

    public function cancel(Order $order): void {}

    protected function transitionTo(Order $order, OrderStateInterface $newState): void
    {
        $order->setState($newState);
    }

    protected function throwInvalidTransition(string $fromState, string $toState): void
    {
        throw new InvalidStateTransitionException(
            "Cannot transition from status '{$fromState}' to '{$toState}'."
        );
    }
} 