<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use App\Interfaces\NotificationServiceInterface;
use Exception;
use Hyperf\Amqp\Result;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use PhpAmqpLib\Message\AMQPMessage;

#[Consumer(exchange: 'hyperf', routingKey: 'email.send', queue: 'mail_queue', name: "MailConsumer", nums: 1)]
class MailConsumer extends ConsumerMessage
{
    public function __construct(
        protected NotificationServiceInterface $mailService
    ) {
    }

    public function consumeMessage($data, AMQPMessage $message): Result
    {
        try {
            $this->mailService->sendNotification($data['email'], $data['subject'], $data['body']);
            return Result::ACK;
        } catch (Exception $th) {
            return Result::REQUEUE;
        }
    }
}
