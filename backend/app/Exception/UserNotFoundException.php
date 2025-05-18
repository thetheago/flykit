<?php

declare(strict_types=1);

namespace App\Exception;

use App\Exception\CustomException;
use Symfony\Component\HttpFoundation\Response;

class UserNotFoundException extends CustomException
{
    public function __construct()
    {
        parent::__construct(message: 'User not found.', code: Response::HTTP_NOT_FOUND);
    }
}
