<?php

declare(strict_types=1);

namespace App\Test\Unit\Dto\Login;

use App\Dto\Login\LoginInput;
use PHPUnit\Framework\TestCase;

class LoginInputTest extends TestCase
{
    public function testDtoWithSuccess()
    {
        $email = 'test@example.com';
        $password = 'password';

        $input = new LoginInput(email: $email, password: $password);

        $this->assertEquals($email, $input->getEmail());
        $this->assertEquals($password, $input->getPassword());
    }
}
