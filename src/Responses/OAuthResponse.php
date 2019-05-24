<?php

namespace Apruvd\V3\Responses;

/**
 * Class OAuthResponse
 * @package Apruvd\V3
 */
class OAuthResponse extends APIResponse {
    /**
     * @var OAuthTokenResponse $access
     */
    public $access = null; // OAuthTokenResponse;
    /**
     * @var OAuthTokenResponse $refresh
     */
    public $refresh = null; // OAuthTokenResponse;

    public function __construct($props = null)
    {
        parent::__construct($props);

        if(!empty($props->access)){
            $this->access = new OAuthTokenResponse($props->access);
        }

        if(!empty($props->refresh)){
            $this->refresh = new OAuthTokenResponse($props->refresh);
        }
    }
}