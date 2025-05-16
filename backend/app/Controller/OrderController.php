<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\OrderCreateRequest;

class OrderController
{
    public function create(OrderCreateRequest $request)
    {
        // $input = createOrderInputFactory($request);
        // $usecase = new CreateOrderUsecase();
        // $output = $usecase->execute($input);

        // return $output;

        return 'teste';
    }
}
