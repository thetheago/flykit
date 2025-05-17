<?php

declare(strict_types=1);
use App\Exception\Handler\AppExceptionHandler;
use App\Exception\Handler\ValidationExceptionHandler;
use App\Exception\Handler\CustomExceptionHandler;
use Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler;

/**
 * This file is part of Hyperf.
 *
 * @see     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    'handler' => [
        'http' => [
            CustomExceptionHandler::class,
            HttpExceptionHandler::class,
            ValidationExceptionHandler::class,
            AppExceptionHandler::class,
        ],
    ],
];
