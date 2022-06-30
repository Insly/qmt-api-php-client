<?php

namespace Insly\QmtApiClient\Api;

use GuzzleHttp\Client as GuzzleClient;
use Insly\QmtApiClient\Config;
use Psr\Http\Message\ResponseInterface;

/**
 * @property Config $config
 */
trait GuzzleWrapperTrait
{
    /**
     * @param string $url
     * @param array $jsonData
     * @param array|null $headers
     * @return ResponseInterface
     */
    public function post(string $url, array $jsonData, ?array $headers = null): ResponseInterface
    {
        return $this->createClient()
            ->post(
                $url,
                $this->getRequestOptions($jsonData, $this->mergeHeaders($headers), [])
            );
    }

    /**
     * @param string $url
     * @param array $queryParams
     * @param array|null $headers
     * @return ResponseInterface
     */
    public function get(string $url, array $queryParams = [], ?array $headers = null): ResponseInterface
    {
        return $this->createClient()
            ->get(
                $url,
                $this->getRequestOptions([], $this->mergeHeaders($headers), $queryParams)
            );
    }

    /**
     * @return GuzzleClient
     */
    protected function createClient(): GuzzleClient
    {
        return new GuzzleClient([
            'base_uri' => $this->config->getBaseUrl()
        ]);
    }

    /**
     * @param array $jsonData
     * @param array $headers
     * @param array $queryParams
     * @return array
     */
    protected function getRequestOptions(array $jsonData, array $headers, array $queryParams): array
    {
        return [
            'json' => $jsonData,
            'headers' => $headers,
            'query' => $queryParams,
        ];
    }

    /**
     * @param array|null $additionalHeaders
     * @return array
     */
    protected function mergeHeaders(?array $additionalHeaders): array
    {
        $headers = [];

        if ($authToken = $this->config->getAuthToken()) {
            $headers['Authorization'] = $authToken;
        }

        if ($additionalHeaders) {
            $headers += $additionalHeaders;
        }

        return $headers;
    }
}
