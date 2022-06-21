<?php

namespace Insly\QmtApiClient\Api\Models;

use Insly\QmtApiClient\Api\Models\Interfaces\HasGetFields;
use Insly\QmtApiClient\Api\Models\Interfaces\HasSetFields;
use Insly\QmtApiClient\Api\Models\Traits\GetsFields;
use Insly\QmtApiClient\Api\Models\Traits\SetsFields;

class Group implements HasSetFields, HasGetFields
{
    use SetsFields, GetsFields;

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $parentId;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $domainTag;
}
