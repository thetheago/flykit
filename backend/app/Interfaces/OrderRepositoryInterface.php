<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Dto\Order\OrderCreateInput;
use App\Model\Order;
use Hyperf\Database\Model\Collection;

interface OrderRepositoryInterface
{
    public function findByOrderId(int $orderId): ?Order;

    public function create(OrderCreateInput $input): Order;

    public function update(Order $order, array $changesToUpdate): void;

    /**
     * @return Collection<Order>
     */
    public function findAllByUserId(int $userId): Collection;

    /**
     * @return Collection<Order>
     */
    public function findAll(): Collection;
}
