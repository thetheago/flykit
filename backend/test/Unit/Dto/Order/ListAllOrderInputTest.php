<?php

namespace HyperfTest\Unit\Dto\Order;

use App\Constants\OrderStatus;
use App\Dto\Order\ListAllOrderInput;
use App\Interfaces\ListOrderFilterDTO;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class ListAllOrderInputTest extends TestCase
{
    public function testListAllOrderInputDtoWithSuccess()
    {
        $userId = 1;
        $status = OrderStatus::REQUESTED;
        $departureDate = '2023-01-01';
        $arrivalDate = '2023-01-05';
        $destination = 'New York';

        $listAllOrderInput = new ListAllOrderInput(
            userId: $userId,
            status: $status,
            departureDate: $departureDate,
            arrivalDate: $arrivalDate,
            destination: $destination
        );

        $this->assertEquals($userId, $listAllOrderInput->getUserId());
        $this->assertEquals($status, $listAllOrderInput->getStatus());
        $this->assertEquals($destination, $listAllOrderInput->getDestination());

        $this->assertInstanceOf(Carbon::class, $listAllOrderInput->getDepartureDate());
        $this->assertInstanceOf(Carbon::class, $listAllOrderInput->getArrivalDate());

        $departureDate = Carbon::parse($departureDate);
        $arrivalDate = Carbon::parse($arrivalDate);
        $this->assertEquals($departureDate, $listAllOrderInput->getDepartureDate());
        $this->assertEquals($arrivalDate, $listAllOrderInput->getArrivalDate());
    }

    public function testListAllOrderInputDtoWithNullFilters()
    {
        $listAllOrderInput = new ListAllOrderInput(
            userId: 1,
        );

        $this->assertNull($listAllOrderInput->getStatus());
        $this->assertNull($listAllOrderInput->getDepartureDate());
        $this->assertNull($listAllOrderInput->getArrivalDate());
        $this->assertNull($listAllOrderInput->getDestination());
    }

    public function testAssertDTOImplementsListOrderFilterDTO()
    {
        $listAllOrderInput = new ListAllOrderInput(
            userId: 1,
        );

        $this->assertInstanceOf(ListOrderFilterDTO::class, $listAllOrderInput);
    }
}
