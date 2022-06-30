<?php

namespace Insly\QmtApiClient;

use Insly\QmtApiClient\Exceptions\ConfigException;

/**
 * Class Config
 *
 * Configuration for API client
 *
 * @package Insly\QmtApiClient
 */
class Config
{
    /**
     * Base url of the destination API
     */
    public const PARAM_HOST = 'host';

    /**
     * Tenant for requests
     */
    public const PARAM_TENANT = 'tenant';

    /**
     * Value for Authorization header
     */
    public const PARAM_AUTH_TOKEN = 'auth_token';

    /**
     * @var array
     */
    private $params;

    /**
     * @param array $params
     * @throws ConfigException
     */
    public function __construct(array $params)
    {
        $this->params = $params;
        $this->validateConfig();
    }

    /**
     * Get config parameter
     *
     * @param string $key
     * @param null   $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->params[$key] ?? $default;
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function set(string $key, string $value)
    {
        $this->params[$key] = $value;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBaseUrl(): ?string
    {
        return $this->get(self::PARAM_HOST);
    }

    /**
     * @return string|null
     */
    public function getAuthToken(): ?string
    {
        return $this->get(self::PARAM_AUTH_TOKEN);
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setAuthToken(string $token): self
    {
        return $this->set(self::PARAM_AUTH_TOKEN, $token);
    }

    /**
     * @return string|null
     */
    public function getTenant(): string
    {
        return $this->get(self::PARAM_TENANT, '');
    }

    /**
     * @return void
     * @throws ConfigException
     */
    private function validateConfig(): void
    {
        if (empty($this->get(self::PARAM_HOST))) {
            throw new ConfigException('configuration must specify ' . self::PARAM_HOST);
        }
    }
}
