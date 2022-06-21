<?php

namespace Insly\QmtApiClient\Api\Transformers;

use Insly\QmtApiClient\Api\Models\Interfaces\HasSetFields;
use Insly\QmtApiClient\Api\Transformers\Interfaces\TransformerInterface;

class ResultsTransformer
{
    /**
     * @var string
     */
    protected $resultsField = 'results';

    /**
     * @var HasSetFields
     */
    private $resultModel;

    /**
     * @var TransformerInterface
     */
    private $modelTransformer;

    /**
     * @param HasSetFields $resultModel
     * @param TransformerInterface $modelTransformer
     */
    public function __construct(HasSetFields $resultModel, TransformerInterface $modelTransformer)
    {
        $this->resultModel = $resultModel;
        $this->modelTransformer = $modelTransformer;
    }

    /**
     * @param array $data
     * @return array
     */
    public function transform(array $data): array
    {
        $results = [];
        foreach ($this->getResults($data) as $result) {
            $model = clone $this->resultModel;
            $model->setFields($this->modelTransformer->transform($result));

            $results[] = $model;
        }

        return $results;
    }

    /**
     * @param array $data
     * @return array
     */
    protected function getResults(array $data): array
    {
        return (array)$data[$this->resultsField] ?? [];
    }
}
