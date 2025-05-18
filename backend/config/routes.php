<?php

declare(strict_types=1);

use App\Controller\{
    AuthController,
    IndexController,
    OrderController
};
use App\Middleware\AuthMiddleware;
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', [IndexController::class, 'index']);

Router::post('/login', [AuthController::class, 'login']);

Router::addGroup('/v1', function () {
    Router::post('/order', [OrderController::class, 'create']);
    Router::patch('/order/{orderId}', [OrderController::class, 'update']);
    Router::get('/order', [OrderController::class, 'list']);
}, ['middleware' => [AuthMiddleware::class]]);
