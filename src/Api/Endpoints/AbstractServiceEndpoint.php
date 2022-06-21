<?php

namespace Insly\QmtApiClient\Api\Endpoints;

use Insly\QmtApiClient\Api\Client;

abstract class AbstractServiceEndpoint
{
    const HTTP_STATUS_OK = 200;

    /**
     * @var string
     */
    protected $service;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $path
     * @return string
     */
    protected function tenantPath(string $path): string
    {
        return $this->servicePath(
            sprintf(
                '/t/%s%s',
                $this->client->getConfig()->getTenant(),
                $path
            )
        );
    }

    /**
     * @param string $path
     * @return string
     */
    protected function servicePath(string $path): string
    {
        return sprintf(
            '/api/v1/%s%s',
            $this->service,
            $path
        );
    }
}
