<?php

namespace App\Interfaces;

use Carbon\Carbon;

interface ListOrderFilterDTO
{
    public function getStatus(): ?string;

    public function getDepartureDate(): ?Carbon;

    public function getArrivalDate(): ?Carbon;

    public function getDestination(): ?string;
}