<?php

declare(strict_types=1);

use App\Interfaces\{AuthTokenInterface, UserRepositoryInterface, OrderRepositoryInterface};
use App\Repositories\{UserRepository, OrderRepository};
use App\Service\Jwt\JwtService;

/*
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    UserRepositoryInterface::class => UserRepository::class,
    OrderRepositoryInterface::class => OrderRepository::class,
    AuthTokenInterface::class => JwtService::class,
];
