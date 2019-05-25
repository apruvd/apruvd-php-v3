<?php

namespace Apruvd\V3\Responses;

use Apruvd\V3\Responses\Nested\NestedHydrator;

/**
 * Class TransactionCallbackResponse
 * @package Apruvd\V3\Responses
 */
class TransactionCallbackResponse extends NestedHydrator {

    /**
     * @var integer $transaction_id
     */
    public $transaction_id = null;
    /**
     * @var string $order_num
     */
    public $order_num = null;
    /**
     * @var string $status
     */
    public $status = null;
    /**
     * @var string $notes
     */
    public $notes = null;
}