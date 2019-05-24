<?php

namespace Apruvd\V3;

use Apruvd\V3\Models\Transaction;
use Apruvd\V3\Responses\CancelTransactionResponse;
use Apruvd\V3\Responses\CheckTransactionResponse;
use Apruvd\V3\Responses\ElevateTransactionResponse;
use Apruvd\V3\Responses\OAuthResponse;
use Apruvd\V3\Responses\OAuthTokenResponse;
use Apruvd\V3\Responses\SubmitTransactionResponse;
use Apruvd\V3\Responses\UpdateTransactionResponse;
use Httpful\Mime;

/**
 * Class APIService
 * @package Apruvd\V3
 */
class APIService{

    /**
     * @var string $host
     */
    private $host = 'https://app.apruvd.com/';

    /**
     * @var string $id
     */
    private $id = '';

    /**
     * @var string $secret
     */
    private $secret = '';

    /**
     * @var string $refresh_token
     */
    private $refresh_token = '';

    /**
     * @var string $token
     */
    private $token = '';

    /**
     * @var $last_response
     */
    private $last_response = null;

    /**
     * APIService constructor.
     * @param string $id
     * @param string $secret
     * @param string|null $refresh_token
     * @param string|null $token
     */
    public function __construct($id, $secret, $refresh_token = null, $token = null)
    {
        $this->id = $id;
        $this->secret = $secret;
        $this->refresh_token = $refresh_token;
        $this->token = $token;
    }

    /**
     * Token setter.
     * @param string $token
     */
    public function setToken($token){
        if(is_string($token) && !empty($token)){
            $this->token = $token;
        }
    }
    /**
     * Token getter.
     */
    public function getToken(){
        return $this->token;
    }
    /**
     * Refresh Token setter.
     * @param string $token
     */
    public function setRefreshToken($token){
        if(is_string($token) && !empty($token)){
            $this->refresh_token = $token;
        }
    }
    /**
     * Refresh Token getter.
     */
    public function getRefreshToken(){
        return $this->refresh_token;
    }

    /**
     * API failure response getter.
     */
    public function lastResponse(){
        return $this->last_response;
    }

    /**
     * Create Transaction.
     * @param Transaction $transaction
     */
    public function submitTransaction(Transaction $transaction){
        $uri = 'api/transactions/submit/';
        $response = \Httpful\Request::post($this->host.$uri)
            ->body(json_encode($transaction))
            ->addHeader('Authorization', 'Bearer '.$this->token)->sendsAndExpects(Mime::JSON)->send();

        $this->last_response = $response;
        if($response->code >=200 && $response->code < 300){
            return new SubmitTransactionResponse($response->body);
        }
        return null;
    }

    /**
     * Read single Transaction by ID.
     * @param string $transaction_id
     */
    public function checkTransaction($transaction_id){
        $uri = "api/transactions/status/?transaction_id={$transaction_id}";
        $response = \Httpful\Request::get($this->host.$uri)
            ->addHeader('Authorization', 'Bearer '.$this->token)->sendsAndExpects(Mime::JSON)->send();

        $this->last_response = $response;
        if($response->code >=200 && $response->code < 300){
            return new CheckTransactionResponse($response->body);
        }
        return null;
    }

    /**
     * Update single Transaction by ID.
     * @param string $transaction_id
     * @param Transaction $transaction
     */
    public function updateTransaction($transaction_id, $update_fields){
        $transaction = new Transaction($update_fields);
        $uri = "api/transactions/{$transaction_id}/update/";
        $response = \Httpful\Request::post($this->host.$uri)
            ->body(json_encode($transaction))
            ->addHeader('Authorization', 'Bearer '.$this->token)->sendsAndExpects(Mime::JSON)->send();

        $this->last_response = $response;
        if($response->code >=200 && $response->code < 300){
            return new UpdateTransactionResponse($response->body);
        }
        return null;
    }

    /**
     * Cancel single Transaction by ID.
     * @param string $transaction_id
     */
    public function cancelTransaction($transaction_id){
        $uri = "api/transactions/{$transaction_id}/cancel/";
        $response = \Httpful\Request::post($this->host.$uri)
            ->body(json_encode(null))
            ->addHeader('Authorization', 'Bearer '.$this->token)->sendsAndExpects(Mime::JSON)->send();

        $this->last_response = $response;
        if($response->code >=200 && $response->code < 300){
            return new CancelTransactionResponse($response->body);
        }
        return null;
    }

    /**
     * Elevate Transaction by ID.
     * @param string $transaction_id
     * @param bool $is_order_number
     */
    public function elevateTransaction($transaction_id, $is_order_number = false){
        $uri = 'api/transactions/elevate/';
        $payload = [];
        if($is_order_number){
            $payload['order_num'] = $transaction_id;
        }
        else{
            $payload['transaction_id'] = $transaction_id;
        }

        $response = \Httpful\Request::post($this->host.$uri)
            ->body(json_encode($payload))
            ->addHeader('Authorization', 'Bearer '.$this->token)->sendsAndExpects(Mime::JSON)->send();

        $this->last_response = $response;
        if($response->code >=200 && $response->code < 300){
            return new ElevateTransactionResponse($response->body);
        }
        return null;
    }

    /**
     * Create refresh and access tokens from auth credentials.
     */
    public function authenticateWithOAuth(){
        $uri = 'o/token/?grant_type=password';
        $response = \Httpful\Request::get($this->host.$uri)
            ->authenticateWith($this->id, $this->secret)->sendsAndExpects(Mime::JSON)->send();

        $this->last_response = $response;
        if($response->code >=200 && $response->code < 300){
            return new OAuthResponse($response->body);
        }
        return null;
    }

    /**
     * Create access token from refresh token.
     */
    public function authenticateWithOAuthRefresh(){
        $uri = 'o/token/?grant_type=refresh';
        $response = \Httpful\Request::get($this->host.$uri)
            ->addHeader('Authorization', 'Bearer '.$this->refresh_token)->sendsAndExpects(Mime::JSON)->send();

        $this->last_response = $response;
        if($response->code >=200 && $response->code < 300){
            return new OAuthTokenResponse($response->body);
        }
        return null;
    }
}