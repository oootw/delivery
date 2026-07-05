# IIKO\OperationsApi

Operations API.

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**api1CommandsStatusPost()**](OperationsApi.md#api1CommandsStatusPost) | **POST** /api/1/commands/status | Get status of command. |


## `api1CommandsStatusPost()`

```php
api1CommandsStatusPost($authorization, $timeout, $iiko_transport_public_api_contracts_commands_get_command_status_request): \IIKO\Model\IikoTransportPublicApiContractsCommandsGetCommandStatusResponse
```

Get status of command.

> Response code `410` means that the correlationId value specified in the method is no longer supported.  Please do not request methods that include such a value.   > Restriction group: `Commands`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\OperationsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_commands_get_command_status_request = new \IIKO\Model\IikoTransportPublicApiContractsCommandsGetCommandStatusRequest(); // \IIKO\Model\IikoTransportPublicApiContractsCommandsGetCommandStatusRequest

try {
    $result = $apiInstance->api1CommandsStatusPost($authorization, $timeout, $iiko_transport_public_api_contracts_commands_get_command_status_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OperationsApi->api1CommandsStatusPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_commands_get_command_status_request** | [**\IIKO\Model\IikoTransportPublicApiContractsCommandsGetCommandStatusRequest**](../Model/IikoTransportPublicApiContractsCommandsGetCommandStatusRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsCommandsGetCommandStatusResponse**](../Model/IikoTransportPublicApiContractsCommandsGetCommandStatusResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
