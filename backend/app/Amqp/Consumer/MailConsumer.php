<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use App\Interfaces\NotificationServiceInterface;
use Exception;
use Hyperf\Amqp\Result;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use PhpAmqpLib\Message\AMQPMessage;
use Hyperf\Di\Annotation\Inject;

#[Consumer(exchange: 'hyperf', routingKey: 'email.send', queue: 'mail_queue', name: "MailConsumer", nums: 1)]
class MailConsumer extends ConsumerMessage
{
    #[Inject]
    protected NotificationServiceInterface $mailService;

    public function consumeMessage($data, AMQPMessage $message): Result
    {
        try {
            $this->mailService->sendNotification($data);
            return Result::ACK;
        } catch (Exception $th) {
            return Result::REQUEUE;
        }
    }
}
