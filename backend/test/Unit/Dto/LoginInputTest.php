<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Dto;

use App\Dto\Login\LoginInput;
use PHPUnit\Framework\TestCase;

class LoginInputTest extends TestCase
{
    public function testDtoWithSuccess()
    {
        $email = 'mulan@filmebomdemais.com';
        $password = 'password';

        $input = new LoginInput(email: $email, password: $password);

        $this->assertEquals($email, $input->getEmail());
        $this->assertEquals($password, $input->getPassword());
    }
}
