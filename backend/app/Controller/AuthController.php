<?php

declare(strict_types=1);

namespace App\Controller;

use App\Constants\AuthConstants;
use App\Factory\LoginInputFactory;
use App\Factory\LoginOutputFactory;
use App\Interfaces\AuthTokenInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Request\LoginRequest;
use App\Usecase\LoginUseCase;
use Hyperf\Di\Annotation\Inject;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Hyperf\HttpMessage\Cookie\Cookie;

class AuthController extends AbstractController
{
    #[Inject]
    private UserRepositoryInterface $userRepository;

    #[Inject]
    private LoginInputFactory $loginInputFactory;

    #[Inject]
    private AuthTokenInterface $jwtService;

    #[Inject]
    private LoginOutputFactory $loginOutputFactory;

    public function login(LoginRequest $request)
    {
        $input = $this->loginInputFactory->createFromRequest($request);

        $loginUsecase = new LoginUseCase(
            userRepository: $this->userRepository,
            jwtService: $this->jwtService,
            loginOutputFactory: $this->loginOutputFactory,
        );
        $output = $loginUsecase->execute($input);

        $cookie = new Cookie(
            name: AuthConstants::TOKEN_NAME,
            value: $output->getToken(),
            expire: $output->getExpirationTime()
        );

        return $this->response
                ->withCookie($cookie)
                ->withContent(json_encode($output->toArray()))
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(HttpResponse::HTTP_OK);
    }

    public function profile()
    {
        $user = $this->container->get('user');
        return $this->response->json($user)->withStatus(HttpResponse::HTTP_OK);
    }
}
