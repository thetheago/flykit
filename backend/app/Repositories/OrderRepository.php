<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Dto\Order\OrderCreateInput;
use App\Model\Order;
use App\Interfaces\OrderRepositoryInterface;
use Hyperf\Database\Model\Collection;

class OrderRepository implements OrderRepositoryInterface
{
    public function findByOrderId(int $orderId): ?Order
    {
        return Order::where('order_id', $orderId)->first();
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

    public function update(Order $order, array $changesToUpdate): void
    {
        $order->update($changesToUpdate);
    }

    /**
     * @return Collection<Order>
     */
    public function findAllByUserId(int $userId): Collection
    {
        return Order::where('user_id', $userId)->get();
    }

    /**
     * @return Collection<Order>
     */
    public function findAll(): Collection
    {
        return Order::all();
    }
}
