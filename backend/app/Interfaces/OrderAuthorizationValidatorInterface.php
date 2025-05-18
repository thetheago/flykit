<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Exception\AccessDeniedException;
use App\Model\Order;
use App\Model\User;

interface OrderAuthorizationValidatorInterface
{
    /**
     * @throws AccessDeniedException
     */
    public function validateOrderUpdate(Order $order, User $user, string $newStatus): void;
} 