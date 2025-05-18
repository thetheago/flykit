<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\Order\OrderUpdateInput;
use App\Request\OrderUpdateRequest;
use Hyperf\Contract\ContainerInterface;

class OrderUpdateInputFactory
{
    public function createFromRequest(OrderUpdateRequest $request, ContainerInterface $container): OrderUpdateInput
    {
        $status = $request->input('status');
        $orderId = $request->route('orderId');
        $user = $container->get('user');

        return new OrderUpdateInput(
            status: $status,
            orderId: $orderId,
            userId: $user->id
        );
    }
}
