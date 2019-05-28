<?php

namespace Apruvd\V3;

use Apruvd\V3\Models\Transaction;
use Apruvd\V3\Responses\APIResponse;
use Apruvd\V3\Responses\CancelTransactionResponse;
use Apruvd\V3\Responses\CheckTransactionResponse;
use Apruvd\V3\Responses\ElevateTransactionResponse;
use Apruvd\V3\Responses\OAuthResponse;
use Apruvd\V3\Responses\SubmitTransactionResponse;
use Apruvd\V3\Responses\UpdateTransactionResponse;
use Closure;
use Httpful\Mime;
use Httpful\Request;

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
     * @var Closure $token_update_callback
     */
    private $token_update_callback = null;

    private $token_retry_attempted = false;

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
     * @return string
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
     * @return string
     */
    public function getRefreshToken(){
        return $this->refresh_token;
    }

    /**
     * Create Transaction.
     * @param Transaction $transaction
     * @return SubmitTransactionResponse
     */
    public function submitTransaction(Transaction $transaction){
        $uri = 'api/transactions/submit/';
        $response = \Httpful\Request::post($this->host.$uri)
            ->body(json_encode($transaction));
        $response = $this->bindAuthorization($response);
        $response = $response->sends(Mime::JSON)->send();
        $apiResponse = new SubmitTransactionResponse($response);
        if($this->retryNewToken($apiResponse)){
            $apiResponse = $this->submitTransaction($transaction);
        }
        return $apiResponse;
    }

    /**
     * Read single Transaction by ID.
     * @param string $transaction_id
     * @return CheckTransactionResponse
     */
    public function checkTransaction($transaction_id){
        $uri = "api/transactions/status/?transaction_id={$transaction_id}";
        $response = \Httpful\Request::get($this->host.$uri);
        $response = $this->bindAuthorization($response);
        $response = $response->sends(Mime::JSON)->send();
        $apiResponse = new CheckTransactionResponse($response);
        if($this->retryNewToken($apiResponse)){
            $apiResponse = $this->checkTransaction($transaction_id);
        }
        return $apiResponse;
    }

    /**
     * Update single Transaction by ID.
     * @param string $transaction_id
     * @param Transaction $transaction
     * @return UpdateTransactionResponse
     */
    public function updateTransaction($transaction_id, Transaction $transaction){
        $uri = "api/transactions/{$transaction_id}/update/";
        $response = \Httpful\Request::post($this->host.$uri)
            ->body(json_encode($transaction));
        $response = $this->bindAuthorization($response);
        $response = $response->sends(Mime::JSON)->send();
        $apiResponse = new UpdateTransactionResponse($response);
        if($this->retryNewToken($apiResponse)){
            $apiResponse = $this->updateTransaction($transaction_id, $transaction);
        }
        return $apiResponse;
    }

    /**
     * Cancel single Transaction by ID.
     * @param string $transaction_id
     * @return CancelTransactionResponse
     */
    public function cancelTransaction($transaction_id){
        $uri = "api/transactions/{$transaction_id}/cancel/";
        $response = \Httpful\Request::post($this->host.$uri)
            ->body(json_encode(null));
        $response = $this->bindAuthorization($response);
        $response = $response->sends(Mime::JSON)->send();
        $apiResponse = new CancelTransactionResponse($response);
        if($this->retryNewToken($apiResponse)){
            $apiResponse = $this->cancelTransaction($transaction_id);
        }
        return $apiResponse;
    }

    /**
     * Elevate Transaction by ID.
     * @param string $transaction_id
     * @param bool $is_order_number
     * @return ElevateTransactionResponse
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
            ->body(json_encode($payload));
        $response = $this->bindAuthorization($response);
        $response = $response->sends(Mime::JSON)->send();
        $apiResponse = new ElevateTransactionResponse($response);
        if($this->retryNewToken($apiResponse)){
            $apiResponse = $this->elevateTransaction($transaction_id, $is_order_number);
        }
        return $apiResponse;
    }

    /**
     * Create refresh and access tokens from auth credentials.
     * @return OAuthResponse
     */
    public function authenticateWithOAuth(){
        $uri = 'o/token/?grant_type=password';
        $response = \Httpful\Request::get($this->host.$uri)
            ->authenticateWith($this->id, $this->secret)->sends(Mime::JSON)->send();
        $token = new OAuthResponse($response);
        if($token->success){
            $this->refresh_token = $token->refresh->token;
            $this->token = $token->access->token;
        }
        return $token;
    }

    /**
     * Create access token from refresh token.
     * @return OAuthResponse
     */
    public function authenticateWithOAuthRefresh(){
        $uri = 'o/token/?grant_type=refresh';
        $response = \Httpful\Request::get($this->host.$uri)
            ->addHeader('Authorization', 'Bearer '.$this->refresh_token)->sends(Mime::JSON)->send();
        $token = new OAuthResponse($response);
        if($token->success){
            $this->refresh_token = $token->refresh->token;
            $this->token = $token->access->token;
            if(is_object($this->token_update_callback) && ($this->token_update_callback instanceof Closure)){
                call_user_func_array($this->token_update_callback, [$token]);
            }
        }
        return $token;
    }

    /**
     * Create access token from refresh token.
     * @param Closure $callback
     */
    public function onAccessTokenUpdate(Closure $callback){
        $this->token_update_callback = $callback;
    }

    /**
     * Add Auth headers to Httpful request.
     * @param Request $request
     * @return Request
     */
    protected function bindAuthorization(Request $request){
        if(!empty($this->token)){
            $request->addHeader('Authorization', 'Bearer '.$this->token);
        }
        elseif(!empty($this->refresh_token)){
            $token = $this->authenticateWithOAuthRefresh();
            if($token){
                $this->token = $token->access->token;
                $request->addHeader('Authorization', 'Bearer '.$this->token);
            }
            else{
                $request->addHeader('Authorization', 'Basic '.base64_encode($this->id.':'.$this->secret));
            }
        }
        else{
            $request->addHeader('Authorization', 'Basic '.base64_encode($this->id.':'.$this->secret));
        }
        return $request;
    }

    /**
     * Sniff response for missing/expired Access Token when Refresh Token is known.
     * @param APIResponse $response
     * @return boolean
     */
    protected function retryNewToken(APIResponse $response){
        if($response->code == 400 && $response->error === 'Invalid token' && !empty($this->refresh_token) && !$this->token_retry_attempted ){
            // Will trigger onAccessTokenUpdate() callback on success
            $this->token_retry_attempted = true;
            $token = $this->authenticateWithOAuthRefresh();
            if($token->success){
                return true;
            }
        }
        return false;
    }
}