<?php

namespace Apruvd\V3\Models;

/**
 * Class Callbacks
 * @package Apruvd\V3\Models
 */
class Callbacks extends APIModel {

    /**
     * @var string $callback_url
     */
    public $callback_url = null;

    /**
     * @var string $settings_url
     */
    public $settings_url = null;

    /**
     * @var string $callback_api_key_id
     */
    public $callback_api_key_id = null;

    /**
     * @var string $callback_api_key_secret
     */
    public $callback_api_key_secret = null;

    /**
     * @var array $props
     */
    public $props = ['callback_url', 'settings_url', 'callback_api_key_id', 'callback_api_key_secret'];

    /**
     * @var array $required_fields
     */
    protected $required_fields = ['callback_url', 'settings_url'];

    /**
     * @var array $string_fields
     */
    protected $string_fields = ['callback_url', 'settings_url', 'callback_api_key_id', 'callback_api_key_secret'];
}
