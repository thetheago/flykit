<?php


declare(strict_types=1);

namespace App\Exception\Handler;

use App\Exception\CustomException;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Psr\Http\Message\ResponseInterface;
use Hyperf\HttpServer\Response;

use Throwable;

class CustomExceptionHandler extends ExceptionHandler
{
    public function __construct(protected StdoutLoggerInterface $logger)
    {
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();

        return (new Response())->json(['message' => $throwable->getMessage()])->withHeader('Server', 'Hyperf')->withStatus($throwable->getCode());
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof CustomException;
    }
}
