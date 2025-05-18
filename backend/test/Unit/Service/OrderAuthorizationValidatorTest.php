<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Service;

use App\Constants\OrderStatus;
use App\Exception\AccessDeniedException;
use App\Service\OrderAuthorizationValidator;
use Hyperf\Testing\TestCase;
use App\Model\Order;
use App\Model\User;
use Mockery;

class OrderAuthorizationValidatorTest extends TestCase
{
    public function testOrderAuthorizationValidatorWithSuccess()
    {
        $order = Mockery::mock(Order::class);
        $user = Mockery::mock(User::class);
        $newStatus = OrderStatus::REQUESTED;
        $userId = 1;

        $user->shouldReceive('getAttribute')->with('id')->andReturn($userId);
        $order->shouldReceive('belongsToUser')->with($userId)->andReturn(true);
        $user->shouldReceive('isAdmin')->andReturn(false);
        $order->shouldReceive('getAttribute')->with('status')->andReturn(OrderStatus::REQUESTED);

        $orderAuthorizationValidator = new OrderAuthorizationValidator();
        $orderAuthorizationValidator->validateOrderUpdate(
            order: $order,
            user: $user,
            newStatus: $newStatus
        );

        $this->assertTrue(true);
    }

    public function testOrderAuthorizationValidatorWithAdminUser()
    {
        $order = Mockery::mock(Order::class);
        $user = Mockery::mock(User::class);
        $newStatus = OrderStatus::APPROVED;
        $userId = 1;

        $user->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn($userId);

        $order->shouldReceive('belongsToUser')
            ->once()
            ->with($userId)
            ->andReturn(false);

        $user->shouldReceive('isAdmin')
            ->once()
            ->andReturn(true);

        $orderAuthorizationValidator = new OrderAuthorizationValidator();
        $orderAuthorizationValidator->validateOrderUpdate(
            order: $order,
            user: $user,
            newStatus: $newStatus
        );

        $this->assertTrue(true);
    }

    public function testOrderAuthorizationValidatorThrowsExceptionWhenUserDoesNotOwnOrder()
    {
        $order = Mockery::mock(Order::class);
        $user = Mockery::mock(User::class);
        $newStatus = OrderStatus::REQUESTED;
        $userId = 1;

        $user->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn($userId);

        $order->shouldReceive('belongsToUser')
            ->once()
            ->with($userId)
            ->andReturn(false);

        $user->shouldReceive('isAdmin')
            ->once()
            ->andReturn(false);

        $this->expectException(AccessDeniedException::class);
        $this->expectExceptionMessage('Your user cannot update this order.');

        $orderAuthorizationValidator = new OrderAuthorizationValidator();
        $orderAuthorizationValidator->validateOrderUpdate(
            order: $order,
            user: $user,
            newStatus: $newStatus
        );
    }

    public function testOrderAuthorizationValidatorThrowsExceptionWhenNonAdminUserTriesToChangeStatus()
    {
        $order = Mockery::mock(Order::class);
        $user = Mockery::mock(User::class);
        $newStatus = OrderStatus::APPROVED;
        $userId = 1;

        $user->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn($userId);

        $order->shouldReceive('belongsToUser')
            ->once()
            ->with($userId)
            ->andReturn(true);

        $user->shouldReceive('isAdmin')
            ->once()
            ->andReturn(false);

        $order->shouldReceive('getAttribute')
            ->with('status')
            ->andReturn(OrderStatus::REQUESTED);

        $this->expectException(AccessDeniedException::class);
        $this->expectExceptionMessage('Users cannot update own orders status.');

        $orderAuthorizationValidator = new OrderAuthorizationValidator();
        $orderAuthorizationValidator->validateOrderUpdate(
            order: $order,
            user: $user,
            newStatus: $newStatus
        );
    }

    public function testOrderAuthorizationValidatorCanUserListAllOrders()
    {
        $user = Mockery::mock(User::class);
        $user->shouldReceive('isAdmin')->andReturn(true);

        $orderAuthorizationValidator = new OrderAuthorizationValidator();
        $result = $orderAuthorizationValidator->canUserListAllOrders($user);

        $this->assertTrue($result);
    }

    public function testOrderAuthorizationValidatorCannotUserListAllOrders()
    {
        $user = Mockery::mock(User::class);
        $user->shouldReceive('isAdmin')->andReturn(false);

        $orderAuthorizationValidator = new OrderAuthorizationValidator();
        $result = $orderAuthorizationValidator->canUserListAllOrders($user);

        $this->assertFalse($result);
    }
}