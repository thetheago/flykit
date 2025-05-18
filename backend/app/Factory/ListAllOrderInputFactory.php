<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\Order\ListAllOrderInput;
use App\Request\ListAllOrderRequest;
use Hyperf\Contract\ContainerInterface;

class ListAllOrderInputFactory
{
    public function createFromRequest(ListAllOrderRequest $request, ContainerInterface $container): ListAllOrderInput
    {
        $user = $container->get('user');
        $userId = (int) $user->id;

        return new ListAllOrderInput(
            userId: $userId,
            status: $request->input('status'),
            departureDate: $request->input('departureDate'),
            arrivalDate: $request->input('arrivalDate'),
            destination: $request->input('destination'),
        );
    }
}
