<?php

namespace HyperfTest\Unit\Factory;

use App\Dto\Order\ListAllOrderOutput;
use App\Factory\ListAllOrderOutputFactory;
use App\Model\Order;
use App\Constants\OrderStatus;
use Hyperf\Database\Model\Collection;
use PHPUnit\Framework\TestCase;
use Carbon\Carbon;

class ListAllOrderOutputFactoryTest extends TestCase
{
    public function testListAllOrderOutputFactoryWithSuccess()
    {
        $listAllOrderOutputFactory = new ListAllOrderOutputFactory();

        $orders = Collection::make([
            new Order([
                'order_id' => 1,
                'requester_name' => 'Bruce banner',
                'destination' => 'Chicago eu acho',
                'departure_date' => '2023-01-01',
                'arrival_date' => '2023-01-05',
                'status' => OrderStatus::REQUESTED,
            ]),
            new Order([
                'order_id' => 2,
                'requester_name' => 'Goku Henrique kkkkkkkkkk',
                'destination' => 'Namekuzen',
                'departure_date' => '2023-01-02',
                'arrival_date' => '2023-01-06',
                'status' => OrderStatus::APPROVED,
            ]),
            new Order([
                'order_id' => 3,
                'requester_name' => 'Chaves',
                'destination' => 'Vila',
                'departure_date' => '2021-01-03',
                'arrival_date' => '2023-01-03',
                'status' => OrderStatus::CANCELLED,
            ])
        ]);

        $listAllOrderOutput = $listAllOrderOutputFactory->createFromModelCollection($orders);

        $this->assertInstanceOf(ListAllOrderOutput::class, $listAllOrderOutput);
        $this->assertEquals($orders->count(), count($listAllOrderOutput->getOrders()));
        
        foreach ($listAllOrderOutput->getOrders() as $order) {
            $this->assertTrue(
                Carbon::createFromFormat('d-m-Y', $order['departureDate']) !== false,
                'Departure date should be in d-m-Y format'
            );
            $this->assertTrue(
                Carbon::createFromFormat('d-m-Y', $order['arrivalDate']) !== false,
                'Arrival date should be in d-m-Y format'
            );
        }
    }
}
