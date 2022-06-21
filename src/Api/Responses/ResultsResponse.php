<?php

namespace Insly\QmtApiClient\Api\Responses;

use Insly\QmtApiClient\Api\Transformers\ResultsTransformer;
use Psr\Http\Message\ResponseInterface;

class ResultsResponse extends JsonResponse
{
    /**
     * @var ResultsTransformer
     */
    protected $transformer;

    /**
     * @param ResponseInterface $response
     * @param ResultsTransformer $transformer
     */
    public function __construct(ResponseInterface $response, ResultsTransformer $transformer)
    {
        parent::__construct($response);
        $this->transformer = $transformer;
    }

    /**
     * @return array
     */
    public function getResults(): array
    {
        return $this->transformer->transform($this->getJson());
    }
}
