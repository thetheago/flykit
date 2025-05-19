<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Service;

use Hyperf\Testing\TestCase;
use App\Service\MailNotificationService;
use Exception;
use Hyperf\Guzzle\ClientFactory;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Mockery;
use Symfony\Component\HttpFoundation\Response;

class MailNotificationServiceTest extends TestCase
{
    public function testSendNotification()
    {
        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getStatusCode')->andReturn(204);

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('post')->andReturn($response);

        $clientFactoryMock = Mockery::mock(ClientFactory::class);
        $clientFactoryMock->shouldReceive('create')->andReturn($client);

        $mailNotificationService = new MailNotificationService(clientFactory: $clientFactoryMock);
        $mailNotificationService->sendNotification('phineas@ferb.com', 'amqp', 'sao tres dias de ferias que passam depressa');

        $this->assertTrue(true);
    }

    public function testSendNotificationWithException()
    {
        $messageFailed = 'Failed to send notification';

        $responseMock = Mockery::mock(ResponseInterface::class);
        $responseMock->shouldReceive('getStatusCode')->andReturn(Response::HTTP_BAD_GATEWAY);

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('post')->andReturn($responseMock);

        $clientFactoryMock = Mockery::mock(ClientFactory::class);
        $clientFactoryMock->shouldReceive('create')->andReturn($client);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage($messageFailed);

        $mailNotificationService = new MailNotificationService(clientFactory: $clientFactoryMock);
        $mailNotificationService->sendNotification('phineas@ferb.com', 'amqp', 'sao tres dias de ferias que passam depressa');
    }
    
}