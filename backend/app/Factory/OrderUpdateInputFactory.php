<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\Order\OrderUpdateInput;
use App\Request\OrderUpdateRequest;
use Hyperf\Di\Container;
use Hyperf\Di\Annotation\Inject;

class OrderUpdateInputFactory
{
    #[Inject]
    private Container $container;

    public function createFromRequest(OrderUpdateRequest $request): OrderUpdateInput
    {
        $status = $request->input('status');
        $orderId = $request->route('orderId');
        $user = $this->container->get('user');

        return new OrderUpdateInput(
            status: $status,
            orderId: $orderId,
            userId: $user->id
        );
    }
}
