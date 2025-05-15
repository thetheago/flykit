<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\WrongAccessAttemptException;
use Hyperf\HttpServer\Response;
use App\Factory\LoginInputFactory;
use App\Request\LoginRequest;
use Hyperf\Di\Annotation\Inject;
use App\Interfaces\UserRepositoryInterface;
use App\Usecase\LoginUseCase;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AuthController
{
    #[Inject]
    private UserRepositoryInterface $userRepository;

    #[Inject]
    private LoginInputFactory $loginInputFactory;

    public function login(LoginRequest $request)
    {
        try {
            $input = $this->loginInputFactory->createFromRequest($request);
    
            $loginUsecase = new LoginUseCase($this->userRepository);
            $output = $loginUsecase->execute($input);

            return (new Response())->json([
                'token' => $output->getToken(),
            ])->withStatus(HttpResponse::HTTP_OK);

        } catch (WrongAccessAttemptException $e) {
            return (new Response())->json([
                'message' => $e->getMessage(),
            ])->withStatus(HttpResponse::HTTP_UNAUTHORIZED);
        }
    }
}