<?php

namespace Insly\QmtApiClient\Api\Responses;

interface ResponseInterface
{
    /**
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * @return string
     */
    public function getBody(): string;
}
