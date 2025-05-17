<?php

declare(strict_types=1);

namespace App\Usecase;

use App\Dto\Order\OrderCreateInput;
use App\Dto\Order\OrderCreateOutput;
use App\Exception\DuplicatedOrderNumberException;
use App\Exception\InvalidArrivalDateException;
use App\Interfaces\OrderRepositoryInterface;

class CreateOrderUsecase
{
    private OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @throws DuplicatedOrderNumberException
     * @throws InvalidArrivalDateException
     */
    public function execute(OrderCreateInput $input): OrderCreateOutput
    {
        $order = $this->orderRepository->findByOrderId($input->getOrderId());

        if ($order) {
            throw new DuplicatedOrderNumberException();
        }

        $departureDate = $input->getDepartureDate();
        $arrivalDate = $input->getArrivalDate();

        if ($departureDate->greaterThan($arrivalDate)) {
            throw new InvalidArrivalDateException();
        }

        $order = $this->orderRepository->create($input);

        return new OrderCreateOutput(
            orderId: $order->order_id,
            requesterName: $order->requester_name,
            destination: $order->destination,
            departureDate: $order->departure_date,
            arrivalDate: $order->arrival_date,
            status: $order->status,
        );
    }
}