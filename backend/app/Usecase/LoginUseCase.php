<?php

declare(strict_types=1);

namespace App\Usecase;

use App\Dto\Login\LoginInput;
use App\Dto\Login\LoginOutput;
use App\Exception\WrongAccessAttemptException;
use App\Factory\LoginOutputFactory;
use App\Interfaces\AuthTokenInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Service\Jwt\JwtToken;

class LoginUseCase
{
    protected AuthTokenInterface $jwtService;

    protected UserRepositoryInterface $userRepository;

    protected LoginOutputFactory $loginOutputFactory;

    public function __construct(
        UserRepositoryInterface $userRepository,
        AuthTokenInterface $jwtService,
        LoginOutputFactory $loginOutputFactory
    ) {
        $this->userRepository = $userRepository;
        $this->jwtService = $jwtService;
        $this->loginOutputFactory = $loginOutputFactory;
    }

    /**
     * @throws WrongAccessAttemptException
     */
    public function execute(LoginInput $input): LoginOutput
    {
        $user = $this->userRepository->getUserByEmail($input->getEmail());

        if (!$user) {
            throw new WrongAccessAttemptException();
        }

        if (!password_verify(password: $input->getPassword(), hash: $user->password)) {
            throw new WrongAccessAttemptException();
        }

        $tokenPayload = new JwtToken(
            id: $user->id,
            email: $user->email,
            isAdmin: (bool) $user->is_admin,
            iat: time()
        );

        $token = $this->jwtService->generateToken($tokenPayload);

        return $this->loginOutputFactory->createFromLoginUseCase(
            tokenPayload: $tokenPayload,
            token: $token
        );
    }
}
