<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Dto\Order\OrderCreateInput;
use App\Model\Order;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\ListOrderFilterDTO;
use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;

class OrderRepository implements OrderRepositoryInterface
{
    public function findByOrderId(int $orderId): ?Order
    {
        return Order::where('order_id', $orderId)->first();
    }

    public function findByOrderIdWithCheckUser(int $orderId, int $userId): ?Order
    {
        return Order::where('order_id', $orderId)
            ->where('user_id', $userId)->first();
    }

    public function create(OrderCreateInput $input): Order
    {
        return Order::create([
            'order_id' => $input->getOrderId(),
            'requester_name' => $input->getRequesterName(),
            'destination' => $input->getDestination(),
            'departure_date' => $input->getDepartureDate()->format('Y-m-d'),
            'arrival_date' => $input->getArrivalDate()->format('Y-m-d'),
            'status' => $input->getStatus(),
            'user_id' => $input->getUserId(),
        ]);
    }

    public function update(Order $order, array $changesToUpdate): Order
    {
        $order->fill($changesToUpdate);

        if ($order->isDirty()) {
            $order->save();
        }

        return $order;
    }

    public function getQueryBuilderToFindAll(ListOrderFilterDTO $filter): Builder
    {
        $queryBuilder = Order::query();

        $status = $filter->getStatus();
        $departureDate = $filter->getDepartureDate();
        $arrivalDate = $filter->getArrivalDate();
        $destination = $filter->getDestination();

        if ($status) {
            $queryBuilder->where('status', $status);
        }

        if ($departureDate && $arrivalDate) {
            $queryBuilder
                ->where('departure_date', '>=', $departureDate->format('Y-m-d'))
                ->where('arrival_date', '<=', $arrivalDate->format('Y-m-d'));
        }

        if ($destination) {
            $queryBuilder->where('destination', $destination);
        }

        return $queryBuilder;
    }

    /**
     * @return Collection<Order>
     */
    public function findAllByUserId(int $userId, ListOrderFilterDTO $filter): Collection
    {
        $queryBuilder = $this->getQueryBuilderToFindAll($filter);
        $queryBuilder->where('user_id', $userId);
        return $queryBuilder->get();
    }

    /**
     * @return Collection<Order>
     */
    public function findAll(ListOrderFilterDTO $filter): Collection
    {
        $queryBuilder = $this->getQueryBuilderToFindAll($filter);
        return $queryBuilder->get();
    }
}
