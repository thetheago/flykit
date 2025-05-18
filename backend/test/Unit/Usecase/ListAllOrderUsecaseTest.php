<?php

namespace HyperfTest\Unit\Usecase;

use App\Dto\Order\ListAllOrderInput;
use App\Dto\Order\ListAllOrderOutput;
use App\Exception\UserNotFoundException;
use App\Factory\ListAllOrderOutputFactory;
use App\Usecase\ListAllOrderUsecase;
use App\Interfaces\{
    OrderAuthorizationValidatorInterface,
    OrderRepositoryInterface,
    UserRepositoryInterface
};
use App\Model\User;
use Hyperf\Database\Model\Collection;
use Mockery;
use PHPUnit\Framework\TestCase;

class ListAllOrderUsecaseTest extends TestCase
{
    public function testListAllOrderUsecaseWithAdminUser()
    {
        $userId = 1;

        $userMock = Mockery::mock(User::class);

        $userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $userRepositoryMock->shouldReceive('getUserById')->with($userId)->andReturn($userMock);

        $listAllOrderInputMock = Mockery::mock(ListAllOrderInput::class);
        $listAllOrderInputMock->shouldReceive('getUserId')->andReturn($userId);

        $orderRepositoryMock = Mockery::mock(OrderRepositoryInterface::class);
        $orderRepositoryMock->shouldReceive('findAll')->with($listAllOrderInputMock)->andReturn(Collection::make([]));

        $orderAuthorizationValidatorMock = Mockery::mock(OrderAuthorizationValidatorInterface::class);
        $orderAuthorizationValidatorMock->shouldReceive('canUserListAllOrders')->andReturn(true);

        $listAllOrderOutputMock = Mockery::mock(ListAllOrderOutput::class);

        $listAllOrderOutputFactoryMock = Mockery::mock(ListAllOrderOutputFactory::class);
        $listAllOrderOutputFactoryMock->shouldReceive('createFromModelCollection')->andReturn($listAllOrderOutputMock);

        $usecase = new ListAllOrderUsecase(
            $orderRepositoryMock,
            $userRepositoryMock,
            $orderAuthorizationValidatorMock,
            $listAllOrderOutputFactoryMock
        );

        $usecase->execute($listAllOrderInputMock);

        $orderRepositoryMock->shouldHaveReceived('findAll');
        $this->assertTrue(true);
    }

    public function testListAllOrderUsecaseWithNonAdminUser()
    {
        $userId = 1;

        $userMock = Mockery::mock(User::class);

        $userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $userRepositoryMock->shouldReceive('getUserById')->with($userId)->andReturn($userMock);

        $listAllOrderInputMock = Mockery::mock(ListAllOrderInput::class);
        $listAllOrderInputMock->shouldReceive('getUserId')->andReturn($userId);

        $orderRepositoryMock = Mockery::mock(OrderRepositoryInterface::class);
        $orderRepositoryMock->shouldReceive('findAllByUserId')->with($userId, $listAllOrderInputMock)->andReturn(Collection::make([]));

        $orderAuthorizationValidatorMock = Mockery::mock(OrderAuthorizationValidatorInterface::class);
        $orderAuthorizationValidatorMock->shouldReceive('canUserListAllOrders')->andReturn(false);

        $listAllOrderOutputMock = Mockery::mock(ListAllOrderOutput::class);

        $listAllOrderOutputFactoryMock = Mockery::mock(ListAllOrderOutputFactory::class);
        $listAllOrderOutputFactoryMock->shouldReceive('createFromModelCollection')->andReturn($listAllOrderOutputMock);

        $usecase = new ListAllOrderUsecase(
            $orderRepositoryMock,
            $userRepositoryMock,
            $orderAuthorizationValidatorMock,
            $listAllOrderOutputFactoryMock
        );

        $usecase->execute($listAllOrderInputMock);

        $orderRepositoryMock->shouldHaveReceived('findAllByUserId');
        $this->assertTrue(true);
    }

    public function testListAllOrderUsecaseWithNonExistingUser()
    {
        $userId = 1;

        $userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $userRepositoryMock->shouldReceive('getUserById')->with($userId)->andReturn(null);

        $orderRepositoryMock = Mockery::mock(OrderRepositoryInterface::class);
        $orderAuthorizationValidatorMock = Mockery::mock(OrderAuthorizationValidatorInterface::class);
        $listAllOrderOutputFactoryMock = Mockery::mock(ListAllOrderOutputFactory::class);

        $listAllOrderInputMock = Mockery::mock(ListAllOrderInput::class);
        $listAllOrderInputMock->shouldReceive('getUserId')->andReturn($userId);

        $usecase = new ListAllOrderUsecase(
            $orderRepositoryMock,
            $userRepositoryMock,
            $orderAuthorizationValidatorMock,
            $listAllOrderOutputFactoryMock
        );

        $this->expectException(UserNotFoundException::class);
        $usecase->execute($listAllOrderInputMock);
    }
}
