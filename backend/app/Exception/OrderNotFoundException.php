<?php

declare(strict_types=1);

namespace App\Exception;

use App\Exception\CustomException;
use Symfony\Component\HttpFoundation\Response;

class OrderNotFoundException extends CustomException
{
    public function __construct(int $orderId)
    {
        parent::__construct(message: "Order with id $orderId was not found.", code: Response::HTTP_NOT_FOUND);
    }
}
