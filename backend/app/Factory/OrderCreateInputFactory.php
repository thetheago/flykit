<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\Order\OrderCreateInput;
use App\Request\OrderCreateRequest;

class OrderCreateInputFactory
{
    public function createFromRequest(OrderCreateRequest $request): OrderCreateInput
    {
        $orderId = $request->input('orderId');
        $requesterName = $request->input('requesterName');
        $destination = $request->input('destination');
        $departureDate = $request->input('departureDate');
        $arrivalDate = $request->input('arrivalDate');
        $status = $request->input('status');

        return new OrderCreateInput(
            orderId: $orderId,
            requesterName: $requesterName,
            destination: $destination,
            departureDate: $departureDate,
            arrivalDate: $arrivalDate,
            status: $status
        );
    }
}
