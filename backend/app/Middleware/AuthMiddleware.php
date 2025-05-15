<?php

declare(strict_types=1);

namespace App\Middleware;

use Hyperf\Di\Container;
use Firebase\JWT\{JWT, Key};
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Hyperf\HttpServer\{Request, Response as HttpServerResponse};
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Response;

use function Hyperf\Support\env;

class AuthMiddleware implements MiddlewareInterface
{
    protected string $jwtSecretKey;
    protected Request $request;
    protected HttpResponse $response;
    protected Container $container;

    public function __construct(Request $request, HttpServerResponse $response, Container $container)
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
            return $this->response->json(['error' => 'Token de autenticação ausente.'], Response::HTTP_UNAUTHORIZED);
        }

        try {
            $decoded = JWT::decode($token[0], new Key($this->jwtSecretKey, 'HS256'));
            $this->container->set('user', $decoded);
        } catch (\Exception $e) {
            return $this->response->json(['error' => 'Token de autenticação inválido.'], Response::HTTP_UNAUTHORIZED);
        }

        return $handler->handle($request);
    }
    
}
