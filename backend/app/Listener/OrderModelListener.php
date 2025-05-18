<?php

declare(strict_types=1);

namespace App\Listener;

use App\Model\Order;
use Hyperf\Database\Model\Events\Retrieved;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;

#[Listener]
class OrderModelListener implements ListenerInterface
{
    public function listen(): array
    {
        return [
            Retrieved::class,
        ];
    }

    public function process(object $event): void
    {
        if ($event instanceof Retrieved && $event->getModel() instanceof Order) {
            /** @var Order $order */
            $order = $event->getModel();
            $order->initializeState();
        }
    }
} 