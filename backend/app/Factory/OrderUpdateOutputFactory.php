<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\Order\OrderUpdateOutput;
use App\Model\Order;
use Carbon\Carbon;

class OrderUpdateOutputFactory
{
    public function createFromOrderModel(Order $order): OrderUpdateOutput
    {
        return new OrderUpdateOutput(
            orderId: $order->order_id,
            requesterName: $order->requester_name,
            destination: $order->destination,
            departureDate: Carbon::parse($order->departure_date)->format('d-m-Y'),
            arrivalDate: Carbon::parse($order->arrival_date)->format('d-m-Y'),
            status: $order->status,
        );
    }
}
