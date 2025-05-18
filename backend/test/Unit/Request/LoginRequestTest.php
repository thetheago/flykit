<?php

namespace HyperfTest\Unit\Request;

use App\Request\LoginRequest;
use Hyperf\Testing\TestCase;

class LoginRequestTest extends TestCase
{
    public function testValidationRules()
    {
        $request = new LoginRequest($this->getContainer());
        $rules = $request->rules();
        
        $this->assertArrayHasKey('email', $rules);
        $this->assertArrayHasKey('password', $rules);

        $this->assertStringContainsString('required', $rules['email']);
        $this->assertStringContainsString('email', $rules['email']);
        $this->assertStringContainsString('required', $rules['password']);
        $this->assertStringContainsString('string', $rules['password']);
        $this->assertStringContainsString('min:6', $rules['password']);
    }

    public function testValidationMessages()
    {
        $request = new LoginRequest($this->getContainer());
        $messages = $request->messages();
        
        $this->assertArrayHasKey('email.required', $messages);
        $this->assertArrayHasKey('email.email', $messages);
        $this->assertArrayHasKey('password.required', $messages);
        $this->assertArrayHasKey('password.string', $messages);
        $this->assertArrayHasKey('password.min', $messages);

        $this->assertEquals('O campo e-mail é obrigatório.', $messages['email.required']);
        $this->assertEquals('O campo e-mail deve ser um endereço de e-mail válido.', $messages['email.email']);
        $this->assertEquals('O campo senha é obrigatório.', $messages['password.required']);
        $this->assertEquals('O campo senha deve ser uma string.', $messages['password.string']);
        $this->assertEquals('O campo senha deve ter no mínimo 6 caracteres.', $messages['password.min']);
    }

    public function testAuthorizeFunctionAssert()
    {
        $request = new LoginRequest($this->getContainer());
        $this->assertTrue($request->authorize());
    }
} 