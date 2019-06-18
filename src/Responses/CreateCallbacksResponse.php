<?php

namespace Apruvd\V3\Responses;

/**
 * Class CreateCallbacksResponse
 * @package Apruvd\V3\Responses
 */
class CreateCallbacksResponse extends APIResponse {

    /**
     * @var string $id
     */
    public $id = null;

    /**
     * @var string $service_plan
     */
    public $service_plan = null;

    /**
     * @var array $basic_rules
     */
    public $basic_rules = null;

    /**
     * @var boolean $data_connection
     */
    public $data_connection = null;

    /**
     * @var boolean $training_data
     */
    public $training_data = null;

    /**
     * @var boolean $require_notes_on_approves
     */
    public $require_notes_on_approves = null;

    /**
     * @var boolean $require_notes_on_declines
     */
    public $require_notes_on_declines = null;

    /**
     * @var boolean $strictly_protect_pii
     */
    public $strictly_protect_pii = null;

    /**
     * @var boolean $enforce_unique_order_id
     */
    public $enforce_unique_order_id = null;

    /**
     * @var string $integration_version
     */
    public $integration_version = null;

    /**
     * @var string $callback_url
     */
    public $callback_url = null;

    /**
     * @var string $settings_url
     */
    public $settings_url = null;

    /**
     * @var string $callbacks_api_key_id
     */
    public $callbacks_api_key_id = null;

    /**
     * @var string $callbacks_api_key_secret
     */
    public $callbacks_api_key_secret = null;
}
