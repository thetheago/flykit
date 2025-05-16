<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use App\Interfaces\CustomException;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Psr\Http\Message\ResponseInterface;
use Hyperf\HttpServer\Response;

use Throwable;

class AppExceptionHandler extends ExceptionHandler
{
    public function __construct(protected StdoutLoggerInterface $logger)
    {
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        if ($throwable instanceof CustomException) {
            return (new Response())->json(['message' => $throwable->getMessage()])->withStatus($throwable->getCode());
        }

        $this->logger->error(sprintf('%s[%s] in %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()));
        $this->logger->error($throwable->getTraceAsString());
        return (new Response())->json(['message' => $throwable->getMessage()])->withHeader('Server', 'Hyperf')->withStatus($throwable->getCode());
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
