<?php

use Codeception\Test\Unit;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Insly\QmtApiClient\Api\Models\Broker;
use Insly\QmtApiClient\Config;
use Insly\QmtApiClient\Exceptions\ConfigException;
use Insly\QmtApiClient\Tests\Unit\Traits\MocksClient;

class MasterBrokersTest extends Unit
{
    use MocksClient;

    /**
     * @return void
     * @throws ConfigException
     */
    public function testGetBrokersList(): void
    {
        $container = [];
        $history = Middleware::history($container);

        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'results' => [
                    [
                        'id' => 'the-id',
                        'props' => ['foo' => 'bar'],
                        'group_id' => 'group-id',
                        'name' => 'the name',
                        'tag' => 'the_tag',
                    ]
                ]
            ]))
        ]);

        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);

        $cfg = new Config([
            Config::PARAM_HOST => 'https://example.host',
            Config::PARAM_TENANT => 'poland',
            Config::PARAM_AUTH_TOKEN => 'Bearer foo',
        ]);

        $client = $this->createMockClient($cfg, $handlerStack);

        // Get list with transformed results
        $resp = $client->master()->adminGetBrokersList(['page' => 1]);
        /** @var Broker[] $results */
        $results = $resp->getResults();

        $this->assertEquals(200, $resp->getStatusCode());
        $this->assertCount(1, $results);

        /** @var Request $sentRequest */
        $this->assertInstanceOf(Broker::class, $results[0]);
        $this->assertEquals('the-id', $results[0]->id);
        $this->assertEquals('group-id', $results[0]->groupId);
        $this->assertEquals('the_tag', $results[0]->tag);
        $this->assertEquals('the name', $results[0]->name);
        $this->assertEquals(['foo' => 'bar'], $results[0]->props);

        // Check request URL
        /** @var Request $sentRequest */
        $sentRequest = $container[0]['request'];
        $this->assertEquals('GET', $sentRequest->getMethod());
        $this->assertEquals('https://example.host/api/v1/master/t/poland/admin/brokers?page=1', (string)$sentRequest->getUri());
    }

    /**
     * @return void
     * @throws ConfigException
     */
    public function testCreateBroker(): void
    {
        $container = [];
        $history = Middleware::history($container);

        $mock = new MockHandler([
            new Response(201, [], json_encode([
                'id' => 'the-id',
                'group_id' => 'some-group-id'
            ]))
        ]);

        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);

        $cfg = new Config([
            Config::PARAM_HOST => 'https://example.host',
            Config::PARAM_TENANT => 'poland',
        ]);

        $client = $this->createMockClient($cfg, $handlerStack);

        $broker = new Broker();
        $broker->name = 'Broker Name';
        $broker->tag = 'broker_tag';

        // Create entity
        $resp = $client->master()->adminCreateBroker($broker);

        $this->assertInstanceOf(Broker::class, $resp);
        $this->assertEquals('the-id', $resp->id);
        $this->assertEquals('some-group-id', $resp->groupId);

        // Check request URL
        /** @var Request $sentRequest */
        $sentRequest = $container[0]['request'];
        $this->assertEquals('POST', $sentRequest->getMethod());
        $this->assertEquals('https://example.host/api/v1/master/t/poland/admin/brokers', (string)$sentRequest->getUri());

        $this->assertEquals(
            [
                'name' => 'Broker Name',
                'tag' => 'broker_tag',
                'props' => []
            ],
            json_decode($sentRequest->getBody(), true)
        );
    }
}
