# IIKO\PublicApiInvoiceProcessingAccountTransactionsApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**apiFinanceV1AccountTransactionsListPost()**](PublicApiInvoiceProcessingAccountTransactionsApi.md#apiFinanceV1AccountTransactionsListPost) | **POST** /api/finance/v1/account_transactions/list | Get account transactions |


## `apiFinanceV1AccountTransactionsListPost()`

```php
apiFinanceV1AccountTransactionsListPost($account_transactions_list_request): \IIKO\Model\AccountTransactionsResponse
```

Get account transactions

Returns a list of transactions for the specified account

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingAccountTransactionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$account_transactions_list_request = new \IIKO\Model\AccountTransactionsListRequest(); // \IIKO\Model\AccountTransactionsListRequest | Request parameters

try {
    $result = $apiInstance->apiFinanceV1AccountTransactionsListPost($account_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingAccountTransactionsApi->apiFinanceV1AccountTransactionsListPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **account_transactions_list_request** | [**\IIKO\Model\AccountTransactionsListRequest**](../Model/AccountTransactionsListRequest.md)| Request parameters | |

### Return type

[**\IIKO\Model\AccountTransactionsResponse**](../Model/AccountTransactionsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
