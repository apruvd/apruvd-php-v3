<?php

namespace Apruvd\V3\Responses\Nested;

/**
 * Class NestedHydrator
 * @package Apruvd\V3\Responses\Nested
 */
class NestedHydrator{

    /**
     * NestedHydrator constructor.
     * @param array|Object $props
     */
    public function __construct($props = [])
    {
        if(!empty($props) && (is_array($props) || is_object($props))){
            foreach($props as $prop => $value){
                $this->{$prop} = $value;
            }
        }
    }

}