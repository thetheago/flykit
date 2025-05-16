<?php

declare(strict_types=1);

namespace App\Usecase;

use App\Dto\Order\OrderCreateInput;

class CreateOrderUsecase
{
    public function execute(OrderCreateInput $input): void
    {
        // verificar se order id existe
        // domain exception se existir

        // arrivalDate tem que ser maior que departureDate

        // criar order vinculada ao user logado
    }
}