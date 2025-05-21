<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use App\Constants\OrderStatus;
use App\Model\Order;

class AaOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // First order - Requested status
        Order::create([
            'order_id' => 1234,
            'user_id' => 1,
            'status' => OrderStatus::REQUESTED,
            'requester_name' => 'Peter Pan',
            'destination' => 'Ilha do Nunca',
            'departure_date' => '2025-01-01',
            'arrival_date' => '2025-01-05',
        ]);

        // Second order - Approved status
        Order::create([
            'order_id' => 1235,
            'user_id' => 1,
            'status' => OrderStatus::APPROVED,
            'requester_name' => 'Alice Wonderland',
            'destination' => 'País das Maravilhas',
            'departure_date' => '2025-02-15',
            'arrival_date' => '2025-02-20',
        ]);

        // Third order - Approved status (different user)
        Order::create([
            'order_id' => 1236,
            'user_id' => 2,
            'status' => OrderStatus::APPROVED,
            'requester_name' => 'Dorothy Gale',
            'destination' => 'Oz',
            'departure_date' => '2025-03-10',
            'arrival_date' => '2025-03-15',
        ]);

        Order::create([
            'order_id' => 1242,
            'user_id' => 2,
            'status' => OrderStatus::REQUESTED,
            'requester_name' => 'Mulan',
            'destination' => 'China',
            'departure_date' => '2025-03-10',
            'arrival_date' => '2025-03-15',
        ]);

        // Fourth order - Cancelled status
        Order::create([
            'order_id' => 1237,
            'user_id' => 2,
            'status' => OrderStatus::CANCELLED,
            'requester_name' => 'Capitão Gancho',
            'destination' => 'Navio Pirata',
            'departure_date' => '2025-04-01',
            'arrival_date' => '2025-04-05',
        ]);

        // Fifth order - Requested status (different user)
        Order::create([
            'order_id' => 1238,
            'user_id' => 3,
            'status' => OrderStatus::REQUESTED,
            'requester_name' => 'Sinbad',
            'destination' => 'Mar das Mil Ilhas',
            'departure_date' => '2025-05-20',
            'arrival_date' => '2025-05-25',
        ]);

        // Sixth order - Approved status (different user)
        Order::create([
            'order_id' => 1239,
            'user_id' => 3,
            'status' => OrderStatus::APPROVED,
            'requester_name' => 'Aladim',
            'destination' => 'Agrabah',
            'departure_date' => '2025-06-15',
            'arrival_date' => '2025-06-20',
        ]);

        // Seventh order - Different destination with same dates
        Order::create([
            'order_id' => 1240,
            'user_id' => 1,
            'status' => OrderStatus::REQUESTED,
            'requester_name' => 'Mogli',
            'destination' => 'Selva',
            'departure_date' => '2025-01-01',
            'arrival_date' => '2025-01-05',
        ]);

        // Eighth order - Different status for same user
        Order::create([
            'order_id' => 1241,
            'user_id' => 1,
            'status' => OrderStatus::CANCELLED,
            'requester_name' => 'Peter Pan',
            'destination' => 'Terra do Nunca',
            'departure_date' => '2025-07-01',
            'arrival_date' => '2025-07-10',
        ]);
    }
}
