<?php

namespace HyperfTest\Unit\Request;

use App\Request\ListAllOrderRequest;
use Hyperf\Testing\TestCase;

class ListAllOrderRequestTest extends TestCase
{
    public function testValidationRules()
    {
        $request = new ListAllOrderRequest($this->getContainer());
        $rules = $request->rules();

        $this->assertArrayHasKey('status', $rules);
        $this->assertArrayHasKey('departureDate', $rules);
        $this->assertArrayHasKey('arrivalDate', $rules);
        $this->assertArrayHasKey('destination', $rules);

        $this->assertStringContainsString('date', $rules['departureDate']);
        $this->assertStringContainsString('date', $rules['arrivalDate']);
        $this->assertStringContainsString('string', $rules['destination']);
        $this->assertStringContainsString('required_with', $rules['arrivalDate']);
        $this->assertStringContainsString('nullable', $rules['status']);
        $this->assertStringContainsString('in', $rules['status']);
    }

    public function testValidationMessages()
    {
        $request = new ListAllOrderRequest($this->getContainer());
        $messages = $request->messages();
        
        $this->assertArrayHasKey('departureDate.date', $messages);
        $this->assertArrayHasKey('arrivalDate.date', $messages);
        $this->assertArrayHasKey('destination.string', $messages);
        $this->assertArrayHasKey('arrivalDate.required_with', $messages);
        $this->assertArrayHasKey('status.in', $messages);

        $this->assertEquals('Departure date must be a valid date in the format dd-mm-yyyy.', $messages['departureDate.date']);
        $this->assertEquals('Arrival date must be a valid date in the format dd-mm-yyyy.', $messages['arrivalDate.date']);
        $this->assertEquals('Destination must be a string.', $messages['destination.string']);
        $this->assertEquals('Arrival date is required when departure date is provided.', $messages['arrivalDate.required_with']);
        $this->assertEquals('Status must be one of the following values: (approved, requested, cancelled).', $messages['status.in']);
    }

    public function testAuthorizeFunctionAssert()
    {
        $request = new ListAllOrderRequest($this->getContainer());
        $this->assertTrue($request->authorize());
    }
} 