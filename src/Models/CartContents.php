<?php

namespace Apruvd\V3\Models;

use JsonSerializable;

/**
 * Class CartContents
 * @package Apruvd\V3\Models
 */
class CartContents extends APIModel {
    /**
     * @var string $item
     */
    public $item = null; // string
    /**
     * @var int $quantity
     */
    public $quantity = null; // integer
    /**
     * @var boolean $is_high_risk
     */
    public $is_high_risk = null; // boolean
    /**
     * @var object|null $extra Generic object of any form
     */
    public $extra = null; // generic Object

    /**
     * @var array $props
     */
    public $props = [
        'item', 'quantity', 'is_high_risk', 'extra'
    ];

    /**
     * @var array $required_fields
     */
    protected $required_fields = [
        'item', 'quantity', 'is_high_risk'
    ];

    /**
     * @var array $boolean_fields
     */
    protected $boolean_fields = ['is_high_risk'];

}