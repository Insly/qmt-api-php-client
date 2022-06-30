<?php

namespace Insly\QmtApiClient\Api\Transformers\Master;

use Insly\QmtApiClient\Api\Models\Role;
use Insly\QmtApiClient\Api\Transformers\ResultsTransformer;

class RolesListTransformer extends ResultsTransformer
{
    public function __construct()
    {
        parent::__construct(new Role(), new RoleTransformer());
    }

    /**
     * @param array $data
     * @return array
     */
    protected function getResults(array $data): array
    {
        return $data;
    }
}
