<?php

namespace Insly\QmtApiClient\Api\Models\Traits;

trait GetsFields
{
    public function getFields(): array
    {
        $fields = [];
        foreach ($this as $fieldName => $fieldValue) {
            $fields[$fieldName] = $fieldValue;
        }

        return $fields;
    }
}
