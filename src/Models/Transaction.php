<?php

namespace Apruvd\V3\Models;

/**
 * Class Transaction
 * @package Apruvd\V3\Models
 */
class Transaction extends APIModel {
    /**
     * @var string $mode ENUM outlined in enum_fields property
     */
    public $mode = null;
    /**
     * @var string $type ENUM outlined in enum_fields property
     */
    public $type = null;
    /**
     * @var float|double|int $total
     */
    public $total = null;
    /**
     * @var string $currency ENUM outlined in enum_fields property
     */
    public $currency = null;
    /**
     * @var string $order_num
     */
    public $order_num = null;
    /**
     * @var string $ip
     */
    public $ip = null;
    /**
     * @var string $email Valid Email
     */
    public $email = null;
    /**
     * @var string $billing_phone
     */
    public $billing_phone = null;
    /**
     * @var string $cc_name
     */
    public $cc_name = null;
    /**
     * @var string $cc_name_2
     */
    public $cc_name_2 = null;
    /**
     * @var int $first_six
     */
    public $first_six = null;
    /**
     * @var int $last_four
     */
    public $last_four = null;
    /**
     * @var string $avs ENUM outlined in enum_fields property
     */
    public $avs = null;
    /**
     * @var string $cvv ENUM outlined in enum_fields property
     */
    public $cvv = null;
    /**
     * @var int $auth_attempts
     */
    public $auth_attempts = null;
    /**
     * @var string $billing_first_name
     */
    public $billing_first_name = null;
    /**
     * @var string $billing_last_name
     */
    public $billing_last_name = null;
    /**
     * @var string $billing_company
     */
    public $billing_company = null;
    /**
     * @var string $billing_address_1
     */
    public $billing_address_1 = null;
    /**
     * @var string $billing_address_2
     */
    public $billing_address_2 = null;
    /**
     * @var string $billing_city
     */
    public $billing_city = null;
    /**
     * @var string $billing_postal
     */
    public $billing_postal = null;
    /**
     * @var string $billing_state
     */
    public $billing_state = null;
    /**
     * @var string $billing_region
     */
    public $billing_region = null;
    /**
     * @var string $billing_country
     */
    public $billing_country = null;
    /**
     * @var string $shipping_email
     */
    public $shipping_email = null;
    /**
     * @var string $egc_recipient
     */
    public $egc_recipient = null;
    /**
     * @var string $shipping_phone
     */
    public $shipping_phone = null;
    /**
     * @var string $shipping_first_name
     */
    public $shipping_first_name = null;
    /**
     * @var string $shipping_last_name
     */
    public $shipping_last_name = null;
    /**
     * @var string $shipping_company
     */
    public $shipping_company = null;
    /**
     * @var string $shipping_address_1
     */
    public $shipping_address_1 = null;
    /**
     * @var string $shipping_address_2
     */
    public $shipping_address_2 = null;
    /**
     * @var string $shipping_city
     */
    public $shipping_city = null;
    /**
     * @var string $shipping_postal
     */
    public $shipping_postal = null;
    /**
     * @var string $shipping_state
     */
    public $shipping_state = null;
    /**
     * @var string $shipping_region
     */
    public $shipping_region = null;
    /**
     * @var string $shipping_country
     */
    public $shipping_country = null;
    /**
     * @var string $shipping_method
     */
    public $shipping_method = null;
    /**
     * @var CartContents|array|object $cart_contents
     */
    public $cart_contents = null;
    /**
     * @var string $rep_email
     */
    public $rep_email = null;
    /**
     * @var string $additional_1
     */
    public $additional_1 = null;
    /**
     * @var string $additional_2
     */
    public $additional_2 = null;
    /**
     * @var string $additional_3
     */
    public $additional_3 = null;

    /**
     * @var array $validation_errors String[]
     */
    protected $validation_errors = [];

