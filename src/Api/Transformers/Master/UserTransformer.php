<?php

namespace Insly\QmtApiClient\Api\Transformers\Master;

use Insly\QmtApiClient\Api\Transformers\AbstractTransformer;

class UserTransformer extends AbstractTransformer
{
    protected $fieldsMap = [
        'id' => 'id',
        'props' => 'props',
        'role_id' => 'roleId',
        'broker_id' => 'brokerId',
    ];
}
