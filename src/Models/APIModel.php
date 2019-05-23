<?php

namespace Apruvd\V3\Models;

use JsonSerializable;

/**
 * Class APIModel - used as base for hydrators and basic validation on API models
 * @package Apruvd\V3\Models
 */
class APIModel implements JsonSerializable{

    /**
     * APIModel constructor.
     * @param array|object $props
     */
    public function __construct($props = [])
    {
        if(!empty($props) && (is_array($props) || is_object($props))){
            foreach($props as $prop => $value){
                if(in_array($prop, $this->props)){
                    $this->{$prop} = $value;
                }
            }
        }
    }

    /**
     * @var array $validation_errors A list of field names throwing basic validation errors.
     */
    protected $validation_errors = [];

    /**
     * @var array $props A list of field names exposed for JSON output.
     */
    protected $props = [
    ];

    /**
     * @var array $required_fields A list of required field names to be checked for null on validate.
     */
    protected $required_fields = [
    ];

    /**
     *
     * @var array $enum_fields A list of ENUM field names with nested array of acceptable values.
     */
    protected $enum_fields = [
        //'key' => ['val1', 'val2'],
    ];

    /**
     * @var array $integer_fields A list of required field names to be checked for integer type on validate.
     */
    protected $integer_fields = [];

    /**
     * @var array $number_fields A list of required field names to be checked for number/float/decimal/int type on validate.
     */
    protected $number_fields = [];

    /**
     * @var array $boolean_fields A list of required field names to be checked for boolean type on validate.
     */
    protected $boolean_fields = [];

    /**
     * @var array $string_fields A list of required field names to be checked for string type on validate.
     */
    protected $string_fields = [];

    /**
     * An optional field validation test method based on the various type checks of the associated field name arrays.
     * @return bool
     */
    public function validate(){
        // It's here, feel free to expand or ignore.
        $this->validation_errors = [];
        $success = true;

        foreach($this->required_fields as $field){
            if($this->{$field} === null){
                $this->validation_errors[] = "Field {$field} is required.";
                $success = false;
            }
        }

        foreach($this->boolean_fields as $field){
            if($this->{$field} !== null && !is_bool($this->{$field})){
                $this->validation_errors[] = "Field {$field} is not a boolean.";
                $success = false;
            }
        }

        foreach($this->enum_fields as $field => $values){
            if($this->{$field} !== null && !in_array($this->{$field}, $values)){
                $val = $this->{$field};
                $this->validation_errors[] = "Enum out of range '{$val}' on field {$field}.";
                $success = false;
            }
        }

        foreach($this->number_fields as $field){
            if($this->{$field} !== null && !is_integer($this->{$field}) && !is_double($this->{$field}) && !is_float($this->{$field})){
                $this->validation_errors[] = "Field {$field} is not a number.";
                $success = false;
            }
        }

        foreach($this->integer_fields as $field){
            if($this->{$field} !== null && !is_integer($this->{$field})){
                $this->validation_errors[] = "Field {$field} is not an integer.";
                $success = false;
            }
        }

        foreach($this->string_fields as $field){
            if($this->{$field} !== null && !is_string($this->{$field})){
                $this->validation_errors[] = "Field {$field} is not a string.";
                $success = false;
            }
        }

        return $success;
    }

    /**
     * Retrieval method for validation errors.
     * @return array String messages of field and issue
     */
    public function validationErrors(){
        return $this->validation_errors;
    }

    /**
     * To trim data for compact API posting this method strips out null default values and drops non-json enabled fields.
     * @return array
     */
    public function reduceForAPI(){
        $output = [];
        foreach($this->props as $field){
            if($this->{$field} !== null){
                $output[$field] = $this->{$field};
            }
        }
        return $output;
    }

    /**
     * Trims and returns JSON exposed field values.
     * @return array
     */
    public function jsonSerialize()
    {
        return  $this->reduceForAPI();
    }
}