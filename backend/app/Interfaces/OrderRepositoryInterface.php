<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Dto\Order\OrderCreateInput;
use App\Interfaces\ListOrderFilterDTO;
use App\Model\Order;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;

interface OrderRepositoryInterface
{
    public function findByOrderId(int $orderId): ?Order;

    public function create(OrderCreateInput $input): Order;

    public function update(Order $order, array $changesToUpdate): void;

    public function getQueryBuilderToFindAll(ListOrderFilterDTO $filter): Builder;

    /**
     * @return Collection<Order>
     */
    public function findAllByUserId(int $userId, ListOrderFilterDTO $filter): Collection;

    /**
     * @return Collection<Order>
     */
    public function findAll(ListOrderFilterDTO $filter): Collection;
}
