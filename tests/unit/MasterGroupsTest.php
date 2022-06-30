<?php

use Codeception\Test\Unit;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Insly\QmtApiClient\Api\Models\Group;
use Insly\QmtApiClient\Config;
use Insly\QmtApiClient\Exceptions\ConfigException;
use Insly\QmtApiClient\Tests\Unit\Traits\MocksClient;

class MasterGroupsTest extends Unit
{
    use MocksClient;

    /**
     * @return void
     * @throws ConfigException
     */
    public function testGetGroupsList(): void
    {
        $container = [];
        $history = Middleware::history($container);

        $mock = new MockHandler([
            new Response(200, [], json_encode([
                'results' => [
                    [
                        'id' => 'the-id',
                        'parent_id' => 'parent-id',
                        'name' => 'the name',
                        'domain_tag' => 'domain_tag',
                    ]
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
        $resp = $client->master()->adminGetGroupsList(['page' => 1]);
        /** @var Group[] $results */
        $results = $resp->getResults();

        $this->assertEquals(200, $resp->getStatusCode());
        $this->assertCount(1, $results);

        /** @var Request $sentRequest */
        $this->assertInstanceOf(Group::class, $results[0]);
        $this->assertEquals('the-id', $results[0]->id);
        $this->assertEquals('parent-id', $results[0]->parentId);
        $this->assertEquals('domain_tag', $results[0]->domainTag);
        $this->assertEquals('the name', $results[0]->name);

        // Check request URL
        /** @var Request $sentRequest */
        $sentRequest = $container[0]['request'];
        $this->assertEquals('GET', $sentRequest->getMethod());
        $this->assertEquals('https://example.host/api/v1/master/t/poland/admin/groups?page=1', (string)$sentRequest->getUri());
    }

    /**
     * @return void
     * @throws ConfigException
     */
    public function testCreateGroup(): void
    {
        $container = [];
        $history = Middleware::history($container);

        $mock = new MockHandler([
            new Response(201, [], json_encode([
                'id' => 'the-id',
                'title' => 'Some title',
                'name' => 'somename',
                'parent_id' => 'some-parent-id',
            ]))
        ]);

        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push($history);

        $cfg = new Config([
            Config::PARAM_HOST => 'https://example.host',
            Config::PARAM_TENANT => 'poland',
        ]);

        $client = $this->createMockClient($cfg, $handlerStack);

        $group = new Group();
        $group->name = 'groupname';
        $group->title = 'group title';

        // Create entity
        $resp = $client->master()->adminCreateGroup($group);

        $this->assertInstanceOf(Group::class, $resp);
        $this->assertEquals('the-id', $resp->id);
        $this->assertEquals('somename', $resp->name);
        $this->assertEquals('Some title', $resp->title);
        $this->assertEquals('some-parent-id', $resp->parentId);

        // Check request URL
        /** @var Request $sentRequest */
        $sentRequest = $container[0]['request'];
        $this->assertEquals('POST', $sentRequest->getMethod());
        $this->assertEquals('https://example.host/api/v1/master/t/poland/admin/groups', (string)$sentRequest->getUri());

        $this->assertEquals(
            [
                'name' => 'groupname',
                'title' => 'group title',
            ],
            json_decode($sentRequest->getBody(), true)
        );
    }
}
