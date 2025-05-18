<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Dto\Order;

use App\Dto\Order\OrderCreateInput;
use App\Constants\OrderStatus;
use Hyperf\Testing\TestCase;

class OrderCreateInputTest extends TestCase
{
    public function testOrderCreateInputDtoWithSuccess()
    {
        $orderId = 1;
        $requesterName = 'John Doe';
        $destination = 'New York';
        $departureDate = '01-01-2023';
        $arrivalDate = '05-01-2023';
        $status = OrderStatus::REQUESTED;
        $userId = 1;

        $input = new OrderCreateInput(
            orderId: $orderId,
            requesterName: $requesterName,
            destination: $destination,
            departureDate: $departureDate,
            arrivalDate: $arrivalDate,
            status: $status,
            userId: $userId,
        );

        $this->assertEquals($orderId, $input->getOrderId());
        $this->assertEquals($requesterName, $input->getRequesterName());
        $this->assertEquals($destination, $input->getDestination());
        $this->assertEquals($departureDate, $input->getDepartureDate()->format('d-m-Y'));
        $this->assertEquals($arrivalDate, $input->getArrivalDate()->format('d-m-Y'));
        $this->assertEquals($status, $input->getStatus());
        $this->assertEquals($userId, $input->getUserId());
    }
}
