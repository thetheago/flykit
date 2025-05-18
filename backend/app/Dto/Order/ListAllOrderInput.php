<?php

namespace App\Dto\Order;

use App\Interfaces\ListOrderFilterDTO;
use Carbon\Carbon;

class ListAllOrderInput implements ListOrderFilterDTO
{
    public function __construct(
        private int $userId,
        private ?string $status = null,
        private ?string $departureDate = null,
        private ?string $arrivalDate = null,
        private ?string $destination = null,
    ) {}

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getDepartureDate(): ?Carbon
    {
        if (!$this->departureDate) {
            return null;
        }

        return Carbon::parse($this->departureDate);
    }

    public function getArrivalDate(): ?Carbon
    {
        if (!$this->arrivalDate) {
            return null;
        }

        return Carbon::parse($this->arrivalDate);
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }
}
