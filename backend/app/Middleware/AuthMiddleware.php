<?php

declare(strict_types=1);

namespace App\Middleware;

use Hyperf\Di\Container;
use Firebase\JWT\{JWT, Key};
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Hyperf\HttpServer\Request;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Response;
use Hyperf\HttpServer\Response as HyperfResponse;

use function Hyperf\Support\env;

class AuthMiddleware implements MiddlewareInterface
{
    protected string $jwtSecretKey;
    protected Request $request;
    protected HttpResponse $response;
    protected Container $container;

    public function __construct(Request $request, HttpResponse $response, Container $container)
    {
        $this->request = $request;
        $this->response = $response;
        $this->container = $container;
        $this->jwtSecretKey = env('JWT_SECRET_KEY');
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): PsrResponseInterface
    {
        $token = $this->request->getHeader('Authorization');

        if (empty($token)) {
            return (new HyperfResponse())->json([
                'message' => "Token de autenticação ausente.",
            ])->withStatus(Response::HTTP_UNAUTHORIZED);
        }

        try {
            $decoded = JWT::decode($token[0], new Key($this->jwtSecretKey, 'HS256'));
            $this->container->set('user', $decoded);
        } catch (\Exception $e) {
            return (new HyperfResponse())->json([
                'message' => "Token de autenticação inválido.",
            ])->withStatus(Response::HTTP_UNAUTHORIZED);
        }

        return $handler->handle($request);
    }
    
}
