<?php

namespace Insly\QmtApiClient\Api\Transformers\Master;

use Insly\QmtApiClient\Api\Transformers\AbstractTransformer;

class BrokerTransformer extends AbstractTransformer
{
    protected $fieldsMap = [
        'id' => 'id',
        'props' => 'props',
        'group_id' => 'groupId',
        'name' => 'name',
        'tag' => 'tag',
    ];
}
