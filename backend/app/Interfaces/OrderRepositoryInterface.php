<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Dto\Order\OrderCreateInput;
use App\Model\Order;

interface OrderRepositoryInterface
{
    public function findByOrderId(int $orderId): ?Order;

    public function create(OrderCreateInput $input): Order;
}
