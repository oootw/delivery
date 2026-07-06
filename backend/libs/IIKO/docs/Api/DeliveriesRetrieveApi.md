# IIKO\DeliveriesRetrieveApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**api1DeliveriesByDeliveryDateAndPhonePost()**](DeliveriesRetrieveApi.md#api1DeliveriesByDeliveryDateAndPhonePost) | **POST** /api/1/deliveries/by_delivery_date_and_phone | Retrieve list of orders by telephone number, dates and revision. |
| [**api1DeliveriesByDeliveryDateAndSourceKeyAndFilterPost()**](DeliveriesRetrieveApi.md#api1DeliveriesByDeliveryDateAndSourceKeyAndFilterPost) | **POST** /api/1/deliveries/by_delivery_date_and_source_key_and_filter | Search orders by search text and additional filters (date, problem, statuses and other). |
| [**api1DeliveriesByDeliveryDateAndStatusPost()**](DeliveriesRetrieveApi.md#api1DeliveriesByDeliveryDateAndStatusPost) | **POST** /api/1/deliveries/by_delivery_date_and_status | Retrieve list of orders by statuses and dates. |
| [**api1DeliveriesByIdPost()**](DeliveriesRetrieveApi.md#api1DeliveriesByIdPost) | **POST** /api/1/deliveries/by_id | Retrieve orders by IDs. |
| [**api1DeliveriesByRevisionPost()**](DeliveriesRetrieveApi.md#api1DeliveriesByRevisionPost) | **POST** /api/1/deliveries/by_revision | Retrieve list of orders changed from the time revision was passed. |
| [**api1DeliveriesHistoryByDeliveryDateAndPhonePost()**](DeliveriesRetrieveApi.md#api1DeliveriesHistoryByDeliveryDateAndPhonePost) | **POST** /api/1/deliveries/history/by_delivery_date_and_phone | Retrieve list of history orders by telephone number, dates and revision. |


## `api1DeliveriesByDeliveryDateAndPhonePost()`

```php
api1DeliveriesByDeliveryDateAndPhonePost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_orders_by_delivery_date_and_phone_request): \IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrdersWithRevisionResponse
```

Retrieve list of orders by telephone number, dates and revision.

> Restriction group: `Orders: receiving`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesRetrieveApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_orders_by_delivery_date_and_phone_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestOrdersByDeliveryDateAndPhoneRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestOrdersByDeliveryDateAndPhoneRequest

try {
    $result = $apiInstance->api1DeliveriesByDeliveryDateAndPhonePost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_orders_by_delivery_date_and_phone_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesRetrieveApi->api1DeliveriesByDeliveryDateAndPhonePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_orders_by_delivery_date_and_phone_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestOrdersByDeliveryDateAndPhoneRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestOrdersByDeliveryDateAndPhoneRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrdersWithRevisionResponse**](../Model/IikoTransportPublicApiContractsDeliveriesResponseOrdersWithRevisionResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1DeliveriesByDeliveryDateAndSourceKeyAndFilterPost()`

```php
api1DeliveriesByDeliveryDateAndSourceKeyAndFilterPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_orders_by_delivery_date_and_filter_request): \IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrdersWithRevisionResponse
```

Search orders by search text and additional filters (date, problem, statuses and other).

> Restriction group: `Orders: receiving`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesRetrieveApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_orders_by_delivery_date_and_filter_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestOrdersByDeliveryDateAndFilterRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestOrdersByDeliveryDateAndFilterRequest

try {
    $result = $apiInstance->api1DeliveriesByDeliveryDateAndSourceKeyAndFilterPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_orders_by_delivery_date_and_filter_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesRetrieveApi->api1DeliveriesByDeliveryDateAndSourceKeyAndFilterPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_orders_by_delivery_date_and_filter_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestOrdersByDeliveryDateAndFilterRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestOrdersByDeliveryDateAndFilterRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrdersWithRevisionResponse**](../Model/IikoTransportPublicApiContractsDeliveriesResponseOrdersWithRevisionResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1DeliveriesByDeliveryDateAndStatusPost()`

```php
api1DeliveriesByDeliveryDateAndStatusPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_orders_by_delivery_date_and_status_request): \IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrdersWithRevisionResponse
```

Retrieve list of orders by statuses and dates.

> Restriction group: `Orders: receiving`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesRetrieveApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_orders_by_delivery_date_and_status_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestOrdersByDeliveryDateAndStatusRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestOrdersByDeliveryDateAndStatusRequest

try {
    $result = $apiInstance->api1DeliveriesByDeliveryDateAndStatusPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_orders_by_delivery_date_and_status_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesRetrieveApi->api1DeliveriesByDeliveryDateAndStatusPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_orders_by_delivery_date_and_status_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestOrdersByDeliveryDateAndStatusRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestOrdersByDeliveryDateAndStatusRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrdersWithRevisionResponse**](../Model/IikoTransportPublicApiContractsDeliveriesResponseOrdersWithRevisionResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1DeliveriesByIdPost()`

```php
api1DeliveriesByIdPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_orders_by_id_request): \IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrdersResponse
```

Retrieve orders by IDs.

> Restriction group: `Orders: receiving`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesRetrieveApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_orders_by_id_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestOrdersByIdRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestOrdersByIdRequest

try {
    $result = $apiInstance->api1DeliveriesByIdPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_orders_by_id_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesRetrieveApi->api1DeliveriesByIdPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_orders_by_id_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestOrdersByIdRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestOrdersByIdRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrdersResponse**](../Model/IikoTransportPublicApiContractsDeliveriesResponseOrdersResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1DeliveriesByRevisionPost()`

```php
api1DeliveriesByRevisionPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_orders_by_revision_request): \IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrdersWithRevisionResponse
```

Retrieve list of orders changed from the time revision was passed.

> Restriction group: `Orders: receiving by revision`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesRetrieveApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_orders_by_revision_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestOrdersByRevisionRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestOrdersByRevisionRequest

try {
    $result = $apiInstance->api1DeliveriesByRevisionPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_orders_by_revision_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesRetrieveApi->api1DeliveriesByRevisionPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_orders_by_revision_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestOrdersByRevisionRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestOrdersByRevisionRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrdersWithRevisionResponse**](../Model/IikoTransportPublicApiContractsDeliveriesResponseOrdersWithRevisionResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1DeliveriesHistoryByDeliveryDateAndPhonePost()`

```php
api1DeliveriesHistoryByDeliveryDateAndPhonePost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_orders_history_by_delivery_date_and_phone_request): \IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrdersWithRevisionResponse
```

Retrieve list of history orders by telephone number, dates and revision.

> Restriction group: `Orders: receiving`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesRetrieveApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_orders_history_by_delivery_date_and_phone_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestOrdersHistoryByDeliveryDateAndPhoneRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestOrdersHistoryByDeliveryDateAndPhoneRequest

try {
    $result = $apiInstance->api1DeliveriesHistoryByDeliveryDateAndPhonePost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_orders_history_by_delivery_date_and_phone_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesRetrieveApi->api1DeliveriesHistoryByDeliveryDateAndPhonePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_orders_history_by_delivery_date_and_phone_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestOrdersHistoryByDeliveryDateAndPhoneRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestOrdersHistoryByDeliveryDateAndPhoneRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrdersWithRevisionResponse**](../Model/IikoTransportPublicApiContractsDeliveriesResponseOrdersWithRevisionResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
