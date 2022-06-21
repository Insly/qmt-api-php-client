<?php

namespace Insly\QmtApiClient\Api\Models\Traits;

trait SetsFields
{
    public function setFields(array $fields): void
    {
        foreach ($fields as $fieldName => $fieldValue) {
            $this->$fieldName = $fieldValue;
        }
    }
}
