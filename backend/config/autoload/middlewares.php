<?php

declare(strict_types=1);
use App\Middleware\CorsMiddleware;
use Hyperf\Validation\Middleware\ValidationMiddleware;

/**
 * This file is part of Hyperf.
 *
 * @see     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    'http' => [
        CorsMiddleware::class,
        ValidationMiddleware::class,
    ],
];
