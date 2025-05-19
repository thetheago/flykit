<?php

namespace HyperfTest\Unit\Service;

use Hyperf\Testing\TestCase;
use App\Service\AmqpMailSender;
use Mockery;
use Hyperf\Amqp\Producer;
use Hyperf\Context\ApplicationContext;
use Psr\Container\ContainerInterface;

class AmqpMailSenderTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testSendProduceMail()
    {
        $email = 'alan@zoka.com';
        $subject = 'Test Subject';
        $body = 'Test Body';

        $producer = Mockery::mock(Producer::class);
        $producer->shouldReceive('produce');

        $container = Mockery::mock(ContainerInterface::class);
        $container->shouldReceive('get')
            ->with(Producer::class)
            ->andReturn($producer);

        ApplicationContext::setContainer($container);

        $amqpMailSender = new AmqpMailSender();
        $amqpMailSender->sendMail($email, $subject, $body);

        $this->assertTrue(true);
        $producer->shouldHaveReceived('produce');
    }
}
