<?php

namespace Insly\QmtApiClient\Api\Transformers\Interfaces;

interface TransformerInterface
{
    /**
     * @param array $data
     * @return array
     */
    public function transform(array $data): array;

    /**
     * @param array $data
     * @return array
     */
    public function reverseTransform(array $data): array;
}
