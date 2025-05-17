<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Dto\Order;

use App\Dto\Order\OrderCreateOutput;
use Hyperf\Testing\TestCase;

class OrderCreateOutputTest extends TestCase
{
    private int $orderId;
    private string $requesterName;
    private string $destination;
    private string $departureDate;
    private string $arrivalDate;
    private string $status;

    public function setUp(): void
    {
        parent::setUp();

        $this->orderId = 1;
        $this->requesterName = 'Samsung da silva';
        $this->destination = 'New York';
        $this->departureDate = '01-01-2023';
        $this->arrivalDate = '05-01-2023';
        $this->status = 'pending';
    }

    public function testOrderCreateOutputDtoWithSuccess()
    {
        $output = new OrderCreateOutput(
            orderId: $this->orderId,
            requesterName: $this->requesterName,
            destination: $this->destination,
            departureDate: $this->departureDate,
            arrivalDate: $this->arrivalDate,
            status: $this->status,
        );

        $this->assertEquals($this->orderId, $output->getOrderId());
        $this->assertEquals($this->requesterName, $output->getRequesterName());
        $this->assertEquals($this->destination, $output->getDestination());
        $this->assertEquals($this->departureDate, $output->getDepartureDate()->format('d-m-Y'));
        $this->assertEquals($this->arrivalDate, $output->getArrivalDate()->format('d-m-Y'));
        $this->assertEquals($this->status, $output->getStatus());
    }

    public function testOrderCreateOutputDtoToArray()
    {
        $output = new OrderCreateOutput(
            orderId: $this->orderId,
            requesterName: $this->requesterName,
            destination: $this->destination,
            departureDate: $this->departureDate,
            arrivalDate: $this->arrivalDate,
            status: $this->status,
        );

        $this->assertEquals([
            'orderId' => $this->orderId,
            'requesterName' => $this->requesterName,
            'destination' => $this->destination,
            'departureDate' => $this->departureDate,
            'arrivalDate' => $this->arrivalDate,
            'status' => $this->status,
        ], $output->toArray());
    }
}
