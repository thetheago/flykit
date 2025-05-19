<?php

declare(strict_types=1);

namespace App\Dto\Order;

use Carbon\Carbon;

class OrderUpdateOutput
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

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getRequesterName(): string
    {
        return $this->requesterName;
    }

    public function getDestination(): string
    {
        return $this->destination;
    }

    public function getDepartureDate(): string
    {
        return Carbon::parse($this->departureDate)->format('d-m-Y');
    }

    public function getArrivalDate(): string
    {
        return Carbon::parse($this->arrivalDate)->format('d-m-Y');
    }

    public function getStatus(): string
    {
        return $this->status;
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
