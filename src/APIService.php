<?php

namespace Apruvd\V3;

use Apruvd\APIInterface;
use Apruvd\V3\Models\Transaction;
use Apruvd\V3\Responses\CancelTransactionResponse;
use Apruvd\V3\Responses\CheckTransactionResponse;
use Apruvd\V3\Responses\ElevateTransactionResponse;
use Apruvd\V3\Responses\SubmitTransactionResponse;
use Apruvd\V3\Responses\UpdateTransactionResponse;
use Httpful\Mime;

/**
 * Class APIService
 * @package Apruvd\V3
 */
class APIService{

    private $host = 'https://app.apruvd.com/';
    private $id = '';
    private $secret = '';

    private $last_response = null;

    public function __construct($id, $secret)
    {
        $this->id = $id;
        $this->secret = $secret;
    }

    public function lastResponse(){
        return $this->last_response;
    }

    public function submitTransaction(Transaction $transaction){
        $uri = 'api/transactions/submit/';
        $response = \Httpful\Request::post($this->host.$uri)
            ->body(json_encode($transaction))
            ->authenticateWith($this->id, $this->secret)->sendsAndExpects(Mime::JSON)->send();

        $this->last_response = $response;
        if($response->code >=200 && $response->code < 300){
            return new SubmitTransactionResponse($response->body);
        }
        return null;
    }

    public function checkTransaction($transaction_id){
        $uri = "api/transactions/status/?transaction_id={$transaction_id}";
        $response = \Httpful\Request::get($this->host.$uri)
            ->authenticateWith($this->id, $this->secret)->sendsAndExpects(Mime::JSON)->send();

        $this->last_response = $response;
        if($response->code >=200 && $response->code < 300){
            return new CheckTransactionResponse($response->body);
        }
        return null;
    }

    public function updateTransaction($transaction_id, $update_fields){
        $transaction = new Transaction($update_fields);
        $uri = "api/transactions/{$transaction_id}/update/";
        $response = \Httpful\Request::post($this->host.$uri)
            ->body(json_encode($transaction))
            ->authenticateWith($this->id, $this->secret)->sendsAndExpects(Mime::JSON)->send();

        $this->last_response = $response;
        if($response->code >=200 && $response->code < 300){
            return new UpdateTransactionResponse($response->body);
        }
        return null;
    }

    public function cancelTransaction($transaction_id){
        $uri = "api/transactions/{$transaction_id}/cancel/";
        $response = \Httpful\Request::post($this->host.$uri)
            ->body(json_encode(null))
            ->authenticateWith($this->id, $this->secret)->sendsAndExpects(Mime::JSON)->send();

        $this->last_response = $response;
        if($response->code >=200 && $response->code < 300){
            return new CancelTransactionResponse($response->body);
        }
        return null;
    }

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
            ->authenticateWith($this->id, $this->secret)->sendsAndExpects(Mime::JSON)->send();
        //var_dump($response); die;

        $this->last_response = $response;
        if($response->code >=200 && $response->code < 300){
            return new ElevateTransactionResponse($response->body);
        }
        return null;
    }

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

    public function authenticateWithOAuthRefresh($token){
        $uri = 'o/token/?grant_type=refresh';
        $response = \Httpful\Request::get($this->host.$uri)
            ->addHeader('Authorization', $token)->sendsAndExpects(Mime::JSON)->send();

        $this->last_response = $response;
        if($response->code >=200 && $response->code < 300){
            return new OAuthTokenResponse($response->body);
        }
        return null;
    }
}