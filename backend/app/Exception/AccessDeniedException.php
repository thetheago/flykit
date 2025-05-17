<?php

declare(strict_types=1);

namespace App\Exception;

use App\Exception\CustomException;
use Symfony\Component\HttpFoundation\Response;

class AccessDeniedException extends CustomException
{
    public function __construct(string $message = 'Access denied.')
    {
        parent::__construct($message, Response::HTTP_FORBIDDEN);
    }
}