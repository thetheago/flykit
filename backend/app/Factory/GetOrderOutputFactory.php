<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\Order\GetOrderOutput;
use App\Model\Order;

class GetOrderOutputFactory
{
    public function createFromOrderModel(Order $order): GetOrderOutput
    {
        return new GetOrderOutput([
            'orderId' => $order->order_id,
            'requesterName' => $order->requester_name,
            'destination' => $order->destination,
            'departureDate' => $order->departure_date,
            'arrivalDate' => $order->arrival_date,
            'status' => $order->status,
        ]);
    }
}