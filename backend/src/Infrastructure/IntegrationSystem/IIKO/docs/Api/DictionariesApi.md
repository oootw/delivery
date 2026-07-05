# IIKO\DictionariesApi

Dictionaries API.

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**api1CancelCausesPost()**](DictionariesApi.md#api1CancelCausesPost) | **POST** /api/1/cancel_causes | Delivery cancel causes. |
| [**api1DeliveriesOrderTypesPost()**](DictionariesApi.md#api1DeliveriesOrderTypesPost) | **POST** /api/1/deliveries/order_types | Order types. |
| [**api1DiscountsPost()**](DictionariesApi.md#api1DiscountsPost) | **POST** /api/1/discounts | Discounts / surcharges. |
| [**api1PaymentTypesPost()**](DictionariesApi.md#api1PaymentTypesPost) | **POST** /api/1/payment_types | Payment types. |
| [**api1RemovalTypesPost()**](DictionariesApi.md#api1RemovalTypesPost) | **POST** /api/1/removal_types | Removal types (reasons for deletion). |
| [**api1TipsTypesPost()**](DictionariesApi.md#api1TipsTypesPost) | **POST** /api/1/tips_types | Get tips types for api-login&#x60;s rms group. |


## `api1CancelCausesPost()`

```php
api1CancelCausesPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_regions_request): \IIKO\Model\IikoTransportPublicApiContractsCancelCausesCancelCausesResponse
```

Delivery cancel causes.

> Allowed from version `7.7.1`.   > Restriction group: `Data: dictionaries`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DictionariesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_address_regions_request = new \IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest

try {
    $result = $apiInstance->api1CancelCausesPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_regions_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DictionariesApi->api1CancelCausesPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_address_regions_request** | [**\IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest**](../Model/IikoTransportPublicApiContractsAddressRegionsRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsCancelCausesCancelCausesResponse**](../Model/IikoTransportPublicApiContractsCancelCausesCancelCausesResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1DeliveriesOrderTypesPost()`

```php
api1DeliveriesOrderTypesPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_regions_request): \IIKO\Model\IikoTransportPublicApiContractsOrderTypesOrderTypesResponse
```

Order types.

> Restriction group: `Data: dictionaries`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DictionariesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_address_regions_request = new \IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest

try {
    $result = $apiInstance->api1DeliveriesOrderTypesPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_regions_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DictionariesApi->api1DeliveriesOrderTypesPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_address_regions_request** | [**\IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest**](../Model/IikoTransportPublicApiContractsAddressRegionsRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsOrderTypesOrderTypesResponse**](../Model/IikoTransportPublicApiContractsOrderTypesOrderTypesResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1DiscountsPost()`

```php
api1DiscountsPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_regions_request): \IIKO\Model\IikoTransportPublicApiContractsDiscountsDiscountsResponse
```

Discounts / surcharges.

> Restriction group: `Data: dictionaries`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DictionariesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_address_regions_request = new \IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest

try {
    $result = $apiInstance->api1DiscountsPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_regions_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DictionariesApi->api1DiscountsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_address_regions_request** | [**\IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest**](../Model/IikoTransportPublicApiContractsAddressRegionsRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsDiscountsDiscountsResponse**](../Model/IikoTransportPublicApiContractsDiscountsDiscountsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1PaymentTypesPost()`

```php
api1PaymentTypesPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_regions_request): \IIKO\Model\IikoTransportPublicApiContractsPaymentTypesPaymentTypesResponse
```

Payment types.

> Restriction group: `Data: dictionaries`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DictionariesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_address_regions_request = new \IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest

try {
    $result = $apiInstance->api1PaymentTypesPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_regions_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DictionariesApi->api1PaymentTypesPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_address_regions_request** | [**\IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest**](../Model/IikoTransportPublicApiContractsAddressRegionsRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsPaymentTypesPaymentTypesResponse**](../Model/IikoTransportPublicApiContractsPaymentTypesPaymentTypesResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1RemovalTypesPost()`

```php
api1RemovalTypesPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_regions_request): \IIKO\Model\IikoTransportPublicApiContractsRemovalTypesRemovalTypesResponse
```

Removal types (reasons for deletion).

> Allowed from version `7.5.3`.   > Restriction group: `Data: dictionaries`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DictionariesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_address_regions_request = new \IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest

try {
    $result = $apiInstance->api1RemovalTypesPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_regions_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DictionariesApi->api1RemovalTypesPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_address_regions_request** | [**\IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest**](../Model/IikoTransportPublicApiContractsAddressRegionsRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsRemovalTypesRemovalTypesResponse**](../Model/IikoTransportPublicApiContractsRemovalTypesRemovalTypesResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1TipsTypesPost()`

```php
api1TipsTypesPost($authorization, $timeout): \IIKO\Model\IikoTransportPublicApiContractsTipsTypesTipsTypesResponse
```

Get tips types for api-login`s rms group.

> Allowed from version `7.7.4`.   > Restriction group: `Data: dictionaries`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DictionariesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.

try {
    $result = $apiInstance->api1TipsTypesPost($authorization, $timeout);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DictionariesApi->api1TipsTypesPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsTipsTypesTipsTypesResponse**](../Model/IikoTransportPublicApiContractsTipsTypesTipsTypesResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
