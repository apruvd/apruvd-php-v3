<?php

namespace Apruvd\V3\Responses;

/**
 * Class APIResponse
 * @package Apruvd\V3\Responses
 */
class APIResponse{
    /**
     * APIResponse constructor.
     * @param null|array|object $props
     */
    public function __construct($props = null)
    {
        if(!empty($props) && (is_array($props) || is_object($props))){
            foreach($props as $prop => $value){
                $this->{$prop} = $value;
            }
        }
    }
}