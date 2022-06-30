<?php

namespace Insly\QmtApiClient\Api\Transformers\Master;

use Insly\QmtApiClient\Api\Models\User;
use Insly\QmtApiClient\Api\Transformers\ResultsTransformer;

/**
 * @method User[] transform(array $data)
 */
class UsersListTransformer extends ResultsTransformer
{
    public function __construct()
    {
        parent::__construct(new User(), new UserTransformer());
    }
}