    /**
     * @var array $props
     */
    public $props = [
        'mode','type','total','currency','order_num','ip','email','billing_phone','cc_name','cc_name_2','first_six',
        'last_four','avs','cvv','auth_attempts','billing_first_name','billing_last_name','billing_company',
        'billing_address_1','billing_address_2','billing_city','billing_postal','billing_state','billing_region',
        'billing_country','shipping_email','egc_recipient','shipping_phone','shipping_first_name','shipping_last_name',
        'shipping_company','shipping_address_1','shipping_address_2','shipping_city','shipping_postal','shipping_state',
        'shipping_region','shipping_country','shipping_method','cart_contents','rep_email','additional_1','additional_2',
        'additional_3'
    ];

    /**
     * @var array $required_fields
     */
    protected $required_fields = [
        'total', 'ip', 'email', 'billing_phone', 'billing_first_name', 'billing_last_name', 'billing_address_1',
        'billing_postal', 'billing_country', 'shipping_first_name', 'shipping_last_name', 'shipping_address_1',
        'shipping_postal', 'shipping_country'
    ];

    /**
     * @var array $enum_fields
     */
    protected $enum_fields = [
        'mode' => ['Live', 'Test'],
        'type' => ['Ecommerce','Mcommerce','Phone/MOTO','Other'],
        'currency' => [
            'AED','AFN','ALL','AMD','ANG','AOA','ARS','AUD','AWG','AZN','BAM','BBD','BDT','BGN','BHD','BIF','BMD','BND',
            'BOB','BOV','BRL','BSD','BTN','BWP','BYN','BZD','CAD','CDF','CHE','CHF','CHW','CLF','CLP','CNY','COP','COU',
            'CRC','CUC','CUP','CVE','CZK','DJF','DKK','DOP','DZD','EGP','ERN','ETB','EUR','FJD','FKP','GBP','GEL','GHS',
            'GIP','GMD','GNF','GTQ','GYD','HKD','HNL','HRK','HTG','HUF','IDR','ILS','INR','IQD','IRR','ISK','JMD','JOD',
            'JPY','KES','KGS','KHR','KMF','KPW','KRW','KWD','KYD','KZT','LAK','LBP','LKR','LRD','LSL','LYD','MAD','MDL',
            'MGA','MKD','MMK','MNT','MOP','MRU','MUR','MVR','MWK','MXN','MXV','MYR','MZN','NAD','NGN','NIO','NOK','NPR',
            'NZD','OMR','PAB','PEN','PGK','PHP','PKR','PLN','PYG','QAR','RON','RSD','RUB','RWF','SAR','SBD','SCR','SDG',
            'SEK','SGD','SHP','SLL','SOS','SRD','SSP','STN','SVC','SYP','SZL','THB','TJS','TMT','TND','TOP','TRY','TTD',
            'TWD','TZS','UAH','UGX','USD','USN','UYI','UYU','UYW','UZS','VES','VND','VUV','WST','XAF','XAG','XAU','XBA',
            'XBB','XBC','XBD','XCD','XDR','XOF','XPD','XPF','XPT','XSU','XTS','XUA','XXX','YER','ZAR','ZMW','ZWL'
        ],
        'avs' => [
            'X','Y','A','W','Z','N','U','R','E','S','D','M','B','P','C','I','G','I1','I2','I3','I4','I5','I6','I7','I8',
            'IG','IU','ID','IE','IS','IA','IB','IC','IP','N1','N2','A1','A3','A4','A7','B3','B4','B7','B8','V',''
        ],
        'cvv' => ['M','N','P','S','U']
    ];

    /**
     * @var array $integer_fields
     */
    protected $integer_fields = ['first_six', 'last_four', 'auth_attempts'];

    /**
     * @var array $number_fields
     */
    protected $number_fields = ['total'];

    /**
     * @var array $string_fields
     */
    protected $string_fields = [
        'order_num','ip','email','billing_phone','cc_name','cc_name_2','billing_first_name','billing_last_name','billing_company',
        'billing_address_1','billing_address_2','billing_city','billing_postal','billing_state','billing_region',
        'billing_country','shipping_email','egc_recipient','shipping_phone','shipping_first_name','shipping_last_name',
        'shipping_company','shipping_address_1','shipping_address_2','shipping_city','shipping_postal','shipping_state',
        'shipping_region','shipping_country','shipping_method','rep_email','additional_1','additional_2',
        'additional_3'
    ];
}