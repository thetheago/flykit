<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Model\Order;

interface OrderStateInterface
{
    public function approve(Order $order): void;
    public function request(Order $order): void;
    public function cancel(Order $order): void;
    public function getStatus(): string;
} 