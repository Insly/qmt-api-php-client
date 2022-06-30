<?php

use Codeception\Test\Unit;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Insly\QmtApiClient\Api\Models\User;
use Insly\QmtApiClient\Config;
use Insly\QmtApiClient\Exceptions\ConfigException;
use Insly\QmtApiClient\Tests\Unit\Traits\MocksClient;

class MasterUsersTest extends Unit
{
    use MocksClient;

    /**
     * @return void
     * @throws ConfigException
     */
    public function testGetUsersList(): void
    {
        $container = [];
        $history = Middleware::history($container);

        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'results' => [
                    [
                        'id' => 'the-id',
                        'props' => [
                            'email' => 'test@example.com',
                            'name' => 'John Doe'
                        ],
                        'role_id' => 'role-id',
                        'broker_id' => 'broker-id',
                    ]
                ]
            ])),
            new Response(200, [], json_encode([
                'results' => []
            ])),
            new Response(200, [], json_encode([
                'results' => null
            ]))
        ]);

        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);

        $cfg = new Config([
            Config::PARAM_HOST => 'https://example.host',
            Config::PARAM_TENANT => 'poland',
        ]);

        $client = $this->createMockClient($cfg, $handlerStack);

        // Get list with transformed results
        $resp = $client->master()->adminGetUsersList(['page' => 1]);
        /** @var User[] $results */
        $results = $resp->getResults();

        $this->assertEquals(200, $resp->getStatusCode());
        $this->assertCount(1, $results);

        /** @var Request $sentRequest */
        $this->assertInstanceOf(User::class, $results[0]);
        $this->assertEquals('the-id', $results[0]->id);
        $this->assertEquals('role-id', $results[0]->roleId);
        $this->assertEquals('broker-id', $results[0]->brokerId);
        $this->assertEquals([
            'email' => 'test@example.com',
            'name' => 'John Doe'
        ], $results[0]->props);

        // Check request URL
        /** @var Request $sentRequest */
        $sentRequest = $container[0]['request'];
        $this->assertEquals('GET', $sentRequest->getMethod());
        $this->assertEquals('https://example.host/api/v1/master/t/poland/admin/users?page=1', (string)$sentRequest->getUri());


        // Get empty list
        $resp = $client->master()->adminGetUsersList(['page' => 1]);
        /** @var User[] $results */
        $results = $resp->getResults();

        $this->assertEquals(200, $resp->getStatusCode());
        $this->assertCount(0, $results);

        // Get empty list with 'null' results
        $resp = $client->master()->adminGetUsersList(['page' => 1]);
        /** @var User[] $results */
        $results = $resp->getResults();

        $this->assertEquals(200, $resp->getStatusCode());
        $this->assertCount(0, $results);
    }


    /**
     * @return void
     * @throws ConfigException
     */
    public function testCreateUser(): void
    {
        $container = [];
        $history = Middleware::history($container);

        $mock = new MockHandler([
            new Response(201, [], json_encode([
                'id' => 'the-id',
                'props' => [
                    'email' => 'some@email.com',
                    'name' => 'Some Name'
                ],
                'role_id' => 'some-role-id'
            ]))
        ]);

        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);

        $cfg = new Config([
            Config::PARAM_HOST => 'https://example.host',
            Config::PARAM_TENANT => 'poland',
        ]);

        $client = $this->createMockClient($cfg, $handlerStack);

        $user = new User();
        $user->props = [
            'email' => 'some@email.com',
            'name' => 'Some Name'
        ];
        $user->brokerId = 'some-broker-id';

        // Create entity
        $resp = $client->master()->adminCreateUser($user);

        $this->assertInstanceOf(User::class, $resp);
        $this->assertEquals('the-id', $resp->id);
        $this->assertEquals('some-role-id', $resp->roleId);

        // Check request URL
        /** @var Request $sentRequest */
        $sentRequest = $container[0]['request'];
        $this->assertEquals('POST', $sentRequest->getMethod());
        $this->assertEquals('https://example.host/api/v1/master/t/poland/admin/users', (string)$sentRequest->getUri());

        $this->assertEquals(
            [
                'props' => [
                    'email' => 'some@email.com',
                    'name' => 'Some Name'
                ],
                'broker_id' => 'some-broker-id',
            ],
            json_decode($sentRequest->getBody(), true)
        );
    }
}
