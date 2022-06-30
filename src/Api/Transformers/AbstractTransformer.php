<?php

namespace Insly\QmtApiClient\Api\Transformers;

use Insly\QmtApiClient\Api\Transformers\Interfaces\TransformerInterface;

abstract class AbstractTransformer implements TransformerInterface
{
    /**
     * @var array
     */
    protected $fieldsMap = [];

    /**
     * @param array $data
     * @return array
     */
    public function transform(array $data): array
    {
        $result = [];

        foreach ($this->getFieldsMap() as $fieldFrom => $fieldTo) {
            if (isset($data[$fieldFrom])) {
                $result[$fieldTo] = $data[$fieldFrom];
            }
        }

        return $result;
    }

    /**
     * @param array $data
     * @return array
     */
    public function reverseTransform(array $data): array
    {
        $result = [];

        foreach ($this->getFieldsMap() as $fieldTo => $fieldFrom) {
            if (isset($data[$fieldFrom])) {
                $result[$fieldTo] = $data[$fieldFrom];
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    protected function getFieldsMap(): array
    {
        return $this->fieldsMap;
    }
}
