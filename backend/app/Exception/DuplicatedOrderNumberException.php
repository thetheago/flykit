<?php

declare(strict_types=1);

namespace App\Exception;

use App\Exception\CustomException;
use Symfony\Component\HttpFoundation\Response;

class DuplicatedOrderNumberException extends CustomException
{
    public function __construct(string $message = 'Order number already exists.')
    {
        parent::__construct($message, Response::HTTP_CONFLICT);
    }
}