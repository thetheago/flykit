<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ValidationExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();
        
        /** @var ValidationException $throwable */
        $result = [
            'message' => 'Validation failed',
            'errors' => $throwable->validator->errors()->getMessages(),
        ];

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(422)
            ->withBody(new SwooleStream(json_encode($result)));
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ValidationException;
    }
} 