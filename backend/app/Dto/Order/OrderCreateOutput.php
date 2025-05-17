<?php

declare(strict_types=1);

namespace App\Dto\Order;

use Carbon\Carbon;

class OrderCreateOutput
{
    public function __construct(
        private readonly int $orderId,
        private readonly string $requesterName,
        private readonly string $destination,
        private readonly string $departureDate,
        private readonly string $arrivalDate,
        private readonly string $status,
    ) {
    }

    public function toArray(): array
    {
        return [
            'orderId' => $this->orderId,
            'requesterName' => $this->requesterName,
            'destination' => $this->destination,
            'departureDate' => Carbon::parse($this->departureDate)->format('d-m-Y'),
            'arrivalDate' => Carbon::parse($this->arrivalDate)->format('d-m-Y'),
            'status' => $this->status
        ];
    }
} 