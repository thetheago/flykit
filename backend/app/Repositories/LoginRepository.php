<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Exceptions\{UserNotFound, WrongUserPasswordException};
use App\Interfaces\LoginRepositoryInterface;
use App\Model\User;
use App\Request\LoginRequest;
use Firebase\JWT\JWT;
use function Hyperf\Support\env;

class LoginRepository implements LoginRepositoryInterface 
{
    protected string $jwtSecretKey;

    protected User $user;

    public function __construct(User $user)
    {
        $this->jwtSecretKey = env('JWT_SECRET_KEY');
        $this->user = $user;
    }

    /**
     * @param LoginRequest $request
     * @return array ['token' => $token]
     * @throws UserNotFound
     * @throws WrongUserPasswordException
     */
    public function login(LoginRequest $request): array
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = $this->getUserByEmail($email);

        if (!$user) {
            throw new UserNotFound();
        }

        if (password_verify(password: $password, hash: $user->password)) {
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

            return ['token' => $token];
        }

        throw new WrongUserPasswordException();        
    }

    private function getUserByEmail(string $email)
    {
        return $this->user->where('email', $email)->first();
    }
}