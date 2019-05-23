<?php

namespace Apruvd\V3;

use Apruvd\V3\Responses\APIResponse;

/**
 * Class OAuthResponse
 * @package Apruvd\V3
 */
class OAuthResponse extends APIResponse {
    /**
     * @var string $access
     */
    public $access = null; // OAuthToken;
    /**
     * @var string $refresh
     */
    public $refresh = null; // OAuthToken;
}