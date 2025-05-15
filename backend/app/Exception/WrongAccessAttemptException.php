<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class WrongAccessAttemptException extends Exception
{
    public function __construct()
    {
        parent::__construct(message: 'Tentativa de acesso inválida.', code: Response::HTTP_UNAUTHORIZED);
    }
}
