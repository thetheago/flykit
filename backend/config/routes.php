<?php

declare(strict_types=1);

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use App\Middleware\AuthMiddleware;
use Hyperf\HttpServer\Router\Router;
use App\Controller\{AuthController, IndexController};

Router::addRoute(['GET', 'POST', 'HEAD'], '/', [IndexController::class, 'index']);

Router::post('/login', [AuthController::class, 'login']);

Router::addGroup('/v1', function () {
    Router::get('/', [IndexController::class, 'index']);
}, ['middleware' => [AuthMiddleware::class]]);
