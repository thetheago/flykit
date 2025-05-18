<?php

declare(strict_types=1);

use App\Interfaces\{
    AuthTokenInterface,
    OrderAuthorizationValidatorInterface,
    UserRepositoryInterface,
    OrderRepositoryInterface};
use App\Repositories\{UserRepository, OrderRepository};
use App\Service\Jwt\JwtService;
use App\Service\OrderAuthorizationValidator;

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
    OrderAuthorizationValidatorInterface::class => OrderAuthorizationValidator::class,
];
