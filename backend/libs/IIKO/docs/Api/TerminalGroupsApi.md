# IIKO\TerminalGroupsApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**api1TerminalGroupsAwakePost()**](TerminalGroupsApi.md#api1TerminalGroupsAwakePost) | **POST** /api/1/terminal_groups/awake | Awake terminal groups from sleep mode. |
| [**api1TerminalGroupsIsAlivePost()**](TerminalGroupsApi.md#api1TerminalGroupsIsAlivePost) | **POST** /api/1/terminal_groups/is_alive | Returns information on availability of group of terminals. |
| [**api1TerminalGroupsPost()**](TerminalGroupsApi.md#api1TerminalGroupsPost) | **POST** /api/1/terminal_groups | Method that returns information on groups of delivery terminals. |


## `api1TerminalGroupsAwakePost()`

```php
api1TerminalGroupsAwakePost($authorization, $timeout, $iiko_transport_public_api_contracts_terminals_awake_terminal_groups_request): \IIKO\Model\IikoTransportPublicApiContractsTerminalsAwakeTerminalGroupsResponse
```

Awake terminal groups from sleep mode.

> Restriction group: `Organizations: settings`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\TerminalGroupsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_terminals_awake_terminal_groups_request = new \IIKO\Model\IikoTransportPublicApiContractsTerminalsAwakeTerminalGroupsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsTerminalsAwakeTerminalGroupsRequest

try {
    $result = $apiInstance->api1TerminalGroupsAwakePost($authorization, $timeout, $iiko_transport_public_api_contracts_terminals_awake_terminal_groups_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TerminalGroupsApi->api1TerminalGroupsAwakePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_terminals_awake_terminal_groups_request** | [**\IIKO\Model\IikoTransportPublicApiContractsTerminalsAwakeTerminalGroupsRequest**](../Model/IikoTransportPublicApiContractsTerminalsAwakeTerminalGroupsRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsTerminalsAwakeTerminalGroupsResponse**](../Model/IikoTransportPublicApiContractsTerminalsAwakeTerminalGroupsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1TerminalGroupsIsAlivePost()`

```php
api1TerminalGroupsIsAlivePost($authorization, $timeout, $iiko_transport_public_api_contracts_terminals_terminal_groups_is_alive_request): \IIKO\Model\IikoTransportPublicApiContractsTerminalsTerminalGroupsIsAliveResponse
```

Returns information on availability of group of terminals.

> Restriction group: `POS: availability`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\TerminalGroupsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_terminals_terminal_groups_is_alive_request = new \IIKO\Model\IikoTransportPublicApiContractsTerminalsTerminalGroupsIsAliveRequest(); // \IIKO\Model\IikoTransportPublicApiContractsTerminalsTerminalGroupsIsAliveRequest

try {
    $result = $apiInstance->api1TerminalGroupsIsAlivePost($authorization, $timeout, $iiko_transport_public_api_contracts_terminals_terminal_groups_is_alive_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TerminalGroupsApi->api1TerminalGroupsIsAlivePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_terminals_terminal_groups_is_alive_request** | [**\IIKO\Model\IikoTransportPublicApiContractsTerminalsTerminalGroupsIsAliveRequest**](../Model/IikoTransportPublicApiContractsTerminalsTerminalGroupsIsAliveRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsTerminalsTerminalGroupsIsAliveResponse**](../Model/IikoTransportPublicApiContractsTerminalsTerminalGroupsIsAliveResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1TerminalGroupsPost()`

```php
api1TerminalGroupsPost($authorization, $timeout, $iiko_transport_public_api_contracts_terminals_terminal_groups_request): \IIKO\Model\IikoTransportPublicApiContractsTerminalsTerminalGroupsResponse
```

Method that returns information on groups of delivery terminals.

> Restriction group: `Data: dictionaries`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\TerminalGroupsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_terminals_terminal_groups_request = new \IIKO\Model\IikoTransportPublicApiContractsTerminalsTerminalGroupsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsTerminalsTerminalGroupsRequest

try {
    $result = $apiInstance->api1TerminalGroupsPost($authorization, $timeout, $iiko_transport_public_api_contracts_terminals_terminal_groups_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TerminalGroupsApi->api1TerminalGroupsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_terminals_terminal_groups_request** | [**\IIKO\Model\IikoTransportPublicApiContractsTerminalsTerminalGroupsRequest**](../Model/IikoTransportPublicApiContractsTerminalsTerminalGroupsRequest.md)|  | [optional] |

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
