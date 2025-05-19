<?php

namespace App\Service;

use App\Amqp\Producer\MailProducer;
use Hyperf\Amqp\Producer;
use Hyperf\Context\ApplicationContext;

class AmqpMailSender
{
    public function sendMail(string $email, string $subject, string $body): void
    {
        $mailProducer = new MailProducer(email: $email, subject: $subject, body: $body);
        $producer = ApplicationContext::getContainer()->get(Producer::class);
        $producer->produce($mailProducer);
    }
}
