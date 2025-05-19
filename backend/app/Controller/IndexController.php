<?php

declare(strict_types=1);

namespace App\Controller;

use App\Amqp\Producer\MailProducer;
use Hyperf\Amqp\Producer;
use Hyperf\Context\ApplicationContext;

class IndexController extends AbstractController
{
    public function index()
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();

        return [
            'method' => $method,
            'message' => "Hello {$user}.",
        ];
    }

    public function amqp()
    {
        $msg = $this->request->input('msg', 'Hello World');
        $producer = ApplicationContext::getContainer()->get(Producer::class);
        $producer->produce(new MailProducer($msg));

        return [
            'message' => "Message sent: {$msg}",
        ];
    }
}
