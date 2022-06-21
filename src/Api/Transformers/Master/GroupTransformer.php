<?php

namespace Insly\QmtApiClient\Api\Transformers\Master;

use Insly\QmtApiClient\Api\Transformers\AbstractTransformer;

class GroupTransformer extends AbstractTransformer
{
    protected $fieldsMap = [
        'id' => 'id',
        'parent_id' => 'parentId',
        'name' => 'name',
        'title' => 'title',
        'domain_tag' => 'domainTag',
    ];
}
