<?php

namespace HyperfTest\Unit\Request;

use App\Request\OrderCreateRequest;
use Hyperf\Testing\TestCase;

class OrderCreateRequestTest extends TestCase
{
    public function testValidationRules()
    {
        $request = new OrderCreateRequest($this->getContainer());
        $rules = $request->rules();
        
        $this->assertArrayHasKey('orderId', $rules);
        $this->assertArrayHasKey('requesterName', $rules);
        $this->assertArrayHasKey('destination', $rules);
        $this->assertArrayHasKey('departureDate', $rules);
        $this->assertArrayHasKey('arrivalDate', $rules);
        $this->assertArrayHasKey('status', $rules);

        $this->assertStringContainsString('required', $rules['orderId']);
        $this->assertStringContainsString('numeric', $rules['orderId']);
        $this->assertStringContainsString('required', $rules['requesterName']);
        $this->assertStringContainsString('string', $rules['requesterName']);
        $this->assertStringContainsString('required', $rules['destination']);
        $this->assertStringContainsString('string', $rules['destination']);
        $this->assertStringContainsString('required', $rules['departureDate']);
        $this->assertStringContainsString('date', $rules['departureDate']);
        $this->assertStringContainsString('required', $rules['arrivalDate']);
        $this->assertStringContainsString('date', $rules['arrivalDate']);
        $this->assertStringContainsString('required', $rules['status']);
        $this->assertStringContainsString('in:approved,requested,cancelled', $rules['status']);
    }

    public function testValidationMessages()
    {
        $request = new OrderCreateRequest($this->getContainer());
        $messages = $request->messages();
        
        $this->assertArrayHasKey('orderId.required', $messages);
        $this->assertArrayHasKey('orderId.numeric', $messages);
        $this->assertArrayHasKey('requesterName.required', $messages);
        $this->assertArrayHasKey('requesterName.string', $messages);
        $this->assertArrayHasKey('destination.required', $messages);
        $this->assertArrayHasKey('destination.string', $messages);
        $this->assertArrayHasKey('departureDate.required', $messages);
        $this->assertArrayHasKey('departureDate.date', $messages);
        $this->assertArrayHasKey('arrivalDate.required', $messages);
        $this->assertArrayHasKey('arrivalDate.date', $messages);
        $this->assertArrayHasKey('status.required', $messages);
        $this->assertArrayHasKey('status.in', $messages);

        $this->assertEquals('O campo orderId é obrigatório.', $messages['orderId.required']);
        $this->assertEquals('O campo orderId deve ser um número.', $messages['orderId.numeric']);
        $this->assertEquals('O campo requesterName é obrigatório.', $messages['requesterName.required']);
        $this->assertEquals('O campo requesterName deve ser uma string.', $messages['requesterName.string']);
        $this->assertEquals('O campo destination é obrigatório.', $messages['destination.required']);
        $this->assertEquals('O campo destination deve ser uma string.', $messages['destination.string']);
        $this->assertEquals('O campo departureDate é obrigatório.', $messages['departureDate.required']);
        $this->assertEquals('O campo departureDate deve ser uma data válida no formato dd-mm-yyyy.', $messages['departureDate.date']);
        $this->assertEquals('O campo arrivalDate é obrigatório.', $messages['arrivalDate.required']);
        $this->assertEquals('O campo arrivalDate deve ser uma data válida no formato dd-mm-yyyy.', $messages['arrivalDate.date']);
        $this->assertEquals('O campo status é obrigatório.', $messages['status.required']);
        $this->assertEquals('O campo status deve ser um dos valores permitidos: (approved, requested, cancelled).', $messages['status.in']);
    }

    public function testAuthorizeFunctionAssert()
    {
        $request = new OrderCreateRequest($this->getContainer());
        $this->assertTrue($request->authorize());
    }
}