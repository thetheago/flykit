<?php

namespace HyperfTest\Unit\Request;

use App\Request\OrderUpdateRequest;
use Hyperf\Testing\TestCase;

class OrderUpdateRequestTest extends TestCase
{
    public function testValidationRules()
    {
        $request = new OrderUpdateRequest($this->getContainer());
        $rules = $request->rules();
        $this->assertArrayHasKey('status', $rules);

        $this->assertStringContainsString('required', $rules['status']);
        $this->assertStringContainsString('in:approved,requested,cancelled', $rules['status']);
    }

    public function testValidationMessages()
    {
        $request = new OrderUpdateRequest($this->getContainer());
        $messages = $request->messages();
        
        $this->assertArrayHasKey('status.required', $messages);
        $this->assertArrayHasKey('status.in', $messages);

        $this->assertEquals('O campo status é obrigatório.', $messages['status.required']);
        $this->assertEquals('O campo status deve ser um dos valores permitidos: (approved, requested, cancelled).', $messages['status.in']);
    }

    public function testAuthorizeFunctionAssert()
    {
        $request = new OrderUpdateRequest($this->getContainer());
        $this->assertTrue($request->authorize());
    }
}