# IIKO\PublicApiInvoiceProcessingDocumentTransactionsApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**apiFinanceV1DocumentTransactionsListPost()**](PublicApiInvoiceProcessingDocumentTransactionsApi.md#apiFinanceV1DocumentTransactionsListPost) | **POST** /api/finance/v1/document_transactions/list | Get document transactions |


## `apiFinanceV1DocumentTransactionsListPost()`

```php
apiFinanceV1DocumentTransactionsListPost($document_transactions_list_request): \IIKO\Model\DocumentTransactionItem[]
```

Get document transactions

Returns a list of transactions for the specified document

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingDocumentTransactionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Request parameters

try {
    $result = $apiInstance->apiFinanceV1DocumentTransactionsListPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingDocumentTransactionsApi->apiFinanceV1DocumentTransactionsListPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **document_transactions_list_request** | [**\IIKO\Model\DocumentTransactionsListRequest**](../Model/DocumentTransactionsListRequest.md)| Request parameters | |

### Return type

[**\IIKO\Model\DocumentTransactionItem[]**](../Model/DocumentTransactionItem.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
