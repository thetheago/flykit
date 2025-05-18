<?php

declare(strict_types=1);

namespace App\Controller;

use App\Factory\{ListAllOrderOutputFactory, OrderCreateInputFactory, OrderUpdateInputFactory};
use App\Interfaces\{
    OrderAuthorizationValidatorInterface,
    OrderRepositoryInterface,
    UserRepositoryInterface
};
use App\Request\{OrderCreateRequest, OrderUpdateRequest};
use App\Usecase\{CreateOrderUsecase, ListAllOrderUsecase, UpdateOrderUsecase};
use Hyperf\Contract\ContainerInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class OrderController
{    
    #[Inject]
    private OrderRepositoryInterface $orderRepository;

    #[Inject]
    private UserRepositoryInterface $userRepository;

    #[Inject]
    private OrderCreateInputFactory $orderCreateInputFactory;

    #[Inject]
    private OrderUpdateInputFactory $orderUpdateInputFactory;

    #[Inject]
    private ListAllOrderOutputFactory $listAllOrderOutputFactory;

    #[Inject]
    private OrderAuthorizationValidatorInterface $orderAuthorizationValidator;

    #[Inject]
    private ContainerInterface $container;

    public function create(OrderCreateRequest $request)
    {
        $input = $this->orderCreateInputFactory->createFromRequest($request, $this->container);
        $usecase = new CreateOrderUsecase($this->orderRepository);
        $output = $usecase->execute($input);

        return (new Response())->json($output->toArray())->withStatus(HttpResponse::HTTP_CREATED);
    }

    public function update(OrderUpdateRequest $request)
    {
        $input = $this->orderUpdateInputFactory->createFromRequest($request, $this->container);
        $usecase = new UpdateOrderUsecase(
            orderRepository: $this->orderRepository,
            userRepository: $this->userRepository,
            orderAuthorizationValidator: $this->orderAuthorizationValidator
        );
        $usecase->execute($input);

        return (new Response())->withStatus(HttpResponse::HTTP_NO_CONTENT);
    }

    public function list()
    {
        $user = $this->container->get('user');
        $userId = (int) $user->id;

        $usecase = new ListAllOrderUsecase(
            orderRepository: $this->orderRepository,
            userRepository: $this->userRepository,
            orderAuthorizationValidator: $this->orderAuthorizationValidator,
            listAllOrderOutputFactory: $this->listAllOrderOutputFactory
        );

        $output = $usecase->execute($userId);
        return (new Response())->json($output->getOrders())->withStatus(HttpResponse::HTTP_OK);
    }
}
