<?php

declare(strict_types=1);

namespace App\Dto\Order;

class OrderCreateInput
{
    public function __construct(
        private int $orderId,
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
        return $this->departureDate;
    }

    public function getArrivalDate(): string
    {
        return $this->arrivalDate;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
