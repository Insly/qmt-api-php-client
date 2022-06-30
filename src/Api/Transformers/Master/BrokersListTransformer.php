<?php

namespace Insly\QmtApiClient\Api\Transformers\Master;

use Insly\QmtApiClient\Api\Models\Broker;
use Insly\QmtApiClient\Api\Transformers\ResultsTransformer;

/**
 * @method Broker[] transform(array $data)
 */
class BrokersListTransformer extends ResultsTransformer
{
    public function __construct()
    {
        parent::__construct(new Broker(), new BrokerTransformer());
    }
}
