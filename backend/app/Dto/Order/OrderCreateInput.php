<?php

declare(strict_types=1);

namespace App\Dto\Order;

use Carbon\Carbon;

class OrderCreateInput
{
    public function __construct(
        private int $orderId,
        private readonly string $requesterName,
        private readonly string $destination,
        private readonly string $departureDate,
        private readonly string $arrivalDate,
        private readonly string $status,
        private readonly int $userId,
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

    public function getDepartureDate(): Carbon
    {
        return Carbon::createFromFormat('d-m-Y', $this->departureDate);
    }

    public function getArrivalDate(): Carbon
    {
        return Carbon::createFromFormat('d-m-Y', $this->arrivalDate);
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
