<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class InvalidArrivalDateException extends CustomDomainException
{
    public function __construct()
    {
        parent::__construct('Invalid arrival date. It must be greater than departure date.', Response::HTTP_BAD_REQUEST);
    }
}
