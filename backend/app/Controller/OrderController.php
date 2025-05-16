<?php

declare(strict_types=1);

namespace App\Controller;

use App\Factory\OrderCreateInputFactory;
use App\Request\OrderCreateRequest;
use App\Usecase\CreateOrderUsecase;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class OrderController
{
    #[Inject]
    private OrderCreateInputFactory $orderCreateInputFactory;

    public function create(OrderCreateRequest $request)
    {
        $input = $this->orderCreateInputFactory->createFromRequest($request);
        $usecase = new CreateOrderUsecase();
        $usecase->execute($input);

        return (new Response())->withStatus(HttpResponse::HTTP_OK);
    }
}
