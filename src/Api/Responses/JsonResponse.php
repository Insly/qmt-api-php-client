<?php

namespace Insly\QmtApiClient\Api\Responses;

use Psr\Http\Message\ResponseInterface;

class JsonResponse implements \Insly\QmtApiClient\Api\Responses\ResponseInterface
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->response->getStatusCode();
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return (string)$this->response->getBody();
    }

    /**
     * @return array
     */
    public function getJson(): array
    {
        return (array)\GuzzleHttp\json_decode($this->getBody(), true);
    }
}
