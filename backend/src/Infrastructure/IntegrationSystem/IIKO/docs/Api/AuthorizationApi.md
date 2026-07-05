# IIKO\AuthorizationApi

Authorization API.

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**api1AccessTokenPost()**](AuthorizationApi.md#api1AccessTokenPost) | **POST** /api/1/access_token | Retrieve session key for API user. |
| [**apiV2AccessTokenPost()**](AuthorizationApi.md#apiV2AccessTokenPost) | **POST** /api/v2/access_token | Retrieve session key for API access (v2) |


## `api1AccessTokenPost()`

```php
api1AccessTokenPost($timeout, $iiko_transport_public_api_contracts_auth_get_access_token_request): \IIKO\Model\IikoTransportPublicApiContractsAuthGetAccessTokenResponse
```

Retrieve session key for API user.

> Deprecated: use `/api/v2/access_token` instead.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\AuthorizationApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_auth_get_access_token_request = new \IIKO\Model\IikoTransportPublicApiContractsAuthGetAccessTokenRequest(); // \IIKO\Model\IikoTransportPublicApiContractsAuthGetAccessTokenRequest

try {
    $result = $apiInstance->api1AccessTokenPost($timeout, $iiko_transport_public_api_contracts_auth_get_access_token_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AuthorizationApi->api1AccessTokenPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_auth_get_access_token_request** | [**\IIKO\Model\IikoTransportPublicApiContractsAuthGetAccessTokenRequest**](../Model/IikoTransportPublicApiContractsAuthGetAccessTokenRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsAuthGetAccessTokenResponse**](../Model/IikoTransportPublicApiContractsAuthGetAccessTokenResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiV2AccessTokenPost()`

```php
apiV2AccessTokenPost($timeout, $iiko_transport_public_api_contracts_auth_get_access_token_v2_request): \IIKO\Model\IikoTransportPublicApiContractsAuthGetAccessTokenResponse
```

Retrieve session key for API access (v2)

Authenticates an application and returns a short-lived JWT token for subsequent API calls.                **Getting started:**  1. Register at https://public-api.iikoweb.ru/portal and fill in your company details.  2. Create an application — you will receive an `appId` and a one-time `clientSecret`.  3. In iikoWeb → \"Integrations\" → \"API Keys\", generate an API key.  4. Call this method with all three credentials.  5. Use the returned `token` as a Bearer token in the `Authorization` header of all     subsequent API requests: `Authorization: Bearer {token}`.  **Token lifetime:** the token is valid for **1 hour**. The exact expiration is encoded  in the JWT `exp` claim. Request a new token before the current one expires — there is  no refresh token flow.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\AuthorizationApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_auth_get_access_token_v2_request = new \IIKO\Model\IikoTransportPublicApiContractsAuthGetAccessTokenV2Request(); // \IIKO\Model\IikoTransportPublicApiContractsAuthGetAccessTokenV2Request

try {
    $result = $apiInstance->apiV2AccessTokenPost($timeout, $iiko_transport_public_api_contracts_auth_get_access_token_v2_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AuthorizationApi->apiV2AccessTokenPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_auth_get_access_token_v2_request** | [**\IIKO\Model\IikoTransportPublicApiContractsAuthGetAccessTokenV2Request**](../Model/IikoTransportPublicApiContractsAuthGetAccessTokenV2Request.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsAuthGetAccessTokenResponse**](../Model/IikoTransportPublicApiContractsAuthGetAccessTokenResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
