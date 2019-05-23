<?php

namespace Apruvd\V3\Responses;

/**
 * Class CheckTransactionResponse
 * @package Apruvd\V3\Responses
 */
class CheckTransactionResponse extends APIResponse {

    /**
     * @var int $transaction_id
     */
    public $transaction_id = null;
    /**
     * @var string $status
     */
    public $status = null;
    /**
     * @var boolean $canceled
     */
    public $canceled = null;
    /**
     * @var string $order_num
     */
    public $order_num = null;
    /**
     * @var string $notes
     */
    public $notes = null;

}