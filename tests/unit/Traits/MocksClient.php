<?php


namespace Insly\QmtApiClient\Tests\Unit\Traits;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use Insly\QmtApiClient\Api\Client;
use Insly\QmtApiClient\Config;

trait MocksClient
{
    /**
     * @param Config $config
     * @param HandlerStack $handlers
     * @return Client
     * @throws Exception
     */
    protected function createMockClient(Config $config, HandlerStack $handlers): object
    {
        return $this->construct(
            Client::class,
            [
                'config' => $config
            ],
            [
                'createClient' => function() use ($config, $handlers) {
                    return new GuzzleClient([
                        'base_uri' => $config->getBaseUrl(),
                        'handler' => $handlers
                    ]);
                }
            ]
        );
    }
}
