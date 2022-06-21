<?php

use Codeception\Test\Unit;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Insly\QmtApiClient\Api\Models\Role;
use Insly\QmtApiClient\Config;
use Insly\QmtApiClient\Exceptions\ConfigException;
use Insly\QmtApiClient\Tests\Unit\Traits\MocksClient;

class MasterRolesTest extends Unit
{
    use MocksClient;

    /**
     * @return void
     * @throws ConfigException
     */
    public function testGetRolesList(): void
    {
        $container = [];
        $history = Middleware::history($container);

        $mock = new MockHandler([
            new Response(200, [], json_encode([
                [
                    'id' => 'the-id',
                    'name' => 'the name',
                ]
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
        $resp = $client->master()->adminGetRolesList('group-id', ['page' => 1]);
        /** @var Role[] $results */
        $results = $resp->getResults();

        $this->assertEquals(200, $resp->getStatusCode());
        $this->assertCount(1, $results);

        /** @var Request $sentRequest */
        $this->assertInstanceOf(Role::class, $results[0]);
        $this->assertEquals('the-id', $results[0]->id);
        $this->assertEquals('the name', $results[0]->name);

        // Check request URL
        /** @var Request $sentRequest */
        $sentRequest = $container[0]['request'];
        $this->assertEquals('GET', $sentRequest->getMethod());
        $this->assertEquals('https://example.host/api/v1/master/t/poland/admin/groups/group-id/roles?page=1', (string)$sentRequest->getUri());
    }

    /**
     * @return void
     * @throws ConfigException
     */
    public function testCreateRole(): void
    {
        $container = [];
        $history = Middleware::history($container);

        $mock = new MockHandler([
            new Response(201, [], json_encode([
                'id' => 'the-id',
                'name' => 'somename',
            ]))
        ]);

        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);

        $cfg = new Config([
            Config::PARAM_HOST => 'https://example.host',
            Config::PARAM_TENANT => 'poland',
        ]);

        $client = $this->createMockClient($cfg, $handlerStack);

        $role = new Role();
        $role->name = 'somename';

        // Create entity
        $resp = $client->master()->adminCreateRole('some-group-id', $role);

        $this->assertInstanceOf(Role::class, $resp);
        $this->assertEquals('the-id', $resp->id);
        $this->assertEquals('somename', $resp->name);

        // Check request URL
        /** @var Request $sentRequest */
        $sentRequest = $container[0]['request'];
        $this->assertEquals('POST', $sentRequest->getMethod());
        $this->assertEquals('https://example.host/api/v1/master/t/poland/admin/groups/some-group-id/roles', (string)$sentRequest->getUri());

        $this->assertEquals(
            [
                'name' => 'somename',
            ],
            json_decode($sentRequest->getBody(), true)
        );
    }
}
