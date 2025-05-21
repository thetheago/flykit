<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class DuplicatedOrderNumberException extends CustomDomainException
{
    public function __construct()
    {
        parent::__construct('Order number already exists.', Response::HTTP_CONFLICT);
    }
}