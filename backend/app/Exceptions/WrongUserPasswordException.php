<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class WrongUserPasswordException extends Exception
{
    public function __construct()
    {
        parent::__construct(message: 'Senha incorreta.', code: Response::HTTP_UNAUTHORIZED);
    }
}
