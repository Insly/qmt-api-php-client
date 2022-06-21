<?php

namespace Insly\QmtApiClient\Api\Models;

use Insly\QmtApiClient\Api\Models\Interfaces\HasSetFields;
use Insly\QmtApiClient\Api\Models\Traits\GetsFields;
use Insly\QmtApiClient\Api\Models\Traits\SetsFields;

class User implements HasSetFields
{
    use SetsFields, GetsFields;

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $roleId;

    /**
     * @var string
     */
    public $brokerId;

    /**
     * @var array
     */
    public $props = [];
}
