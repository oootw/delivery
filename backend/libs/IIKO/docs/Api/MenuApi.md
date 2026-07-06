# IIKO\MenuApi

Menu API.

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**api1ComboCalculatePost()**](MenuApi.md#api1ComboCalculatePost) | **POST** /api/1/combo/calculate | Calculate combo price |
| [**api1ComboPost()**](MenuApi.md#api1ComboPost) | **POST** /api/1/combo | Get combos info |
| [**api1NomenclaturePost()**](MenuApi.md#api1NomenclaturePost) | **POST** /api/1/nomenclature | Menu. |
| [**api1StopListsAddPost()**](MenuApi.md#api1StopListsAddPost) | **POST** /api/1/stop_lists/add | Add items to out-of-stock list.  (You should have extra rights to use this method). |
| [**api1StopListsCheckPost()**](MenuApi.md#api1StopListsCheckPost) | **POST** /api/1/stop_lists/check | Check items in out-of-stock list. |
| [**api1StopListsClearPost()**](MenuApi.md#api1StopListsClearPost) | **POST** /api/1/stop_lists/clear | Clear out-of-stock list.  (You should have extra rights to use this method). |
| [**api1StopListsPost()**](MenuApi.md#api1StopListsPost) | **POST** /api/1/stop_lists | Out-of-stock items. |
| [**api1StopListsRemovePost()**](MenuApi.md#api1StopListsRemovePost) | **POST** /api/1/stop_lists/remove | Remove items from out-of-stock list.  (You should have extra rights to use this method). |
| [**api2MenuByIdPost()**](MenuApi.md#api2MenuByIdPost) | **POST** /api/2/menu/by_id | Retrieve external menu by ID. |
| [**api2MenuPost()**](MenuApi.md#api2MenuPost) | **POST** /api/2/menu | External menus with price categories. |


## `api1ComboCalculatePost()`

```php
api1ComboCalculatePost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_loyalty_result_calculate_combo_price_request): \IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultCalculateComboPriceResponse
```

Calculate combo price

Make combo price calculation.   > Restriction group: `Loyalty: order calculate`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\MenuApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_loyalty_result_calculate_combo_price_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultCalculateComboPriceRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultCalculateComboPriceRequest

try {
    $result = $apiInstance->api1ComboCalculatePost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_loyalty_result_calculate_combo_price_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MenuApi->api1ComboCalculatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_loyalty_result_calculate_combo_price_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultCalculateComboPriceRequest**](../Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultCalculateComboPriceRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultCalculateComboPriceResponse**](../Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultCalculateComboPriceResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1ComboPost()`

```php
api1ComboPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_loyalty_result_get_combos_info_request): \IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultGetCombosInfoResponse
```

Get combos info

Get all organization's combos.   > Restriction group: `Data: menu`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\MenuApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_loyalty_result_get_combos_info_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultGetCombosInfoRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultGetCombosInfoRequest

try {
    $result = $apiInstance->api1ComboPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_loyalty_result_get_combos_info_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MenuApi->api1ComboPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_loyalty_result_get_combos_info_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultGetCombosInfoRequest**](../Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultGetCombosInfoRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultGetCombosInfoResponse**](../Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultGetCombosInfoResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1NomenclaturePost()`

```php
api1NomenclaturePost($authorization, $timeout, $iiko_transport_public_api_contracts_nomenclature_nomenclature_request): \IIKO\Model\IikoTransportPublicApiContractsNomenclatureNomenclatureResponse
```

Menu.

> Sourced from RMS Data Exchange Export menu.   > Restriction group: `Data: menu`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\MenuApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_nomenclature_nomenclature_request = new \IIKO\Model\IikoTransportPublicApiContractsNomenclatureNomenclatureRequest(); // \IIKO\Model\IikoTransportPublicApiContractsNomenclatureNomenclatureRequest

try {
    $result = $apiInstance->api1NomenclaturePost($authorization, $timeout, $iiko_transport_public_api_contracts_nomenclature_nomenclature_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MenuApi->api1NomenclaturePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_nomenclature_nomenclature_request** | [**\IIKO\Model\IikoTransportPublicApiContractsNomenclatureNomenclatureRequest**](../Model/IikoTransportPublicApiContractsNomenclatureNomenclatureRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsNomenclatureNomenclatureResponse**](../Model/IikoTransportPublicApiContractsNomenclatureNomenclatureResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1StopListsAddPost()`

```php
api1StopListsAddPost($authorization, $timeout, $iiko_transport_public_api_contracts_stop_lists_add_products_to_stop_list_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Add items to out-of-stock list.  (You should have extra rights to use this method).

> Allowed from version `8.6.1`.   > Restriction group: `Data: changing stoplists`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\MenuApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_stop_lists_add_products_to_stop_list_request = new \IIKO\Model\IikoTransportPublicApiContractsStopListsAddProductsToStopListRequest(); // \IIKO\Model\IikoTransportPublicApiContractsStopListsAddProductsToStopListRequest

try {
    $result = $apiInstance->api1StopListsAddPost($authorization, $timeout, $iiko_transport_public_api_contracts_stop_lists_add_products_to_stop_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MenuApi->api1StopListsAddPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_stop_lists_add_products_to_stop_list_request** | [**\IIKO\Model\IikoTransportPublicApiContractsStopListsAddProductsToStopListRequest**](../Model/IikoTransportPublicApiContractsStopListsAddProductsToStopListRequest.md)|  | [optional] |

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

## `api1StopListsCheckPost()`

```php
api1StopListsCheckPost($authorization, $timeout, $iiko_transport_public_api_contracts_stop_lists_check_stop_list_request): \IIKO\Model\IikoTransportPublicApiContractsStopListsCheckStopListResponse
```

Check items in out-of-stock list.

> Restriction group: `Orders: creating`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\MenuApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_stop_lists_check_stop_list_request = new \IIKO\Model\IikoTransportPublicApiContractsStopListsCheckStopListRequest(); // \IIKO\Model\IikoTransportPublicApiContractsStopListsCheckStopListRequest

try {
    $result = $apiInstance->api1StopListsCheckPost($authorization, $timeout, $iiko_transport_public_api_contracts_stop_lists_check_stop_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MenuApi->api1StopListsCheckPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_stop_lists_check_stop_list_request** | [**\IIKO\Model\IikoTransportPublicApiContractsStopListsCheckStopListRequest**](../Model/IikoTransportPublicApiContractsStopListsCheckStopListRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsStopListsCheckStopListResponse**](../Model/IikoTransportPublicApiContractsStopListsCheckStopListResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1StopListsClearPost()`

```php
api1StopListsClearPost($authorization, $timeout, $iiko_transport_public_api_contracts_employees_active_courier_locations_by_terminal_group_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Clear out-of-stock list.  (You should have extra rights to use this method).

> Allowed from version `8.6.1`.   > Restriction group: `Data: changing stoplists`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\MenuApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_employees_active_courier_locations_by_terminal_group_request = new \IIKO\Model\IikoTransportPublicApiContractsEmployeesActiveCourierLocationsByTerminalGroupRequest(); // \IIKO\Model\IikoTransportPublicApiContractsEmployeesActiveCourierLocationsByTerminalGroupRequest

try {
    $result = $apiInstance->api1StopListsClearPost($authorization, $timeout, $iiko_transport_public_api_contracts_employees_active_courier_locations_by_terminal_group_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MenuApi->api1StopListsClearPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_employees_active_courier_locations_by_terminal_group_request** | [**\IIKO\Model\IikoTransportPublicApiContractsEmployeesActiveCourierLocationsByTerminalGroupRequest**](../Model/IikoTransportPublicApiContractsEmployeesActiveCourierLocationsByTerminalGroupRequest.md)|  | [optional] |

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

## `api1StopListsPost()`

```php
api1StopListsPost($authorization, $timeout, $iiko_transport_public_api_contracts_stop_lists_stop_lists_request): \IIKO\Model\IikoTransportPublicApiContractsStopListsStopListsResponse
```

Out-of-stock items.

> Restriction group: `Data: stoplists`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\MenuApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_stop_lists_stop_lists_request = new \IIKO\Model\IikoTransportPublicApiContractsStopListsStopListsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsStopListsStopListsRequest

try {
    $result = $apiInstance->api1StopListsPost($authorization, $timeout, $iiko_transport_public_api_contracts_stop_lists_stop_lists_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MenuApi->api1StopListsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_stop_lists_stop_lists_request** | [**\IIKO\Model\IikoTransportPublicApiContractsStopListsStopListsRequest**](../Model/IikoTransportPublicApiContractsStopListsStopListsRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsStopListsStopListsResponse**](../Model/IikoTransportPublicApiContractsStopListsStopListsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1StopListsRemovePost()`

```php
api1StopListsRemovePost($authorization, $timeout, $iiko_transport_public_api_contracts_stop_lists_remove_products_from_stop_list_request): \IIKO\Model\IikoTransportPublicApiContractsCommonCorrelationIdResponse
```

Remove items from out-of-stock list.  (You should have extra rights to use this method).

> Allowed from version `8.6.1`.   > Restriction group: `Data: changing stoplists`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\MenuApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_stop_lists_remove_products_from_stop_list_request = new \IIKO\Model\IikoTransportPublicApiContractsStopListsRemoveProductsFromStopListRequest(); // \IIKO\Model\IikoTransportPublicApiContractsStopListsRemoveProductsFromStopListRequest

try {
    $result = $apiInstance->api1StopListsRemovePost($authorization, $timeout, $iiko_transport_public_api_contracts_stop_lists_remove_products_from_stop_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MenuApi->api1StopListsRemovePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_stop_lists_remove_products_from_stop_list_request** | [**\IIKO\Model\IikoTransportPublicApiContractsStopListsRemoveProductsFromStopListRequest**](../Model/IikoTransportPublicApiContractsStopListsRemoveProductsFromStopListRequest.md)|  | [optional] |

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

## `api2MenuByIdPost()`

```php
api2MenuByIdPost($authorization, $timeout, $iiko_transport_public_api_contracts_nomenclature_menu_request): \IIKO\Model\Api2MenuByIdPost200Response
```

Retrieve external menu by ID.

> Sourced from Web External menu.   > Restriction group: `Data: menu`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\MenuApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_nomenclature_menu_request = {"externalMenuId":"15#3","organizationIds":["706e5f4a-3efa-49f0-8f1c-15a6c1603e1f"],"version":2}; // \IIKO\Model\IikoTransportPublicApiContractsNomenclatureMenuRequest

try {
    $result = $apiInstance->api2MenuByIdPost($authorization, $timeout, $iiko_transport_public_api_contracts_nomenclature_menu_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MenuApi->api2MenuByIdPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_nomenclature_menu_request** | [**\IIKO\Model\IikoTransportPublicApiContractsNomenclatureMenuRequest**](../Model/IikoTransportPublicApiContractsNomenclatureMenuRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\Api2MenuByIdPost200Response**](../Model/Api2MenuByIdPost200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api2MenuPost()`

```php
api2MenuPost($authorization, $timeout): \IIKO\Model\IikoTransportPublicApiContractsNomenclatureMenusDataResponse
```

External menus with price categories.

> Restriction group: `Data: menu`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\MenuApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.

try {
    $result = $apiInstance->api2MenuPost($authorization, $timeout);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MenuApi->api2MenuPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsNomenclatureMenusDataResponse**](../Model/IikoTransportPublicApiContractsNomenclatureMenusDataResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
