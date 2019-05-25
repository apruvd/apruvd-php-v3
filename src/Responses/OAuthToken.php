<?php

namespace Apruvd\V3\Responses;

use Apruvd\V3\Responses\Nested\NestedHydrator;

/**
 * Class OAuthTokenResponse
 * @package Apruvd\V3
 */
class OAuthToken extends NestedHydrator {
    /**
     * @var string $type
     */
    public $type = null;
    /**
     * @var integer $expires_in
     */
    public $expires_in = null;
    /**
     * @var string $token
     */
    public $token = null;
}