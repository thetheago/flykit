<?php

namespace App\Exception;

use App\Exception\CustomException;
use Symfony\Component\HttpFoundation\Response;

class InvalidArrivalDateException extends CustomException
{
    public function __construct()
    {
        parent::__construct('Invalid arrival date. It must be greater than departure date.', Response::HTTP_BAD_REQUEST);
    }
}
