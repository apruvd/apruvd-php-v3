<?php

namespace Apruvd\V3\Responses;

/**
 * Class UpdateTransactionResponse
 * @package Apruvd\V3\Responses
 */
class UpdateTransactionResponse extends APIResponse {

    /**
     * @var int $transaction_id
     */
    public $transaction_id = null;
    /**
     * @var string $status
     */
    public $status = null;
    /**
     * @var object|array $changelog Format: {"2016-Mar-15 10:28 AM":{"property_key":{"from":"old_value","to":"new_value"}}
     */
    public $changelog = null;
    /**
     * @var string $notes
     */
    public $notes = null;

}