<?php

namespace Insly\QmtApiClient\Api\Models;

use Insly\QmtApiClient\Api\Models\Interfaces\HasGetFields;
use Insly\QmtApiClient\Api\Models\Interfaces\HasSetFields;
use Insly\QmtApiClient\Api\Models\Traits\GetsFields;
use Insly\QmtApiClient\Api\Models\Traits\SetsFields;

class Broker implements HasSetFields, HasGetFields
{
    use SetsFields, GetsFields;

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $tag;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $groupId;

    /**
     * @var array
     */
    public $props = [];
}
