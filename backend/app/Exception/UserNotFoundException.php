<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class UserNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct(message: 'Usuário não encontrado.', code: Response::HTTP_NOT_FOUND);
    }
}
