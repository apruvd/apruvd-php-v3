<?php

namespace Apruvd\V3\Responses;

/**
 * Class ElevateTransactionResponse
 * @package Apruvd\V3\Responses
 */
class ElevateTransactionResponse extends APIResponse {

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