<?php

declare(strict_types=1);

namespace App\Controller;

use App\Factory\{
    GetOrderInputFactory,
    GetOrderOutputFactory,
    ListAllOrderInputFactory,
    ListAllOrderOutputFactory,
    OrderCreateInputFactory,
    OrderUpdateInputFactory
};
use App\Interfaces\{
    OrderAuthorizationValidatorInterface,
    OrderRepositoryInterface,
    UserRepositoryInterface
};
use App\Request\{
    ListAllOrderRequest,
    OrderCreateRequest,
    OrderUpdateRequest
};
use App\Usecase\{
    CreateOrderUsecase,
    GetOrderUsecase,
    ListAllOrderUsecase,
    UpdateOrderUsecase
};
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class OrderController extends AbstractController
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
    private ListAllOrderInputFactory $listAllOrderInputFactory;

    #[Inject]
    private ListAllOrderOutputFactory $listAllOrderOutputFactory;

    #[Inject]
    private GetOrderInputFactory $getOrderInputFactory;

    #[Inject]
    private GetOrderOutputFactory $getOrderOutputFactory;

    #[Inject]
    private OrderAuthorizationValidatorInterface $orderAuthorizationValidator;

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

    public function list(ListAllOrderRequest $request)
    {
        $input = $this->listAllOrderInputFactory->createFromRequest($request, $this->container);

        $usecase = new ListAllOrderUsecase(
            orderRepository: $this->orderRepository,
            userRepository: $this->userRepository,
            orderAuthorizationValidator: $this->orderAuthorizationValidator,
            listAllOrderOutputFactory: $this->listAllOrderOutputFactory
        );

        $output = $usecase->execute($input);
        return (new Response())->json($output->getOrders())->withStatus(HttpResponse::HTTP_OK);
    }

    public function show()
    {
        $input = $this->getOrderInputFactory->createFromRequest($this->request, $this->container);
        $usecase = new GetOrderUsecase(
            orderRepository: $this->orderRepository,
            userRepository: $this->userRepository,
            orderAuthorizationValidator: $this->orderAuthorizationValidator,
            getOrderOutputFactory: $this->getOrderOutputFactory
        );
        $output = $usecase->execute($input);

        return (new Response())->json($output->getOrder())->withStatus(HttpResponse::HTTP_OK);
    }
}
