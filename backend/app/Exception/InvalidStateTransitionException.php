<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class InvalidStateTransitionException extends CustomDomainException
{
    public function __construct(string $message)
    {
        parent::__construct($message, Response::HTTP_BAD_REQUEST);
    }
} 