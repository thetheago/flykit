<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\Order\OrderCreateInput;
use App\Request\OrderCreateRequest;
use Hyperf\Contract\ContainerInterface;

class OrderCreateInputFactory
{
    public function createFromRequest(OrderCreateRequest $request, ContainerInterface $container): OrderCreateInput
    {
        $orderId = (int) $request->input('orderId');
        $requesterName = $request->input('requesterName');
        $destination = $request->input('destination');
        $departureDate = $request->input('departureDate');
        $arrivalDate = $request->input('arrivalDate');
        $status = $request->input('status');
        $user = $container->get('user');

        return new OrderCreateInput(
            orderId: $orderId,
            requesterName: $requesterName,
            destination: $destination,
            departureDate: $departureDate,
            arrivalDate: $arrivalDate,
            status: $status,
            userId: (int) $user->id
        );
    }
}
