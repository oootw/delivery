# IIKO\PublicApiInvoiceProcessingCounteragentsApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**apiInventoryV1CounteragentsPost()**](PublicApiInvoiceProcessingCounteragentsApi.md#apiInventoryV1CounteragentsPost) | **POST** /api/inventory/v1/counteragents | Get counteragents list |


## `apiInventoryV1CounteragentsPost()`

```php
apiInventoryV1CounteragentsPost($get_counteragents_request): \IIKO\Model\GetCounteragentsResponse
```

Get counteragents list

Gets a list of counteragents with pagination and type filtering support

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingCounteragentsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$get_counteragents_request = new \IIKO\Model\GetCounteragentsRequest(); // \IIKO\Model\GetCounteragentsRequest | Request parameters

try {
    $result = $apiInstance->apiInventoryV1CounteragentsPost($get_counteragents_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingCounteragentsApi->apiInventoryV1CounteragentsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **get_counteragents_request** | [**\IIKO\Model\GetCounteragentsRequest**](../Model/GetCounteragentsRequest.md)| Request parameters | |

### Return type

[**\IIKO\Model\GetCounteragentsResponse**](../Model/GetCounteragentsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
