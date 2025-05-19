<?php

declare(strict_types=1);

namespace App\Amqp\Producer;

use Hyperf\Amqp\Annotation\Producer;
use Hyperf\Amqp\Message\ProducerMessage;

#[Producer(exchange: 'hyperf', routingKey: 'email.send')]
class MailProducer extends ProducerMessage
{
    public function __construct(
        public string $email,
        public string $subject,
        public string $body,
    ) {
        $this->payload = [
            'email' => $email,
            'subject' => $subject,
            'body' => $body,
        ];
    }
}
