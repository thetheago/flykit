<?php

namespace HyperfTest\Unit\Amqp\Producer;

use Hyperf\Testing\TestCase;
use App\Amqp\Producer\MailProducer;
use ReflectionClass;

class MailProducerTest extends TestCase
{
    public function testPayload()
    {
        $email = 'esse@testeaqui.com';
        $subject = 'É IMPORTANTE DEMAIS';
        $body = 'SE NÃO O SWOOLE QUEBRA TUDO QUANDO O PRODUCER FAZ ALGUMA COISA';

        $mailProducer = new MailProducer(
            email: $email,
            subject: $subject,
            body: $body,
        );

        $reflection = new ReflectionClass($mailProducer);
        $property = $reflection->getProperty('payload');
        $property->setAccessible(true);
        
        $expectedPayload = [
            'email' => $email,
            'subject' => $subject,
            'body' => $body,
        ];

        $this->assertEquals($expectedPayload, $property->getValue($mailProducer));
    }
}