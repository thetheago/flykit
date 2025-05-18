<?php

declare(strict_types=1);

namespace HyperfTest\Unit\OrderState;

use App\Constants\OrderStatus;
use App\Exception\InvalidStateTransitionException;
use Hyperf\Testing\TestCase;

class OrderStateTestCase extends TestCase
{
    public static function approvedStateTransitionProvider(): array
    {
        return [
            'approved to approve should keep approved status' => [
                'method' => 'approve',
                'initialStatus' => OrderStatus::APPROVED,
                'expectedStatus' => OrderStatus::APPROVED,
            ],
            'approved to request should throw exception' => [
                'method' => 'request',
                'initialStatus' => OrderStatus::APPROVED,
                'expectedStatus' => null,
                'expectedException' => InvalidStateTransitionException::class,
                'expectedExceptionMessage' => "Cannot transition from status '" . OrderStatus::APPROVED . "' to '" . OrderStatus::REQUESTED . "'.",
            ],
            'approved to cancel should throw exception' => [
                'method' => 'cancel',
                'initialStatus' => OrderStatus::APPROVED,
                'expectedStatus' => null,
                'expectedException' => InvalidStateTransitionException::class,
                'expectedExceptionMessage' => "Cannot transition from status '" . OrderStatus::APPROVED . "' to '" . OrderStatus::CANCELLED . "'.",
            ],
        ];
    }

    public static function requestedStateTransitionProvider(): array
    {
        return [
            'requested to request should keep requested status' => [
                'method' => 'request',
                'initialStatus' => OrderStatus::REQUESTED,
                'expectedStatus' => OrderStatus::REQUESTED,
            ],
            'requested to approve should approve the order' => [
                'method' => 'approve',
                'initialStatus' => OrderStatus::REQUESTED,
                'expectedStatus' => OrderStatus::APPROVED,
            ],
            'requested to cancel should cancel the order' => [
                'method' => 'cancel',
                'initialStatus' => OrderStatus::REQUESTED,
                'expectedStatus' => OrderStatus::CANCELLED,
            ],
        ];
    }

    public static function cancelledStateTransitionProvider(): array
    {
        return [
            'cancel to cancel should keep cancelled status' => [
                'method' => 'cancel',
                'initialStatus' => OrderStatus::CANCELLED,
                'expectedStatus' => OrderStatus::CANCELLED,
            ],
            'cancel to approve should throw exception' => [
                'method' => 'approve',
                'initialStatus' => OrderStatus::CANCELLED,
                'expectedStatus' => null,
                'expectedException' => InvalidStateTransitionException::class,
                'expectedExceptionMessage' => "Cannot transition from status '" . OrderStatus::CANCELLED . "' to '" . OrderStatus::APPROVED . "'.",
            ],
            'cancel to request should throw exception' => [
                'method' => 'request',
                'initialStatus' => OrderStatus::CANCELLED,
                'expectedStatus' => null,
                'expectedException' => InvalidStateTransitionException::class,
                'expectedExceptionMessage' => "Cannot transition from status '" . OrderStatus::CANCELLED . "' to '" . OrderStatus::REQUESTED . "'.",
            ],
        ];
    }
}
