# IIKO\DeliveryRestrictionsApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**api1DeliveryRestrictionsAllowedPost()**](DeliveryRestrictionsApi.md#api1DeliveryRestrictionsAllowedPost) | **POST** /api/1/delivery_restrictions/allowed | Get suitable terminal groups for delivery restrictions. |
| [**api1DeliveryRestrictionsPost()**](DeliveryRestrictionsApi.md#api1DeliveryRestrictionsPost) | **POST** /api/1/delivery_restrictions | Retrieve list of delivery restrictions. |


## `api1DeliveryRestrictionsAllowedPost()`

```php
api1DeliveryRestrictionsAllowedPost($authorization, $timeout, $iiko_transport_public_api_contracts_delivery_restrictions_allowed_restrictions_get_allowed_restrictions_request): \IIKO\Model\IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsGetAllowedRestrictionsResponse
```

Get suitable terminal groups for delivery restrictions.

> Allowed from version `6.4.16`.   > Restriction group: `Orders: preparing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveryRestrictionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_delivery_restrictions_allowed_restrictions_get_allowed_restrictions_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsGetAllowedRestrictionsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsGetAllowedRestrictionsRequest

try {
    $result = $apiInstance->api1DeliveryRestrictionsAllowedPost($authorization, $timeout, $iiko_transport_public_api_contracts_delivery_restrictions_allowed_restrictions_get_allowed_restrictions_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveryRestrictionsApi->api1DeliveryRestrictionsAllowedPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_delivery_restrictions_allowed_restrictions_get_allowed_restrictions_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsGetAllowedRestrictionsRequest**](../Model/IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsGetAllowedRestrictionsRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsGetAllowedRestrictionsResponse**](../Model/IikoTransportPublicApiContractsDeliveryRestrictionsAllowedRestrictionsGetAllowedRestrictionsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1DeliveryRestrictionsPost()`

```php
api1DeliveryRestrictionsPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_regions_request): \IIKO\Model\IikoTransportPublicApiContractsDeliveryRestrictionsGetDeliveryRestrictionsResponse
```

Retrieve list of delivery restrictions.

> Allowed from version `6.4.16`.   > Restriction group: `Data: dictionaries`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveryRestrictionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_address_regions_request = new \IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest

try {
    $result = $apiInstance->api1DeliveryRestrictionsPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_regions_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveryRestrictionsApi->api1DeliveryRestrictionsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_address_regions_request** | [**\IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest**](../Model/IikoTransportPublicApiContractsAddressRegionsRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsDeliveryRestrictionsGetDeliveryRestrictionsResponse**](../Model/IikoTransportPublicApiContractsDeliveryRestrictionsGetDeliveryRestrictionsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
