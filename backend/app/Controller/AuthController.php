<?php

declare(strict_types=1);

namespace App\Controller;

use App\Factory\LoginInputFactory;
use App\Interfaces\AuthTokenInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Request\LoginRequest;
use App\Usecase\LoginUseCase;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AuthController
{
    #[Inject]
    private UserRepositoryInterface $userRepository;

    #[Inject]
    private LoginInputFactory $loginInputFactory;

    #[Inject]
    private AuthTokenInterface $jwtService;

    public function login(LoginRequest $request)
    {
        $input = $this->loginInputFactory->createFromRequest($request);

        $loginUsecase = new LoginUseCase($this->userRepository, $this->jwtService);
        $output = $loginUsecase->execute($input);

        return (new Response())->json([
            'token' => $output->getToken(),
        ])->withStatus(HttpResponse::HTTP_OK);
    }
}
