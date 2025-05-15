<?php

declare(strict_types=1);

use App\Controller\AuthController;
use App\Controller\IndexController;
use App\Middleware\AuthMiddleware;
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', [IndexController::class, 'index']);

Router::post('/login', [AuthController::class, 'login']);

Router::addGroup('/v1', function () {
    Router::get('/', [IndexController::class, 'index']);
}, ['middleware' => [AuthMiddleware::class]]);
