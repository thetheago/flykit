<?php

declare(strict_types=1);

namespace App\Factory;

use App\Dto\Order\GetOrderInput;
use Hyperf\Contract\ContainerInterface;
use Hyperf\HttpServer\Contract\RequestInterface;

class GetOrderInputFactory
{
    public function createFromRequest(RequestInterface $request, ContainerInterface $container): GetOrderInput
    {
        $orderId = (int) $request->route('orderId');

        $user = $container->get('user');
        $userId = (int) $user->id;

        return new GetOrderInput($orderId, $userId);
    }
}