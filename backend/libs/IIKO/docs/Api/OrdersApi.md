# IIKO\OrdersApi

Orders API.

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**api1OrderAddCustomerPost()**](OrdersApi.md#api1OrderAddCustomerPost) | **POST** /api/1/order/add_customer | Add customer to order. |
| [**api1OrderAddItemsPost()**](OrdersApi.md#api1OrderAddItemsPost) | **POST** /api/1/order/add_items | Add order items. |
| [**api1OrderAddPaymentsPost()**](OrdersApi.md#api1OrderAddPaymentsPost) | **POST** /api/1/order/add_payments | Add order payments. |
| [**api1OrderByIdPost()**](OrdersApi.md#api1OrderByIdPost) | **POST** /api/1/order/by_id | Retrieve orders by IDs. |
| [**api1OrderByTablePost()**](OrdersApi.md#api1OrderByTablePost) | **POST** /api/1/order/by_table | Retrieve orders by tables. |
| [**api1OrderCancelPost()**](OrdersApi.md#api1OrderCancelPost) | **POST** /api/1/order/cancel | Cancel the table order. |
| [**api1OrderChangeExternalDataPost()**](OrdersApi.md#api1OrderChangeExternalDataPost) | **POST** /api/1/order/change_external_data | Change table order external_data. |
| [**api1OrderChangePaymentsPost()**](OrdersApi.md#api1OrderChangePaymentsPost) | **POST** /api/1/order/change_payments | Change table order&#39;s payments. |
| [**api1OrderClosePost()**](OrdersApi.md#api1OrderClosePost) | **POST** /api/1/order/close | Close order. |
| [**api1OrderCreatePost()**](OrdersApi.md#api1OrderCreatePost) | **POST** /api/1/order/create | Create order. |
| [**api1OrderInitByPosOrderPost()**](OrdersApi.md#api1OrderInitByPosOrderPost) | **POST** /api/1/order/init_by_posOrder | Init orders, created on POS, by POS orders. |
| [**api1OrderInitByTablePost()**](OrdersApi.md#api1OrderInitByTablePost) | **POST** /api/1/order/init_by_table | Init orders, created on POS, by tables. |


## `api1OrderAddCustomerPost()`

```php
api1OrderAddCustomerPost($authorization, $timeout, $iiko_transport_public_api_contracts_table_orders_request_add_customer_to_table_order_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Add customer to order.

> Allowed from version `7.7.1`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Orders: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\OrdersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_table_orders_request_add_customer_to_table_order_request = new \IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestAddCustomerToTableOrderRequest(); // \IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestAddCustomerToTableOrderRequest

try {
    $result = $apiInstance->api1OrderAddCustomerPost($authorization, $timeout, $iiko_transport_public_api_contracts_table_orders_request_add_customer_to_table_order_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrdersApi->api1OrderAddCustomerPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_table_orders_request_add_customer_to_table_order_request** | [**\IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestAddCustomerToTableOrderRequest**](../Model/IikoTransportPublicApiContractsTableOrdersRequestAddCustomerToTableOrderRequest.md)|  | [optional] |

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

## `api1OrderAddItemsPost()`

```php
api1OrderAddItemsPost($authorization, $timeout, $iiko_transport_public_api_contracts_table_orders_request_add_items_to_table_order_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Add order items.

> Allowed from version `7.4.6`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Orders: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\OrdersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_table_orders_request_add_items_to_table_order_request = new \IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestAddItemsToTableOrderRequest(); // \IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestAddItemsToTableOrderRequest

try {
    $result = $apiInstance->api1OrderAddItemsPost($authorization, $timeout, $iiko_transport_public_api_contracts_table_orders_request_add_items_to_table_order_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrdersApi->api1OrderAddItemsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_table_orders_request_add_items_to_table_order_request** | [**\IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestAddItemsToTableOrderRequest**](../Model/IikoTransportPublicApiContractsTableOrdersRequestAddItemsToTableOrderRequest.md)|  | [optional] |

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

## `api1OrderAddPaymentsPost()`

```php
api1OrderAddPaymentsPost($authorization, $timeout, $iiko_transport_public_api_contracts_orders_common_add_order_payments_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Add order payments.

> Allowed from version `8.2.6`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Order payments: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\OrdersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_orders_common_add_order_payments_request = new \IIKO\Model\IikoTransportPublicApiContractsOrdersCommonAddOrderPaymentsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsOrdersCommonAddOrderPaymentsRequest

try {
    $result = $apiInstance->api1OrderAddPaymentsPost($authorization, $timeout, $iiko_transport_public_api_contracts_orders_common_add_order_payments_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrdersApi->api1OrderAddPaymentsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_orders_common_add_order_payments_request** | [**\IIKO\Model\IikoTransportPublicApiContractsOrdersCommonAddOrderPaymentsRequest**](../Model/IikoTransportPublicApiContractsOrdersCommonAddOrderPaymentsRequest.md)|  | [optional] |

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

## `api1OrderByIdPost()`

```php
api1OrderByIdPost($authorization, $timeout, $iiko_transport_public_api_contracts_table_orders_request_get_table_orders_by_id_request): \IIKO\Model\IikoTransportPublicApiContractsTableOrdersResponseTableOrdersResponse
```

Retrieve orders by IDs.

> Allowed from version `7.4.6`.   > Restriction group: `Orders: receiving`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\OrdersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_table_orders_request_get_table_orders_by_id_request = new \IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestGetTableOrdersByIdRequest(); // \IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestGetTableOrdersByIdRequest

try {
    $result = $apiInstance->api1OrderByIdPost($authorization, $timeout, $iiko_transport_public_api_contracts_table_orders_request_get_table_orders_by_id_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrdersApi->api1OrderByIdPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_table_orders_request_get_table_orders_by_id_request** | [**\IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestGetTableOrdersByIdRequest**](../Model/IikoTransportPublicApiContractsTableOrdersRequestGetTableOrdersByIdRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsTableOrdersResponseTableOrdersResponse**](../Model/IikoTransportPublicApiContractsTableOrdersResponseTableOrdersResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1OrderByTablePost()`

```php
api1OrderByTablePost($authorization, $timeout, $iiko_transport_public_api_contracts_table_orders_request_get_table_orders_by_table_request): \IIKO\Model\IikoTransportPublicApiContractsTableOrdersResponseTableOrdersResponse
```

Retrieve orders by tables.

> Allowed from version `7.4.6`.   > Restriction group: `Orders: receiving`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\OrdersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_table_orders_request_get_table_orders_by_table_request = new \IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestGetTableOrdersByTableRequest(); // \IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestGetTableOrdersByTableRequest

try {
    $result = $apiInstance->api1OrderByTablePost($authorization, $timeout, $iiko_transport_public_api_contracts_table_orders_request_get_table_orders_by_table_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrdersApi->api1OrderByTablePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_table_orders_request_get_table_orders_by_table_request** | [**\IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestGetTableOrdersByTableRequest**](../Model/IikoTransportPublicApiContractsTableOrdersRequestGetTableOrdersByTableRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsTableOrdersResponseTableOrdersResponse**](../Model/IikoTransportPublicApiContractsTableOrdersResponseTableOrdersResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1OrderCancelPost()`

```php
api1OrderCancelPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_cancel_table_order_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Cancel the table order.

> Allowed from version `9.0.5`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\OrdersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_cancel_table_order_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCancelTableOrderRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCancelTableOrderRequest

try {
    $result = $apiInstance->api1OrderCancelPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_cancel_table_order_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrdersApi->api1OrderCancelPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_cancel_table_order_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCancelTableOrderRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestCancelTableOrderRequest.md)|  | [optional] |

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

## `api1OrderChangeExternalDataPost()`

```php
api1OrderChangeExternalDataPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_order_change_external_data_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Change table order external_data.

> Restriction group: `Orders: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\OrdersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_update_order_change_external_data_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeExternalDataRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeExternalDataRequest

try {
    $result = $apiInstance->api1OrderChangeExternalDataPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_order_change_external_data_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrdersApi->api1OrderChangeExternalDataPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_update_order_change_external_data_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeExternalDataRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeExternalDataRequest.md)|  | [optional] |

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

## `api1OrderChangePaymentsPost()`

```php
api1OrderChangePaymentsPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_order_change_payments_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Change table order's payments.

> Method will fail if there are any processed payments in the order.  > If all payments in the order are unprocessed they will be removed and replaced with new ones.   > Allowed from version `7.7.4`.   > Restriction group: `Order payments: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\OrdersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_update_order_change_payments_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangePaymentsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangePaymentsRequest

try {
    $result = $apiInstance->api1OrderChangePaymentsPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_order_change_payments_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrdersApi->api1OrderChangePaymentsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_update_order_change_payments_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangePaymentsRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangePaymentsRequest.md)|  | [optional] |

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

## `api1OrderClosePost()`

```php
api1OrderClosePost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_close_table_order_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Close order.

> Allowed from version `7.4.6`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Order status: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\OrdersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_close_table_order_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCloseTableOrderRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCloseTableOrderRequest

try {
    $result = $apiInstance->api1OrderClosePost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_close_table_order_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrdersApi->api1OrderClosePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_close_table_order_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCloseTableOrderRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestCloseTableOrderRequest.md)|  | [optional] |

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

## `api1OrderCreatePost()`

```php
api1OrderCreatePost($authorization, $timeout, $iiko_transport_public_api_contracts_table_orders_request_create_table_order_request): \IIKO\Model\IikoTransportPublicApiContractsTableOrdersResponseTableOrderResponse
```

Create order.

> Allowed from version `7.4.6`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Orders: creating`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\OrdersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_table_orders_request_create_table_order_request = new \IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestCreateTableOrderRequest(); // \IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestCreateTableOrderRequest

try {
    $result = $apiInstance->api1OrderCreatePost($authorization, $timeout, $iiko_transport_public_api_contracts_table_orders_request_create_table_order_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrdersApi->api1OrderCreatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_table_orders_request_create_table_order_request** | [**\IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestCreateTableOrderRequest**](../Model/IikoTransportPublicApiContractsTableOrdersRequestCreateTableOrderRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsTableOrdersResponseTableOrderResponse**](../Model/IikoTransportPublicApiContractsTableOrdersResponseTableOrderResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1OrderInitByPosOrderPost()`

```php
api1OrderInitByPosOrderPost($authorization, $timeout, $iiko_transport_public_api_contracts_table_orders_request_init_table_order_by_pos_order_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Init orders, created on POS, by POS orders.

> Allowed from version `7.7.1`.   > Restriction group: `Orders: loading data`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\OrdersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_table_orders_request_init_table_order_by_pos_order_request = new \IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestInitTableOrderByPosOrderRequest(); // \IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestInitTableOrderByPosOrderRequest

try {
    $result = $apiInstance->api1OrderInitByPosOrderPost($authorization, $timeout, $iiko_transport_public_api_contracts_table_orders_request_init_table_order_by_pos_order_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrdersApi->api1OrderInitByPosOrderPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_table_orders_request_init_table_order_by_pos_order_request** | [**\IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestInitTableOrderByPosOrderRequest**](../Model/IikoTransportPublicApiContractsTableOrdersRequestInitTableOrderByPosOrderRequest.md)|  | [optional] |

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

## `api1OrderInitByTablePost()`

```php
api1OrderInitByTablePost($authorization, $timeout, $iiko_transport_public_api_contracts_table_orders_request_init_table_order_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Init orders, created on POS, by tables.

> Allowed from version `7.7.1`.   > Restriction group: `Orders: loading data`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\OrdersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_table_orders_request_init_table_order_request = new \IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestInitTableOrderRequest(); // \IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestInitTableOrderRequest

try {
    $result = $apiInstance->api1OrderInitByTablePost($authorization, $timeout, $iiko_transport_public_api_contracts_table_orders_request_init_table_order_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrdersApi->api1OrderInitByTablePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_table_orders_request_init_table_order_request** | [**\IIKO\Model\IikoTransportPublicApiContractsTableOrdersRequestInitTableOrderRequest**](../Model/IikoTransportPublicApiContractsTableOrdersRequestInitTableOrderRequest.md)|  | [optional] |

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
