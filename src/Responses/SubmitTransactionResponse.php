<?php

namespace Apruvd\V3\Responses;

/**
 * Class SubmitTransactionResponse
 * @package Apruvd\V3\Responses
 */
class SubmitTransactionResponse extends APIResponse {

    /**
     * @var integer $transaction_id
     */
    public $transaction_id = null;
    /**
     * @var string $status
     */
    public $status = null;
    /**
     * @var string $risk_grade
     */
    public $risk_grade = null;
    /**
     * @var string $order_num
     */
    public $order_num = null;
    /**
     * @var string $notes
     */
    public $notes = null;

}