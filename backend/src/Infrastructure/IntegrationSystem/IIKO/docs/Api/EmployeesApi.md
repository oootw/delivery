# IIKO\EmployeesApi

Employees API.

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**api1EmployeesCouriersActiveLocationByTerminalPost()**](EmployeesApi.md#api1EmployeesCouriersActiveLocationByTerminalPost) | **POST** /api/1/employees/couriers/active_location/by_terminal | Returns list of all active (courier session is opened) courier&#39;s locations which are delivery drivers in specified   restaurant and are clocked in on specified delivery terminal. |
| [**api1EmployeesCouriersActiveLocationPost()**](EmployeesApi.md#api1EmployeesCouriersActiveLocationPost) | **POST** /api/1/employees/couriers/active_location | Returns list of all active (courier session is opened) courier&#39;s locations which are delivery drivers   in specified restaurants. |
| [**api1EmployeesCouriersByRolePost()**](EmployeesApi.md#api1EmployeesCouriersByRolePost) | **POST** /api/1/employees/couriers/by_role | Returns list of all employees which are delivery drivers in specified restaurants,   and checks whether each employee has passed role. |
| [**api1EmployeesCouriersLocationsByTimeOffsetPost()**](EmployeesApi.md#api1EmployeesCouriersLocationsByTimeOffsetPost) | **POST** /api/1/employees/couriers/locations/by_time_offset | Method of obtaining drivers&#39; coordinates history. |
| [**api1EmployeesCouriersPost()**](EmployeesApi.md#api1EmployeesCouriersPost) | **POST** /api/1/employees/couriers | Returns list of all employees which are delivery drivers in specified restaurants. |
| [**api1EmployeesInfoPost()**](EmployeesApi.md#api1EmployeesInfoPost) | **POST** /api/1/employees/info | Returns employee info. |
| [**api1EmployeesShiftClockinPost()**](EmployeesApi.md#api1EmployeesShiftClockinPost) | **POST** /api/1/employees/shift/clockin | Open personal session. |
| [**api1EmployeesShiftClockoutPost()**](EmployeesApi.md#api1EmployeesShiftClockoutPost) | **POST** /api/1/employees/shift/clockout | Close personal session. |
| [**api1EmployeesShiftIsOpenPost()**](EmployeesApi.md#api1EmployeesShiftIsOpenPost) | **POST** /api/1/employees/shift/is_open | Check if personal session is open. |
| [**api1EmployeesShiftsByCourierPost()**](EmployeesApi.md#api1EmployeesShiftsByCourierPost) | **POST** /api/1/employees/shifts/by_courier | Get terminal groups where employee session is opened. |


## `api1EmployeesCouriersActiveLocationByTerminalPost()`

```php
api1EmployeesCouriersActiveLocationByTerminalPost($authorization, $timeout, $iiko_transport_public_api_contracts_employees_active_courier_locations_by_terminal_group_request): \IIKO\Model\IikoTransportPublicApiContractsEmployeesActiveCourierLocationsResponse
```

Returns list of all active (courier session is opened) courier's locations which are delivery drivers in specified   restaurant and are clocked in on specified delivery terminal.

> Restriction group: `Drivers: location`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\EmployeesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_employees_active_courier_locations_by_terminal_group_request = new \IIKO\Model\IikoTransportPublicApiContractsEmployeesActiveCourierLocationsByTerminalGroupRequest(); // \IIKO\Model\IikoTransportPublicApiContractsEmployeesActiveCourierLocationsByTerminalGroupRequest

try {
    $result = $apiInstance->api1EmployeesCouriersActiveLocationByTerminalPost($authorization, $timeout, $iiko_transport_public_api_contracts_employees_active_courier_locations_by_terminal_group_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EmployeesApi->api1EmployeesCouriersActiveLocationByTerminalPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_employees_active_courier_locations_by_terminal_group_request** | [**\IIKO\Model\IikoTransportPublicApiContractsEmployeesActiveCourierLocationsByTerminalGroupRequest**](../Model/IikoTransportPublicApiContractsEmployeesActiveCourierLocationsByTerminalGroupRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsEmployeesActiveCourierLocationsResponse**](../Model/IikoTransportPublicApiContractsEmployeesActiveCourierLocationsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1EmployeesCouriersActiveLocationPost()`

```php
api1EmployeesCouriersActiveLocationPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_regions_request): \IIKO\Model\IikoTransportPublicApiContractsEmployeesActiveCourierLocationsResponse
```

Returns list of all active (courier session is opened) courier's locations which are delivery drivers   in specified restaurants.

> Restriction group: `Drivers: location`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\EmployeesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_address_regions_request = new \IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest

try {
    $result = $apiInstance->api1EmployeesCouriersActiveLocationPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_regions_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EmployeesApi->api1EmployeesCouriersActiveLocationPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_address_regions_request** | [**\IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest**](../Model/IikoTransportPublicApiContractsAddressRegionsRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsEmployeesActiveCourierLocationsResponse**](../Model/IikoTransportPublicApiContractsEmployeesActiveCourierLocationsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1EmployeesCouriersByRolePost()`

```php
api1EmployeesCouriersByRolePost($authorization, $timeout, $iiko_transport_public_api_contracts_employees_couriers_and_check_role_request): \IIKO\Model\IikoTransportPublicApiContractsEmployeesEmployeesWithRoleSignResponse
```

Returns list of all employees which are delivery drivers in specified restaurants,   and checks whether each employee has passed role.

> Restriction group: `Drivers: dictionaries`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\EmployeesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_employees_couriers_and_check_role_request = new \IIKO\Model\IikoTransportPublicApiContractsEmployeesCouriersAndCheckRoleRequest(); // \IIKO\Model\IikoTransportPublicApiContractsEmployeesCouriersAndCheckRoleRequest

try {
    $result = $apiInstance->api1EmployeesCouriersByRolePost($authorization, $timeout, $iiko_transport_public_api_contracts_employees_couriers_and_check_role_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EmployeesApi->api1EmployeesCouriersByRolePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_employees_couriers_and_check_role_request** | [**\IIKO\Model\IikoTransportPublicApiContractsEmployeesCouriersAndCheckRoleRequest**](../Model/IikoTransportPublicApiContractsEmployeesCouriersAndCheckRoleRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsEmployeesEmployeesWithRoleSignResponse**](../Model/IikoTransportPublicApiContractsEmployeesEmployeesWithRoleSignResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1EmployeesCouriersLocationsByTimeOffsetPost()`

```php
api1EmployeesCouriersLocationsByTimeOffsetPost($authorization, $timeout, $iiko_transport_public_api_contracts_employees_courier_locations_by_time_offset_request): \IIKO\Model\IikoTransportPublicApiContractsEmployeesCourierLocationsByTimeOffsetResponse
```

Method of obtaining drivers' coordinates history.

> Restriction group: `Drivers: location`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\EmployeesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_employees_courier_locations_by_time_offset_request = new \IIKO\Model\IikoTransportPublicApiContractsEmployeesCourierLocationsByTimeOffsetRequest(); // \IIKO\Model\IikoTransportPublicApiContractsEmployeesCourierLocationsByTimeOffsetRequest

try {
    $result = $apiInstance->api1EmployeesCouriersLocationsByTimeOffsetPost($authorization, $timeout, $iiko_transport_public_api_contracts_employees_courier_locations_by_time_offset_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EmployeesApi->api1EmployeesCouriersLocationsByTimeOffsetPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_employees_courier_locations_by_time_offset_request** | [**\IIKO\Model\IikoTransportPublicApiContractsEmployeesCourierLocationsByTimeOffsetRequest**](../Model/IikoTransportPublicApiContractsEmployeesCourierLocationsByTimeOffsetRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsEmployeesCourierLocationsByTimeOffsetResponse**](../Model/IikoTransportPublicApiContractsEmployeesCourierLocationsByTimeOffsetResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1EmployeesCouriersPost()`

```php
api1EmployeesCouriersPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_regions_request): \IIKO\Model\IikoTransportPublicApiContractsEmployeesEmployeesResponse
```

Returns list of all employees which are delivery drivers in specified restaurants.

> Restriction group: `Drivers: dictionaries`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\EmployeesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_address_regions_request = new \IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest

try {
    $result = $apiInstance->api1EmployeesCouriersPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_regions_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EmployeesApi->api1EmployeesCouriersPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_address_regions_request** | [**\IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest**](../Model/IikoTransportPublicApiContractsAddressRegionsRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsEmployeesEmployeesResponse**](../Model/IikoTransportPublicApiContractsEmployeesEmployeesResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1EmployeesInfoPost()`

```php
api1EmployeesInfoPost($authorization, $timeout, $iiko_transport_public_api_contracts_employees_employee_info_request): \IIKO\Model\IikoTransportPublicApiContractsEmployeesEmployeeInfoResponse
```

Returns employee info.

> Restriction group: `Employees: dictionaries`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\EmployeesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_employees_employee_info_request = new \IIKO\Model\IikoTransportPublicApiContractsEmployeesEmployeeInfoRequest(); // \IIKO\Model\IikoTransportPublicApiContractsEmployeesEmployeeInfoRequest

try {
    $result = $apiInstance->api1EmployeesInfoPost($authorization, $timeout, $iiko_transport_public_api_contracts_employees_employee_info_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EmployeesApi->api1EmployeesInfoPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_employees_employee_info_request** | [**\IIKO\Model\IikoTransportPublicApiContractsEmployeesEmployeeInfoRequest**](../Model/IikoTransportPublicApiContractsEmployeesEmployeeInfoRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsEmployeesEmployeeInfoResponse**](../Model/IikoTransportPublicApiContractsEmployeesEmployeeInfoResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1EmployeesShiftClockinPost()`

```php
api1EmployeesShiftClockinPost($authorization, $timeout, $iiko_transport_public_api_contracts_employees_open_personal_session_request): \IIKO\Model\IikoTransportPublicApiContractsEmployeesChangePersonalSessionResponse
```

Open personal session.

> This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Employees: shifts`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\EmployeesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_employees_open_personal_session_request = new \IIKO\Model\IikoTransportPublicApiContractsEmployeesOpenPersonalSessionRequest(); // \IIKO\Model\IikoTransportPublicApiContractsEmployeesOpenPersonalSessionRequest

try {
    $result = $apiInstance->api1EmployeesShiftClockinPost($authorization, $timeout, $iiko_transport_public_api_contracts_employees_open_personal_session_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EmployeesApi->api1EmployeesShiftClockinPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_employees_open_personal_session_request** | [**\IIKO\Model\IikoTransportPublicApiContractsEmployeesOpenPersonalSessionRequest**](../Model/IikoTransportPublicApiContractsEmployeesOpenPersonalSessionRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsEmployeesChangePersonalSessionResponse**](../Model/IikoTransportPublicApiContractsEmployeesChangePersonalSessionResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1EmployeesShiftClockoutPost()`

```php
api1EmployeesShiftClockoutPost($authorization, $timeout, $iiko_transport_public_api_contracts_employees_close_personal_session_request): \IIKO\Model\IikoTransportPublicApiContractsEmployeesChangePersonalSessionResponse
```

Close personal session.

> This method is a command. Use `api/1/commands/status` method to get the progress status.   > Restriction group: `Employees: shifts`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\EmployeesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_employees_close_personal_session_request = new \IIKO\Model\IikoTransportPublicApiContractsEmployeesClosePersonalSessionRequest(); // \IIKO\Model\IikoTransportPublicApiContractsEmployeesClosePersonalSessionRequest

try {
    $result = $apiInstance->api1EmployeesShiftClockoutPost($authorization, $timeout, $iiko_transport_public_api_contracts_employees_close_personal_session_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EmployeesApi->api1EmployeesShiftClockoutPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_employees_close_personal_session_request** | [**\IIKO\Model\IikoTransportPublicApiContractsEmployeesClosePersonalSessionRequest**](../Model/IikoTransportPublicApiContractsEmployeesClosePersonalSessionRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsEmployeesChangePersonalSessionResponse**](../Model/IikoTransportPublicApiContractsEmployeesChangePersonalSessionResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1EmployeesShiftIsOpenPost()`

```php
api1EmployeesShiftIsOpenPost($authorization, $timeout, $iiko_transport_public_api_contracts_employees_close_personal_session_request): \IIKO\Model\IikoTransportPublicApiContractsEmployeesGetPersonalSessionInfoResponse
```

Check if personal session is open.

> Restriction group: `Employees: shifts`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\EmployeesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_employees_close_personal_session_request = new \IIKO\Model\IikoTransportPublicApiContractsEmployeesClosePersonalSessionRequest(); // \IIKO\Model\IikoTransportPublicApiContractsEmployeesClosePersonalSessionRequest

try {
    $result = $apiInstance->api1EmployeesShiftIsOpenPost($authorization, $timeout, $iiko_transport_public_api_contracts_employees_close_personal_session_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EmployeesApi->api1EmployeesShiftIsOpenPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_employees_close_personal_session_request** | [**\IIKO\Model\IikoTransportPublicApiContractsEmployeesClosePersonalSessionRequest**](../Model/IikoTransportPublicApiContractsEmployeesClosePersonalSessionRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsEmployeesGetPersonalSessionInfoResponse**](../Model/IikoTransportPublicApiContractsEmployeesGetPersonalSessionInfoResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1EmployeesShiftsByCourierPost()`

```php
api1EmployeesShiftsByCourierPost($authorization, $timeout, $iiko_transport_public_api_contracts_employees_get_terminal_groups_of_employee_request): \IIKO\Model\IikoTransportPublicApiContractsEmployeesGetTerminalGroupsOfEmployeeResponse
```

Get terminal groups where employee session is opened.

> Restriction group: `Employees: shifts`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\EmployeesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_employees_get_terminal_groups_of_employee_request = new \IIKO\Model\IikoTransportPublicApiContractsEmployeesGetTerminalGroupsOfEmployeeRequest(); // \IIKO\Model\IikoTransportPublicApiContractsEmployeesGetTerminalGroupsOfEmployeeRequest

try {
    $result = $apiInstance->api1EmployeesShiftsByCourierPost($authorization, $timeout, $iiko_transport_public_api_contracts_employees_get_terminal_groups_of_employee_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EmployeesApi->api1EmployeesShiftsByCourierPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_employees_get_terminal_groups_of_employee_request** | [**\IIKO\Model\IikoTransportPublicApiContractsEmployeesGetTerminalGroupsOfEmployeeRequest**](../Model/IikoTransportPublicApiContractsEmployeesGetTerminalGroupsOfEmployeeRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsEmployeesGetTerminalGroupsOfEmployeeResponse**](../Model/IikoTransportPublicApiContractsEmployeesGetTerminalGroupsOfEmployeeResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
