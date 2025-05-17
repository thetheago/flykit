<?php

declare(strict_types=1);

namespace App\Exception;

use App\Exception\CustomException;
use Symfony\Component\HttpFoundation\Response;

class WrongUserPasswordException extends CustomException
{
    public function __construct()
    {
        parent::__construct(message: 'Senha incorreta.', code: Response::HTTP_UNAUTHORIZED);
    }
}
