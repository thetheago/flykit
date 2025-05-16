<?php

declare(strict_types=1);

namespace App\Interfaces;

use Throwable;

interface CustomException extends Throwable
{
    public function getCode(): int;
    public function getMessage(): string;
}
