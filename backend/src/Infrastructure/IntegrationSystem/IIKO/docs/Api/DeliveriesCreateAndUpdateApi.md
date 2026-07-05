# IIKO\DeliveriesCreateAndUpdateApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**api1DeliveriesAddItemsPost()**](DeliveriesCreateAndUpdateApi.md#api1DeliveriesAddItemsPost) | **POST** /api/1/deliveries/add_items | Add order items. |
| [**api1DeliveriesAddPaymentsPost()**](DeliveriesCreateAndUpdateApi.md#api1DeliveriesAddPaymentsPost) | **POST** /api/1/deliveries/add_payments | Add order payments. |
| [**api1DeliveriesCancelConfirmationPost()**](DeliveriesCreateAndUpdateApi.md#api1DeliveriesCancelConfirmationPost) | **POST** /api/1/deliveries/cancel_confirmation | Cancel delivery confirmation. |
| [**api1DeliveriesCancelPost()**](DeliveriesCreateAndUpdateApi.md#api1DeliveriesCancelPost) | **POST** /api/1/deliveries/cancel | Cancel delivery order. |
| [**api1DeliveriesChangeCommentPost()**](DeliveriesCreateAndUpdateApi.md#api1DeliveriesChangeCommentPost) | **POST** /api/1/deliveries/change_comment | Change delivery comment. |
| [**api1DeliveriesChangeCompleteBeforePost()**](DeliveriesCreateAndUpdateApi.md#api1DeliveriesChangeCompleteBeforePost) | **POST** /api/1/deliveries/change_complete_before | Change time when client wants the order to be delivered. |
| [**api1DeliveriesChangeDeliveryPointPost()**](DeliveriesCreateAndUpdateApi.md#api1DeliveriesChangeDeliveryPointPost) | **POST** /api/1/deliveries/change_delivery_point | Change order&#39;s delivery point information. |
| [**api1DeliveriesChangeDriverInfoPost()**](DeliveriesCreateAndUpdateApi.md#api1DeliveriesChangeDriverInfoPost) | **POST** /api/1/deliveries/change_driver_info | Change driver info. |
| [**api1DeliveriesChangeExternalDataPost()**](DeliveriesCreateAndUpdateApi.md#api1DeliveriesChangeExternalDataPost) | **POST** /api/1/deliveries/change_external_data | Change delivery external data. |
| [**api1DeliveriesChangeOperatorPost()**](DeliveriesCreateAndUpdateApi.md#api1DeliveriesChangeOperatorPost) | **POST** /api/1/deliveries/change_operator | Assign/change the order operator. |
| [**api1DeliveriesChangePaymentsPost()**](DeliveriesCreateAndUpdateApi.md#api1DeliveriesChangePaymentsPost) | **POST** /api/1/deliveries/change_payments | Change order&#39;s payments. |
| [**api1DeliveriesChangeServiceTypePost()**](DeliveriesCreateAndUpdateApi.md#api1DeliveriesChangeServiceTypePost) | **POST** /api/1/deliveries/change_service_type | Change order&#39;s delivery type. |
| [**api1DeliveriesClosePost()**](DeliveriesCreateAndUpdateApi.md#api1DeliveriesClosePost) | **POST** /api/1/deliveries/close | Close order. |
| [**api1DeliveriesConfirmPost()**](DeliveriesCreateAndUpdateApi.md#api1DeliveriesConfirmPost) | **POST** /api/1/deliveries/confirm | Confirm delivery. |
| [**api1DeliveriesCreatePost()**](DeliveriesCreateAndUpdateApi.md#api1DeliveriesCreatePost) | **POST** /api/1/deliveries/create | Create delivery. |
| [**api1DeliveriesPrintDeliveryBillPost()**](DeliveriesCreateAndUpdateApi.md#api1DeliveriesPrintDeliveryBillPost) | **POST** /api/1/deliveries/print_delivery_bill | Print delivery bill. |
| [**api1DeliveriesUpdateOrderCourierPost()**](DeliveriesCreateAndUpdateApi.md#api1DeliveriesUpdateOrderCourierPost) | **POST** /api/1/deliveries/update_order_courier | Update order courier. |
| [**api1DeliveriesUpdateOrderDeliveryStatusPost()**](DeliveriesCreateAndUpdateApi.md#api1DeliveriesUpdateOrderDeliveryStatusPost) | **POST** /api/1/deliveries/update_order_delivery_status | Update delivery status. |
| [**api1DeliveriesUpdateOrderPaymentsPost()**](DeliveriesCreateAndUpdateApi.md#api1DeliveriesUpdateOrderPaymentsPost) | **POST** /api/1/deliveries/update_order_payments | Update order payment details. |
| [**api1DeliveriesUpdateOrderProblemPost()**](DeliveriesCreateAndUpdateApi.md#api1DeliveriesUpdateOrderProblemPost) | **POST** /api/1/deliveries/update_order_problem | Update order problem. |
| [**api1DeliveriesUpdateTrackingLinkPost()**](DeliveriesCreateAndUpdateApi.md#api1DeliveriesUpdateTrackingLinkPost) | **POST** /api/1/deliveries/update_tracking_link | Update tracking link of an order. |
| [**api1OrderPrintBillPost()**](DeliveriesCreateAndUpdateApi.md#api1OrderPrintBillPost) | **POST** /api/1/order/print_bill | Print bill. |


## `api1DeliveriesAddItemsPost()`

```php
api1DeliveriesAddItemsPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_add_order_items_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Add order items.

> Allowed from version `7.4.6`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Orders: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesCreateAndUpdateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_add_order_items_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestAddOrderItemsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestAddOrderItemsRequest

try {
    $result = $apiInstance->api1DeliveriesAddItemsPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_add_order_items_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesCreateAndUpdateApi->api1DeliveriesAddItemsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_add_order_items_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestAddOrderItemsRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestAddOrderItemsRequest.md)|  | [optional] |

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

## `api1DeliveriesAddPaymentsPost()`

```php
api1DeliveriesAddPaymentsPost($authorization, $timeout, $iiko_transport_public_api_contracts_orders_common_add_order_payments_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Add order payments.

> Allowed from version `8.4.6`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Order payments: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesCreateAndUpdateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_orders_common_add_order_payments_request = new \IIKO\Model\IikoTransportPublicApiContractsOrdersCommonAddOrderPaymentsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsOrdersCommonAddOrderPaymentsRequest

try {
    $result = $apiInstance->api1DeliveriesAddPaymentsPost($authorization, $timeout, $iiko_transport_public_api_contracts_orders_common_add_order_payments_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesCreateAndUpdateApi->api1DeliveriesAddPaymentsPost: ', $e->getMessage(), PHP_EOL;
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

## `api1DeliveriesCancelConfirmationPost()`

```php
api1DeliveriesCancelConfirmationPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Cancel delivery confirmation.

> Allowed from version `7.6.1`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Order status: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesCreateAndUpdateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest

try {
    $result = $apiInstance->api1DeliveriesCancelConfirmationPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesCreateAndUpdateApi->api1DeliveriesCancelConfirmationPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest**](../Model/IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest.md)|  | [optional] |

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

## `api1DeliveriesCancelPost()`

```php
api1DeliveriesCancelPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_cancel_order_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Cancel delivery order.

> Allowed from version `7.5.4`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Order status: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesCreateAndUpdateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_cancel_order_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCancelOrderRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCancelOrderRequest

try {
    $result = $apiInstance->api1DeliveriesCancelPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_cancel_order_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesCreateAndUpdateApi->api1DeliveriesCancelPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_cancel_order_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCancelOrderRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestCancelOrderRequest.md)|  | [optional] |

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

## `api1DeliveriesChangeCommentPost()`

```php
api1DeliveriesChangeCommentPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_order_change_delivery_comment_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Change delivery comment.

> Allowed from version `7.6.1`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Orders: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesCreateAndUpdateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_update_order_change_delivery_comment_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeDeliveryCommentRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeDeliveryCommentRequest

try {
    $result = $apiInstance->api1DeliveriesChangeCommentPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_order_change_delivery_comment_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesCreateAndUpdateApi->api1DeliveriesChangeCommentPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_update_order_change_delivery_comment_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeDeliveryCommentRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeDeliveryCommentRequest.md)|  | [optional] |

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

## `api1DeliveriesChangeCompleteBeforePost()`

```php
api1DeliveriesChangeCompleteBeforePost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_order_change_complete_before_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Change time when client wants the order to be delivered.

> Allowed from version `7.5.4`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Orders: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesCreateAndUpdateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_update_order_change_complete_before_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeCompleteBeforeRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeCompleteBeforeRequest

try {
    $result = $apiInstance->api1DeliveriesChangeCompleteBeforePost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_order_change_complete_before_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesCreateAndUpdateApi->api1DeliveriesChangeCompleteBeforePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_update_order_change_complete_before_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeCompleteBeforeRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeCompleteBeforeRequest.md)|  | [optional] |

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

## `api1DeliveriesChangeDeliveryPointPost()`

```php
api1DeliveriesChangeDeliveryPointPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_order_change_delivery_point_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Change order's delivery point information.

> Allowed from version `7.5.4`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Orders: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesCreateAndUpdateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_update_order_change_delivery_point_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeDeliveryPointRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeDeliveryPointRequest

try {
    $result = $apiInstance->api1DeliveriesChangeDeliveryPointPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_order_change_delivery_point_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesCreateAndUpdateApi->api1DeliveriesChangeDeliveryPointPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_update_order_change_delivery_point_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeDeliveryPointRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeDeliveryPointRequest.md)|  | [optional] |

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

## `api1DeliveriesChangeDriverInfoPost()`

```php
api1DeliveriesChangeDriverInfoPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_change_driver_info_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Change driver info.

> Allowed from version `8.6.6`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Order driver: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesCreateAndUpdateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_change_driver_info_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestChangeDriverInfoRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestChangeDriverInfoRequest

try {
    $result = $apiInstance->api1DeliveriesChangeDriverInfoPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_change_driver_info_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesCreateAndUpdateApi->api1DeliveriesChangeDriverInfoPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_change_driver_info_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestChangeDriverInfoRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestChangeDriverInfoRequest.md)|  | [optional] |

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

## `api1DeliveriesChangeExternalDataPost()`

```php
api1DeliveriesChangeExternalDataPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_order_change_external_data_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Change delivery external data.

> Restriction group: `Orders: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesCreateAndUpdateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_update_order_change_external_data_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeExternalDataRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeExternalDataRequest

try {
    $result = $apiInstance->api1DeliveriesChangeExternalDataPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_order_change_external_data_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesCreateAndUpdateApi->api1DeliveriesChangeExternalDataPost: ', $e->getMessage(), PHP_EOL;
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

## `api1DeliveriesChangeOperatorPost()`

```php
api1DeliveriesChangeOperatorPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_order_change_delivery_operator_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Assign/change the order operator.

> Allowed from version `7.6.1`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Orders: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesCreateAndUpdateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_update_order_change_delivery_operator_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeDeliveryOperatorRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeDeliveryOperatorRequest

try {
    $result = $apiInstance->api1DeliveriesChangeOperatorPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_order_change_delivery_operator_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesCreateAndUpdateApi->api1DeliveriesChangeOperatorPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_update_order_change_delivery_operator_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeDeliveryOperatorRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeDeliveryOperatorRequest.md)|  | [optional] |

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

## `api1DeliveriesChangePaymentsPost()`

```php
api1DeliveriesChangePaymentsPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_order_change_payments_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Change order's payments.

> Method will fail if there are any processed payments in the order.  > If all payments in the order are unprocessed they will be removed and replaced with new ones.   > Allowed from version `7.6.3`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Order payments: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesCreateAndUpdateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_update_order_change_payments_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangePaymentsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangePaymentsRequest

try {
    $result = $apiInstance->api1DeliveriesChangePaymentsPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_order_change_payments_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesCreateAndUpdateApi->api1DeliveriesChangePaymentsPost: ', $e->getMessage(), PHP_EOL;
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

## `api1DeliveriesChangeServiceTypePost()`

```php
api1DeliveriesChangeServiceTypePost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_order_change_service_type_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Change order's delivery type.

> Allowed from version `7.5.4`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Orders: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesCreateAndUpdateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_update_order_change_service_type_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeServiceTypeRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeServiceTypeRequest

try {
    $result = $apiInstance->api1DeliveriesChangeServiceTypePost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_order_change_service_type_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesCreateAndUpdateApi->api1DeliveriesChangeServiceTypePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_update_order_change_service_type_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeServiceTypeRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderChangeServiceTypeRequest.md)|  | [optional] |

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

## `api1DeliveriesClosePost()`

```php
api1DeliveriesClosePost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_close_delivery_order_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Close order.

> Before version `8.0.6` it's possible to close deliveries with `DeliveryByClient`  orderServiceType only, starting from version `8.0.6` it's also possible to close  `DeliveryByCourier` deiveries in the DeliveryStatus `OnWay` or `Delivered` .   > Allowed from version `7.4.6`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Order status: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesCreateAndUpdateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_close_delivery_order_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCloseDeliveryOrderRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCloseDeliveryOrderRequest

try {
    $result = $apiInstance->api1DeliveriesClosePost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_close_delivery_order_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesCreateAndUpdateApi->api1DeliveriesClosePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_close_delivery_order_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCloseDeliveryOrderRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestCloseDeliveryOrderRequest.md)|  | [optional] |

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

## `api1DeliveriesConfirmPost()`

```php
api1DeliveriesConfirmPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Confirm delivery.

> Allowed from version `7.6.1`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Order status: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesCreateAndUpdateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest

try {
    $result = $apiInstance->api1DeliveriesConfirmPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesCreateAndUpdateApi->api1DeliveriesConfirmPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest**](../Model/IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest.md)|  | [optional] |

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

## `api1DeliveriesCreatePost()`

```php
api1DeliveriesCreatePost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_create_order_request): \IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderResponse
```

Create delivery.

> This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Orders: creating`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesCreateAndUpdateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_create_order_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderRequest

try {
    $result = $apiInstance->api1DeliveriesCreatePost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_create_order_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesCreateAndUpdateApi->api1DeliveriesCreatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_create_order_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestCreateOrderRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestCreateOrderRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesResponseOrderResponse**](../Model/IikoTransportPublicApiContractsDeliveriesResponseOrderResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1DeliveriesPrintDeliveryBillPost()`

```php
api1DeliveriesPrintDeliveryBillPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Print delivery bill.

> Allowed from version `7.6.1`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Orders: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesCreateAndUpdateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest

try {
    $result = $apiInstance->api1DeliveriesPrintDeliveryBillPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesCreateAndUpdateApi->api1DeliveriesPrintDeliveryBillPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest**](../Model/IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest.md)|  | [optional] |

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

## `api1DeliveriesUpdateOrderCourierPost()`

```php
api1DeliveriesUpdateOrderCourierPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_lock_or_unlock_draft_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Update order courier.

> Allowed from version `7.1.5`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Order driver: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesCreateAndUpdateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_drafts_lock_or_unlock_draft_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsLockOrUnlockDraftRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsLockOrUnlockDraftRequest

try {
    $result = $apiInstance->api1DeliveriesUpdateOrderCourierPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_lock_or_unlock_draft_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesCreateAndUpdateApi->api1DeliveriesUpdateOrderCourierPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_drafts_lock_or_unlock_draft_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsLockOrUnlockDraftRequest**](../Model/IikoTransportPublicApiContractsDeliveriesDraftsLockOrUnlockDraftRequest.md)|  | [optional] |

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

## `api1DeliveriesUpdateOrderDeliveryStatusPost()`

```php
api1DeliveriesUpdateOrderDeliveryStatusPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_delivery_status_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Update delivery status.

> This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Order status: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesCreateAndUpdateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_update_delivery_status_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateDeliveryStatusRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateDeliveryStatusRequest

try {
    $result = $apiInstance->api1DeliveriesUpdateOrderDeliveryStatusPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_delivery_status_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesCreateAndUpdateApi->api1DeliveriesUpdateOrderDeliveryStatusPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_update_delivery_status_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateDeliveryStatusRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateDeliveryStatusRequest.md)|  | [optional] |

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



$apiInstance = new IIKO\Api\DeliveriesCreateAndUpdateApi(
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
    echo 'Exception when calling DeliveriesCreateAndUpdateApi->api1DeliveriesUpdateOrderPaymentsPost: ', $e->getMessage(), PHP_EOL;
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

## `api1DeliveriesUpdateOrderProblemPost()`

```php
api1DeliveriesUpdateOrderProblemPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_order_problem_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Update order problem.

> This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Order status: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesCreateAndUpdateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_update_order_problem_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderProblemRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderProblemRequest

try {
    $result = $apiInstance->api1DeliveriesUpdateOrderProblemPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_order_problem_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesCreateAndUpdateApi->api1DeliveriesUpdateOrderProblemPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_update_order_problem_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderProblemRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateOrderProblemRequest.md)|  | [optional] |

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

## `api1DeliveriesUpdateTrackingLinkPost()`

```php
api1DeliveriesUpdateTrackingLinkPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_tracking_link_request)
```

Update tracking link of an order.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesCreateAndUpdateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_request_update_tracking_link_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateTrackingLinkRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateTrackingLinkRequest

try {
    $apiInstance->api1DeliveriesUpdateTrackingLinkPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_request_update_tracking_link_request);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesCreateAndUpdateApi->api1DeliveriesUpdateTrackingLinkPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_request_update_tracking_link_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesRequestUpdateTrackingLinkRequest**](../Model/IikoTransportPublicApiContractsDeliveriesRequestUpdateTrackingLinkRequest.md)|  | [optional] |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1OrderPrintBillPost()`

```php
api1OrderPrintBillPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Print bill.

> This method is a command. Use `api/1/commands/status` method to get the progress status.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DeliveriesCreateAndUpdateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request = new \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest(); // \IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest

try {
    $result = $apiInstance->api1OrderPrintBillPost($authorization, $timeout, $iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DeliveriesCreateAndUpdateApi->api1OrderPrintBillPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_deliveries_drafts_delete_draft_request** | [**\IIKO\Model\IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest**](../Model/IikoTransportPublicApiContractsDeliveriesDraftsDeleteDraftRequest.md)|  | [optional] |

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
