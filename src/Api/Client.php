<?php

namespace Insly\QmtApiClient\Api;

use Insly\QmtApiClient\Api\Endpoints\MasterServiceEndpoint;
use Insly\QmtApiClient\Config;

class Client
{
    use GuzzleWrapperTrait;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Master service endpoints
     *
     * @return MasterServiceEndpoint
     */
    public function master(): MasterServiceEndpoint
    {
        return new MasterServiceEndpoint($this);
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }
}
