<?php

declare(strict_types=1);

use App\Model\Order;
use Hyperf\Database\Seeders\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::create([
            'order_id' => 1234,
            'user_id' => 1,
            'status' => 'requested',
            'requester_name' => 'Peter pan',
            'destination' => 'Ilha do nunca',
            'departure_date' => '2025-01-01',
            'arrival_date' => '2025-01-05',
        ]);
    }
}
