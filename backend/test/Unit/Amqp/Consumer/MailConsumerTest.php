<?php

namespace HyperfTest\Unit\Amqp\Consumer;

use App\Amqp\Consumer\MailConsumer;
use App\Interfaces\NotificationServiceInterface;
use Exception;
use Mockery;
use PhpAmqpLib\Message\AMQPMessage;
use PHPUnit\Framework\TestCase;
use Hyperf\Amqp\Result;


class MailConsumerTest extends TestCase
{
    public function testConsumeMessage()
    {
        $mailServiceMock = Mockery::mock(NotificationServiceInterface::class);
        $mailServiceMock->shouldReceive('sendNotification')->andReturn(true);

        $mailConsumer = new MailConsumer(mailService: $mailServiceMock);

        $data = [
            'email' => 'phineas@ferb.com',
            'subject' => 'amqp',
            'body' => 'sao tres dias de ferias que passam depressa'
        ];

        $message = Mockery::mock(AMQPMessage::class);

        $result = $mailConsumer->consumeMessage(
            data: $data,
            message: $message
        );

        $this->assertEquals(Result::ACK, $result);
    }

    public function testConsumeMessageWithException()
    {
        $mailServiceMock = Mockery::mock(NotificationServiceInterface::class);
        $mailServiceMock->shouldReceive('sendNotification')->andThrow(new Exception('Failed to send notification'));

        $mailConsumer = new MailConsumer(mailService: $mailServiceMock);

        $data = [
            'email' => 'expedition@33.com',
            'subject' => 'curioso',
            'body' => 'historia bonita'
        ];

        $message = Mockery::mock(AMQPMessage::class);

        $result = $mailConsumer->consumeMessage(
            data: $data,
            message: $message
        );

        $this->assertEquals(Result::REQUEUE, $result);
    }
}