# IIKO\DeprecatedApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**api1DeliveriesUpdateOrderPaymentsPost()**](DeprecatedApi.md#api1DeliveriesUpdateOrderPaymentsPost) | **POST** /api/1/deliveries/update_order_payments | Update order payment details. |
| [**api1OrganizationsGet()**](DeprecatedApi.md#api1OrganizationsGet) | **GET** /api/1/organizations | Returns organizations available to api-login user. |


## `api1DeliveriesUpdateOrderPaymentsPost()`

```php
api1DeliveriesUpdateOrderPaymentsPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_order_payments_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Update order payment details.

> Deprecated, use `api/1/deliveries/change_payments` method instead.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Deprecated`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeprecatedApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_update_order_payments_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderPaymentsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderPaymentsRequest

try {
    $result = $apiInstance->api1DeliveriesUpdateOrderPaymentsPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_order_payments_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeprecatedApi->api1DeliveriesUpdateOrderPaymentsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_update_order_payments_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderPaymentsRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderPaymentsRequest.md)|  | [optional] |

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

## `api1OrganizationsGet()`

```php
api1OrganizationsGet($authorization, $timeout): \IIKO\Model\IikoTransportPublicApiContractsOrganizationsGetSimpleOrganizationsResponse
```

Returns organizations available to api-login user.

> Deprecated, use `POST api/1/organizations`.   > Restriction group: `Data: dictionaries`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeprecatedApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.

try {
    $result = $apiInstance->api1OrganizationsGet($authorization, $timeout);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeprecatedApi->api1OrganizationsGet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsOrganizationsGetSimpleOrganizationsResponse**](../Model/IikoTransportPublicApiContractsOrganizationsGetSimpleOrganizationsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
