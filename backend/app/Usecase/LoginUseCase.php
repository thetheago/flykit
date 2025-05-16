<?php

declare(strict_types=1);

namespace App\Usecase;

use App\Dto\Login\LoginInput;
use App\Dto\Login\LoginOutput;
use App\Exception\WrongAccessAttemptException;
use App\Interfaces\UserRepositoryInterface;
use Firebase\JWT\JWT;

use function Hyperf\Support\env;

class LoginUseCase
{
    protected string $jwtSecretKey;

    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->jwtSecretKey = env('JWT_SECRET_KEY');
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

        if (password_verify(password: $input->getPassword(), hash: $user->password)) {
            $tokenPayload = [
                'uuid' => $user->uuid,
                'email' => $user->email,
                'iat' => time(),
            ];

            $token = JWT::encode(
                payload: $tokenPayload,
                key: $this->jwtSecretKey,
                alg: 'HS256'
            );

            return new LoginOutput($token);
        }

        throw new WrongAccessAttemptException();
    }
}
