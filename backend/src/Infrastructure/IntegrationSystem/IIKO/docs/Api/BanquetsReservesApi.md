# IIKO\BanquetsReservesApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**api1ReserveAddItemsPost()**](BanquetsReservesApi.md#api1ReserveAddItemsPost) | **POST** /api/1/reserve/add_items | Add order items. |
| [**api1ReserveAddPaymentsPost()**](BanquetsReservesApi.md#api1ReserveAddPaymentsPost) | **POST** /api/1/reserve/add_payments | Add order payments. |
| [**api1ReserveAvailableOrganizationsPost()**](BanquetsReservesApi.md#api1ReserveAvailableOrganizationsPost) | **POST** /api/1/reserve/available_organizations | Returns all organizations of current account (determined by Authorization request header) for which banquet/reserve booking are available. |
| [**api1ReserveAvailableRestaurantSectionsPost()**](BanquetsReservesApi.md#api1ReserveAvailableRestaurantSectionsPost) | **POST** /api/1/reserve/available_restaurant_sections | Returns all restaurant sections of specified terminal groups, for which banquet/reserve booking are available. |
| [**api1ReserveAvailableTerminalGroupsPost()**](BanquetsReservesApi.md#api1ReserveAvailableTerminalGroupsPost) | **POST** /api/1/reserve/available_terminal_groups | Returns all terminal groups of specified organizations, for which banquet/reserve booking are available. |
| [**api1ReserveCancelPost()**](BanquetsReservesApi.md#api1ReserveCancelPost) | **POST** /api/1/reserve/cancel | Cancel reservation due to some reason. |
| [**api1ReserveChangeEstimatedStartTimePost()**](BanquetsReservesApi.md#api1ReserveChangeEstimatedStartTimePost) | **POST** /api/1/reserve/change_estimated_start_time | Change reserve/banquet estimated start time. |
| [**api1ReserveChangeItemsPost()**](BanquetsReservesApi.md#api1ReserveChangeItemsPost) | **POST** /api/1/reserve/change_items | Change order items. |
| [**api1ReserveChangeTablesPost()**](BanquetsReservesApi.md#api1ReserveChangeTablesPost) | **POST** /api/1/reserve/change_tables | Change reserve/banquet tables. |
| [**api1ReserveCreatePost()**](BanquetsReservesApi.md#api1ReserveCreatePost) | **POST** /api/1/reserve/create | Create banquet/reserve. |
| [**api1ReserveRestaurantSectionsWorkloadPost()**](BanquetsReservesApi.md#api1ReserveRestaurantSectionsWorkloadPost) | **POST** /api/1/reserve/restaurant_sections_workload | Returns all banquets/reserves for passed restaurant sections. |
| [**api1ReserveStatusByIdPost()**](BanquetsReservesApi.md#api1ReserveStatusByIdPost) | **POST** /api/1/reserve/status_by_id | Retrieve banquets/reserves statuses by IDs. |


## `api1ReserveAddItemsPost()`

```php
api1ReserveAddItemsPost($authorization, $timeout, $iiko_transport_public_api_contracts_reserves_add_order_items_to_banquet_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Add order items.

Available only for banquets.   > Allowed from version `8.2.6`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Orders: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\BanquetsReservesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_reserves_add_order_items_to_banquet_request = new \IIKO\Model\IikoTransportPublicApiContractsReservesAddOrderItemsToBanquetRequest(); // \IIKO\Model\IikoTransportPublicApiContractsReservesAddOrderItemsToBanquetRequest

try {
    $result = $apiInstance->api1ReserveAddItemsPost($authorization, $timeout, $iiko_transport_public_api_contracts_reserves_add_order_items_to_banquet_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BanquetsReservesApi->api1ReserveAddItemsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_reserves_add_order_items_to_banquet_request** | [**\IIKO\Model\IikoTransportPublicApiContractsReservesAddOrderItemsToBanquetRequest**](../Model/IikoTransportPublicApiContractsReservesAddOrderItemsToBanquetRequest.md)|  | [optional] |

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

## `api1ReserveAddPaymentsPost()`

```php
api1ReserveAddPaymentsPost($authorization, $timeout, $iiko_transport_public_api_contracts_reserves_add_order_payments_to_banquet_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Add order payments.

Available only for banquets.   > Allowed from version `8.2.6`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Order payments: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\BanquetsReservesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_reserves_add_order_payments_to_banquet_request = new \IIKO\Model\IikoTransportPublicApiContractsReservesAddOrderPaymentsToBanquetRequest(); // \IIKO\Model\IikoTransportPublicApiContractsReservesAddOrderPaymentsToBanquetRequest

try {
    $result = $apiInstance->api1ReserveAddPaymentsPost($authorization, $timeout, $iiko_transport_public_api_contracts_reserves_add_order_payments_to_banquet_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BanquetsReservesApi->api1ReserveAddPaymentsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_reserves_add_order_payments_to_banquet_request** | [**\IIKO\Model\IikoTransportPublicApiContractsReservesAddOrderPaymentsToBanquetRequest**](../Model/IikoTransportPublicApiContractsReservesAddOrderPaymentsToBanquetRequest.md)|  | [optional] |

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

## `api1ReserveAvailableOrganizationsPost()`

```php
api1ReserveAvailableOrganizationsPost($authorization, $timeout, $iiko_transport_public_api_contracts_organizations_get_organizations_request): \IIKO\Model\IikoTransportPublicApiContractsOrganizationsGetOrganizationsResponse
```

Returns all organizations of current account (determined by Authorization request header) for which banquet/reserve booking are available.

> Allowed from version `7.1.5`.   > Restriction group: `Orders: preparing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\BanquetsReservesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_organizations_get_organizations_request = new \IIKO\Model\IikoTransportPublicApiContractsOrganizationsGetOrganizationsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsOrganizationsGetOrganizationsRequest

try {
    $result = $apiInstance->api1ReserveAvailableOrganizationsPost($authorization, $timeout, $iiko_transport_public_api_contracts_organizations_get_organizations_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BanquetsReservesApi->api1ReserveAvailableOrganizationsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_organizations_get_organizations_request** | [**\IIKO\Model\IikoTransportPublicApiContractsOrganizationsGetOrganizationsRequest**](../Model/IikoTransportPublicApiContractsOrganizationsGetOrganizationsRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsOrganizationsGetOrganizationsResponse**](../Model/IikoTransportPublicApiContractsOrganizationsGetOrganizationsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1ReserveAvailableRestaurantSectionsPost()`

```php
api1ReserveAvailableRestaurantSectionsPost($authorization, $timeout, $iiko_transport_public_api_contracts_reserves_get_restaurant_sections_request): \IIKO\Model\IikoTransportPublicApiContractsReservesGetRestaurantSectionsResponse
```

Returns all restaurant sections of specified terminal groups, for which banquet/reserve booking are available.

> Allowed from version `7.1.5`.   > Restriction group: `Orders: preparing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\BanquetsReservesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_reserves_get_restaurant_sections_request = new \IIKO\Model\IikoTransportPublicApiContractsReservesGetRestaurantSectionsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsReservesGetRestaurantSectionsRequest

try {
    $result = $apiInstance->api1ReserveAvailableRestaurantSectionsPost($authorization, $timeout, $iiko_transport_public_api_contracts_reserves_get_restaurant_sections_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BanquetsReservesApi->api1ReserveAvailableRestaurantSectionsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_reserves_get_restaurant_sections_request** | [**\IIKO\Model\IikoTransportPublicApiContractsReservesGetRestaurantSectionsRequest**](../Model/IikoTransportPublicApiContractsReservesGetRestaurantSectionsRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsReservesGetRestaurantSectionsResponse**](../Model/IikoTransportPublicApiContractsReservesGetRestaurantSectionsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1ReserveAvailableTerminalGroupsPost()`

```php
api1ReserveAvailableTerminalGroupsPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_regions_request): \IIKO\Model\IikoTransportPublicApiContractsTerminalsTerminalGroupsResponse
```

Returns all terminal groups of specified organizations, for which banquet/reserve booking are available.

> Allowed from version `7.1.5`.   > Restriction group: `Orders: preparing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\BanquetsReservesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_address_regions_request = new \IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest

try {
    $result = $apiInstance->api1ReserveAvailableTerminalGroupsPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_regions_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BanquetsReservesApi->api1ReserveAvailableTerminalGroupsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_address_regions_request** | [**\IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest**](../Model/IikoTransportPublicApiContractsAddressRegionsRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsTerminalsTerminalGroupsResponse**](../Model/IikoTransportPublicApiContractsTerminalsTerminalGroupsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1ReserveCancelPost()`

```php
api1ReserveCancelPost($authorization, $timeout, $iiko_transport_public_api_contracts_reserves_cancel_reserve_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Cancel reservation due to some reason.

Available only for reserves with status 'New'.   > Allowed from version `8.2.6`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Order status: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\BanquetsReservesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_reserves_cancel_reserve_request = new \IIKO\Model\IikoTransportPublicApiContractsReservesCancelReserveRequest(); // \IIKO\Model\IikoTransportPublicApiContractsReservesCancelReserveRequest

try {
    $result = $apiInstance->api1ReserveCancelPost($authorization, $timeout, $iiko_transport_public_api_contracts_reserves_cancel_reserve_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BanquetsReservesApi->api1ReserveCancelPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_reserves_cancel_reserve_request** | [**\IIKO\Model\IikoTransportPublicApiContractsReservesCancelReserveRequest**](../Model/IikoTransportPublicApiContractsReservesCancelReserveRequest.md)|  | [optional] |

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

## `api1ReserveChangeEstimatedStartTimePost()`

```php
api1ReserveChangeEstimatedStartTimePost($authorization, $timeout, $iiko_transport_public_api_contracts_reserves_change_reserve_estimated_start_time_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Change reserve/banquet estimated start time.

> Allowed from version `9.0.5`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\BanquetsReservesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_reserves_change_reserve_estimated_start_time_request = new \IIKO\Model\IikoTransportPublicApiContractsReservesChangeReserveEstimatedStartTimeRequest(); // \IIKO\Model\IikoTransportPublicApiContractsReservesChangeReserveEstimatedStartTimeRequest

try {
    $result = $apiInstance->api1ReserveChangeEstimatedStartTimePost($authorization, $timeout, $iiko_transport_public_api_contracts_reserves_change_reserve_estimated_start_time_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BanquetsReservesApi->api1ReserveChangeEstimatedStartTimePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_reserves_change_reserve_estimated_start_time_request** | [**\IIKO\Model\IikoTransportPublicApiContractsReservesChangeReserveEstimatedStartTimeRequest**](../Model/IikoTransportPublicApiContractsReservesChangeReserveEstimatedStartTimeRequest.md)|  | [optional] |

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

## `api1ReserveChangeItemsPost()`

```php
api1ReserveChangeItemsPost($authorization, $timeout, $iiko_transport_public_api_contracts_reserves_change_banquet_order_items_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Change order items.

Available only for banquets.   > Allowed from version `9.0.5`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\BanquetsReservesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_reserves_change_banquet_order_items_request = new \IIKO\Model\IikoTransportPublicApiContractsReservesChangeBanquetOrderItemsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsReservesChangeBanquetOrderItemsRequest

try {
    $result = $apiInstance->api1ReserveChangeItemsPost($authorization, $timeout, $iiko_transport_public_api_contracts_reserves_change_banquet_order_items_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BanquetsReservesApi->api1ReserveChangeItemsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_reserves_change_banquet_order_items_request** | [**\IIKO\Model\IikoTransportPublicApiContractsReservesChangeBanquetOrderItemsRequest**](../Model/IikoTransportPublicApiContractsReservesChangeBanquetOrderItemsRequest.md)|  | [optional] |

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

## `api1ReserveChangeTablesPost()`

```php
api1ReserveChangeTablesPost($authorization, $timeout, $iiko_transport_public_api_contracts_reserves_change_reserve_tables_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Change reserve/banquet tables.

> Allowed from version `9.0.5`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\BanquetsReservesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_reserves_change_reserve_tables_request = new \IIKO\Model\IikoTransportPublicApiContractsReservesChangeReserveTablesRequest(); // \IIKO\Model\IikoTransportPublicApiContractsReservesChangeReserveTablesRequest

try {
    $result = $apiInstance->api1ReserveChangeTablesPost($authorization, $timeout, $iiko_transport_public_api_contracts_reserves_change_reserve_tables_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BanquetsReservesApi->api1ReserveChangeTablesPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_reserves_change_reserve_tables_request** | [**\IIKO\Model\IikoTransportPublicApiContractsReservesChangeReserveTablesRequest**](../Model/IikoTransportPublicApiContractsReservesChangeReserveTablesRequest.md)|  | [optional] |

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

## `api1ReserveCreatePost()`

```php
api1ReserveCreatePost($authorization, $timeout, $iiko_transport_public_api_contracts_reserves_create_reserve_request): \IIKO\Model\IikoTransportPublicApiContractsReservesReserveResponse
```

Create banquet/reserve.

> Allowed from version `7.1.5`.   > This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Orders: creating`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\BanquetsReservesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_reserves_create_reserve_request = new \IIKO\Model\IikoTransportPublicApiContractsReservesCreateReserveRequest(); // \IIKO\Model\IikoTransportPublicApiContractsReservesCreateReserveRequest

try {
    $result = $apiInstance->api1ReserveCreatePost($authorization, $timeout, $iiko_transport_public_api_contracts_reserves_create_reserve_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BanquetsReservesApi->api1ReserveCreatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_reserves_create_reserve_request** | [**\IIKO\Model\IikoTransportPublicApiContractsReservesCreateReserveRequest**](../Model/IikoTransportPublicApiContractsReservesCreateReserveRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsReservesReserveResponse**](../Model/IikoTransportPublicApiContractsReservesReserveResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1ReserveRestaurantSectionsWorkloadPost()`

```php
api1ReserveRestaurantSectionsWorkloadPost($authorization, $timeout, $iiko_transport_public_api_contracts_reserves_get_restaurant_sections_workload_request): \IIKO\Model\IikoTransportPublicApiContractsReservesGetRestaurantSectionsWorkloadResponse
```

Returns all banquets/reserves for passed restaurant sections.

> Allowed from version `7.1.5`.   > Restriction group: `Data: dictionaries`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\BanquetsReservesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_reserves_get_restaurant_sections_workload_request = new \IIKO\Model\IikoTransportPublicApiContractsReservesGetRestaurantSectionsWorkloadRequest(); // \IIKO\Model\IikoTransportPublicApiContractsReservesGetRestaurantSectionsWorkloadRequest

try {
    $result = $apiInstance->api1ReserveRestaurantSectionsWorkloadPost($authorization, $timeout, $iiko_transport_public_api_contracts_reserves_get_restaurant_sections_workload_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BanquetsReservesApi->api1ReserveRestaurantSectionsWorkloadPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_reserves_get_restaurant_sections_workload_request** | [**\IIKO\Model\IikoTransportPublicApiContractsReservesGetRestaurantSectionsWorkloadRequest**](../Model/IikoTransportPublicApiContractsReservesGetRestaurantSectionsWorkloadRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsReservesGetRestaurantSectionsWorkloadResponse**](../Model/IikoTransportPublicApiContractsReservesGetRestaurantSectionsWorkloadResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1ReserveStatusByIdPost()`

```php
api1ReserveStatusByIdPost($authorization, $timeout, $iiko_transport_public_api_contracts_reserves_reserves_by_id_request): \IIKO\Model\IikoTransportPublicApiContractsReservesReservesResponse
```

Retrieve banquets/reserves statuses by IDs.

> Allowed from version `7.1.5`.   > Restriction group: `Orders: receiving`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\BanquetsReservesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_reserves_reserves_by_id_request = new \IIKO\Model\IikoTransportPublicApiContractsReservesReservesByIdRequest(); // \IIKO\Model\IikoTransportPublicApiContractsReservesReservesByIdRequest

try {
    $result = $apiInstance->api1ReserveStatusByIdPost($authorization, $timeout, $iiko_transport_public_api_contracts_reserves_reserves_by_id_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling BanquetsReservesApi->api1ReserveStatusByIdPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_reserves_reserves_by_id_request** | [**\IIKO\Model\IikoTransportPublicApiContractsReservesReservesByIdRequest**](../Model/IikoTransportPublicApiContractsReservesReservesByIdRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsReservesReservesResponse**](../Model/IikoTransportPublicApiContractsReservesReservesResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
