<?php

namespace Insly\QmtApiClient\Api\Transformers\Master;

use Insly\QmtApiClient\Api\Models\Group;
use Insly\QmtApiClient\Api\Transformers\ResultsTransformer;

/**
 * @method Group[] transform(array $data)
 */
class GroupsListTransformer extends ResultsTransformer
{
    public function __construct()
    {
        parent::__construct(new Group(), new GroupTransformer());
    }
}
