<?php

declare(strict_types=1);

use App\Interfaces\{AuthTokenInterface, UserRepositoryInterface};
use App\Repositories\UserRepository;
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
    AuthTokenInterface::class => JwtService::class,
];
