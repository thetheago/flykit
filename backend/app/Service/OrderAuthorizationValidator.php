<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\AccessDeniedException;
use App\Interfaces\OrderAuthorizationValidatorInterface;
use App\Model\Order;
use App\Model\User;

class OrderAuthorizationValidator implements OrderAuthorizationValidatorInterface
{
    public function validateOrderUpdate(Order $order, User $user, string $newStatus): void
    {
        $orderBelongsToUser = $order->belongsToUser($user->id);
        $userIsAdmin = $user->isAdmin();

        if ($userIsAdmin) {
            return;
        }

        if (!$orderBelongsToUser) {
            throw new AccessDeniedException('Your user cannot update this order.');
        }

        if ($orderBelongsToUser && $newStatus !== $order->status) {
            throw new AccessDeniedException('Users cannot update own orders status.');
        }
    }
} 