# IIKO\WebhooksApi

Webhook notifications. Webhook handlers can be registered by calling the &#x60;POST api/1/webhooks/update_settings&#x60; method or in the &#39;iikoTransport API&#39; iikoWeb application.

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**api1WebhooksSettingsPost()**](WebhooksApi.md#api1WebhooksSettingsPost) | **POST** /api/1/webhooks/settings | Get webhooks settings for specified organization and authorized API login. |
| [**api1WebhooksUpdateSettingsPost()**](WebhooksApi.md#api1WebhooksUpdateSettingsPost) | **POST** /api/1/webhooks/update_settings | Update webhooks settings for specified organization and authorized API login. |


## `api1WebhooksSettingsPost()`

```php
api1WebhooksSettingsPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_get_categories_request): \IIKO\Model\IikoTransportPublicApiContractsWebHooksGetWebHookSettingsResponse
```

Get webhooks settings for specified organization and authorized API login.

> Restriction group: `Organizations: settings`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_customer_get_categories_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerGetCategoriesRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerGetCategoriesRequest

try {
    $result = $apiInstance->api1WebhooksSettingsPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_get_categories_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->api1WebhooksSettingsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_customer_get_categories_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerGetCategoriesRequest**](../Model/IikoNetServiceContractsApiIikoTransportCustomerGetCategoriesRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsWebHooksGetWebHookSettingsResponse**](../Model/IikoTransportPublicApiContractsWebHooksGetWebHookSettingsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1WebhooksUpdateSettingsPost()`

```php
api1WebhooksUpdateSettingsPost($authorization, $timeout, $iiko_transport_public_api_contracts_web_hooks_update_web_hook_settings_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Update webhooks settings for specified organization and authorized API login.

> Restriction group: `WebHooks: settings`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\WebhooksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_web_hooks_update_web_hook_settings_request = new \IIKO\Model\IikoTransportPublicApiContractsWebHooksUpdateWebHookSettingsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsWebHooksUpdateWebHookSettingsRequest

try {
    $result = $apiInstance->api1WebhooksUpdateSettingsPost($authorization, $timeout, $iiko_transport_public_api_contracts_web_hooks_update_web_hook_settings_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling WebhooksApi->api1WebhooksUpdateSettingsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_web_hooks_update_web_hook_settings_request** | [**\IIKO\Model\IikoTransportPublicApiContractsWebHooksUpdateWebHookSettingsRequest**](../Model/IikoTransportPublicApiContractsWebHooksUpdateWebHookSettingsRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse**](../Model/IikoTransportPublicApiContractsCommonCorrelationIdResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
