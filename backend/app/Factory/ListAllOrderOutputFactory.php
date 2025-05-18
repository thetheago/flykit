<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\Order\ListAllOrderOutput;
use App\Model\Order;
use Hyperf\Database\Model\Collection;

class ListAllOrderOutputFactory
{
    /**
     * @param Collection<Order> $orders
     */
    public function createFromModelCollection(Collection $orders): ListAllOrderOutput
    {
        $ordersOutput = [];

        $orders->each(function (Order $order) use (&$ordersOutput) {
            $ordersOutput[] = [
                'orderId' => $order->order_id,
                'requesterName' => $order->requester_name,
                'destination' => $order->destination,
                'departureDate' => $order->departure_date,
                'arrivalDate' => $order->arrival_date,
                'status' => $order->status,
            ];
        });

        return new ListAllOrderOutput($ordersOutput);
    }
}
