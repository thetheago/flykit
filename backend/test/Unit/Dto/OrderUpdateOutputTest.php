<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Dto;

use App\Constants\OrderStatus;
use App\Dto\Order\OrderUpdateOutput;
use PHPUnit\Framework\TestCase;

class OrderUpdateOutputTest extends TestCase
{
    public function testOrderUpdateOutputShouldCreateAndReturnCorrectValues(): void
    {
        $orderId = 1;
        $requesterName = 'John Doe';
        $destination = 'New York';
        $departureDate = '20-03-2024';
        $arrivalDate = '21-03-2024';
        $status = OrderStatus::APPROVED;

        $output = new OrderUpdateOutput(
            orderId: $orderId,
            requesterName: $requesterName,
            destination: $destination,
            departureDate: $departureDate,
            arrivalDate: $arrivalDate,
            status: $status
        );

        $this->assertSame($orderId, $output->getOrderId());
        $this->assertSame($requesterName, $output->getRequesterName());
        $this->assertSame($destination, $output->getDestination());
        $this->assertEquals($departureDate, $output->getDepartureDate());
        $this->assertEquals($arrivalDate, $output->getArrivalDate());
        $this->assertSame($status, $output->getStatus());
    }

    public function testToArrayShouldReturnCorrectArray(): void
    {
        $orderId = 1;
        $requesterName = 'John Doe';
        $destination = 'New York';
        $departureDate = '20-03-2024';
        $arrivalDate = '21-03-2024';
        $status = OrderStatus::APPROVED;

        $output = new OrderUpdateOutput(
            orderId: $orderId,
            requesterName: $requesterName,
            destination: $destination,
            departureDate: $departureDate,
            arrivalDate: $arrivalDate,
            status: $status
        );

        $array = $output->toArray();

        $this->assertSame([
            'orderId' => $orderId,
            'requesterName' => $requesterName,
            'destination' => $destination,
            'departureDate' => $departureDate,
            'arrivalDate' => $arrivalDate,
            'status' => $status
        ], $array);
    }
} 