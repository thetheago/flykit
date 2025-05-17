<?php

declare(strict_types=1);

namespace App\Controller;

use App\Factory\{OrderCreateInputFactory, OrderUpdateInputFactory};
use App\Request\{OrderCreateRequest, OrderUpdateRequest};
use App\Usecase\{CreateOrderUsecase, UpdateOrderUsecase};
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
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

    public function create(OrderCreateRequest $request)
    {
        $input = $this->orderCreateInputFactory->createFromRequest($request);
        $usecase = new CreateOrderUsecase($this->orderRepository);
        $output = $usecase->execute($input);

        return (new Response())->json($output->toArray())->withStatus(HttpResponse::HTTP_CREATED);
    }

    public function update(OrderUpdateRequest $request)
    {
        $input = $this->orderUpdateInputFactory->createFromRequest($request);
        $usecase = new UpdateOrderUsecase($this->orderRepository, $this->userRepository);
        $output = $usecase->execute($input);

        return (new Response())->json(['joia uai' => '1'])->withStatus(HttpResponse::HTTP_OK);

        // $output = $usecase->execute($input);
    }
}
