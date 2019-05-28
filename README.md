# apruvd_v3_php

Lightweight PHP SDK for integrating with the Apruvd API V3 (soon to be legacied).

API documentation found here.
https://app.apruvd.com/documentation/

## Services
### APIService
The main primary service containing 1:1 method mapping on available API endpoints.
```
$service = new APIService('secret_id', 'secret_key', 'optional_refresh_token', 'optional_access_token');
$service->{endpoint_method}();
```

### APIAsyncResponseService
The optional service to grab/transform $_POST JSON data into the appropriate response model. The ```$s```
```
$callback = function($post_response){ ... };
\Apruvd\V3\APIAsyncResponseService::handle($callback);
// or if you don't require a callback function, you can get the response directly in your route/controller
$response = \Apruvd\V3\APIAsyncResponseService::handle();
// or if your framework supports JSON request parsing, you can create a response model from that object/array.
$response = \Apruvd\V3\APIAsyncResponseService::transactionResponse($json_object)
```

## Authentication
There are 2 viable authentication patterns for the v3 API. secret id/key and refresh/access tokens.
#### Secret ID/Key
This key pair is generated in the application settings page and is used as a basic authentication scheme. All calls can be made using this key key set. The refresh/access token authentication method is completely optional
#### Refresh/Access Tokens
Using your secret id/key you can request a refresh token using the following method:
```
$token = $service->authenticateWithOAuth();
```
A token set will be returned and automatically binded to the service class. When new tokens are generated an optional anonymous callback function can be passed to the API service as an event handler.
```
$service->onAccessTokenUpdate(function($token){ ... });
```
If a refresh token has been binded via service constructor, subsequent API calls will automatically request a new access token on missing or failed attempts. This process can additionally be handled via direct call.
```
$token = $service->authenticateWithOAuthRefresh();
```
It's recommended that the onAccessTokenUpdate method be used with your prefered storage routine and that the refresh and access tokens can be recalled and passed via service constructor.

## Models
#### Transaction and Cart Contents
For model details please refer to the codebase and the API docs
```
$transaction = new Transaction([
    'mode' => 'Live',
    'total' => 123.45,
    'order_num' => '12345',
]);
$transaction->cart_contents[] = new CartContents(['item' => 'Foo', 'quantity' => 25, 'is_high_risk' => false]);
$response = $service->submitTransaction($transaction);
```

## Responses
All responses are well formed and documented. The following properties of the APIModel class are available to all responses, with each response binding it's own additional properties.
* ```$response->code``` - integer | HTTP Response Code
* ```$response->detail``` - string | Possible 400/500 error response message
* ```$response->success``` - boolean | Was HTTP within 200 range
* ```$response->validation_errors``` - object | Possible 400 validation error response messages. Nested Object.
* ```$response->response``` - Httpful\Response | Fully formed response from Httpful service. Useful for debugging.


## API Methods and Endpoints
##### submitTransaction(Transaction $transaction) : SubmitTransactionResponse
Submits to ```api/transactions/submit/``` as POST
##### checkTransaction(String $transaction_id) : CheckTransactionResponse
Submits to ```api/transactions/status/?transaction_id={$transaction_id}``` as GET
##### updateTransaction(String $transaction_id, Transaction $transaction) : UpdateTransactionResponse
Submits to ```api/transactions/{$transaction_id}/update/``` as POST
##### cancelTransaction(String $transaction_id) : CancelTransactionResponse
Submits to ```api/transactions/{$transaction_id}/cancel/``` as POST
##### elevateTransaction($transaction_id, $is_order_number = false) : ElevateTransactionResponse
Submits to ```api/transactions/elevate/``` as POST. Transaction ID or Order Num can be used depending on boolean flag.
##### authenticateWithOAuth() : OAuthResponse
Submits to ```o/token/?grant_type=password``` as GET.
##### authenticateWithOAuthRefresh() : OAuthResponse
Submits to ```o/token/?grant_type=refresh``` as GET.

## Helper Methods
##### onAccessTokenUpdate(Closure $callback)
Registers the single event handler for Token Update events. This maps to a single property, only one callback per event cycle.
##### setToken(String $token)
##### getToken() : String
##### setRefreshToken(String $token)
##### getRefreshToken() : String
