<?php

namespace Apruvd\V3;

use Apruvd\V3\Responses\APIResponse;

/**
 * Class OAuthTokenResponse
 * @package Apruvd\V3
 */
class OAuthTokenResponse extends APIResponse {
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