<?php

namespace Insly\QmtApiClient\Api\Transformers\Master;

use Insly\QmtApiClient\Api\Transformers\AbstractTransformer;

class RoleTransformer extends AbstractTransformer
{
    protected $fieldsMap = [
        'id' => 'id',
        'name' => 'name',
    ];
}
