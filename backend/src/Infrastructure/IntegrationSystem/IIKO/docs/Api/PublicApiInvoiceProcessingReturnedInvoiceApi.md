# IIKO\PublicApiInvoiceProcessingReturnedInvoiceApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**apiInventoryV1ReturnedInvoiceCancelPost()**](PublicApiInvoiceProcessingReturnedInvoiceApi.md#apiInventoryV1ReturnedInvoiceCancelPost) | **POST** /api/inventory/v1/returned_invoice/cancel | Cancel returned invoice draft |
| [**apiInventoryV1ReturnedInvoiceCreatePost()**](PublicApiInvoiceProcessingReturnedInvoiceApi.md#apiInventoryV1ReturnedInvoiceCreatePost) | **POST** /api/inventory/v1/returned_invoice/create | Create returned invoice |
| [**apiInventoryV1ReturnedInvoiceGetPost()**](PublicApiInvoiceProcessingReturnedInvoiceApi.md#apiInventoryV1ReturnedInvoiceGetPost) | **POST** /api/inventory/v1/returned_invoice/get | Get returned invoice by identifier |
| [**apiInventoryV1ReturnedInvoiceListPost()**](PublicApiInvoiceProcessingReturnedInvoiceApi.md#apiInventoryV1ReturnedInvoiceListPost) | **POST** /api/inventory/v1/returned_invoice/list | Export returned invoices |
| [**apiInventoryV1ReturnedInvoicePostPost()**](PublicApiInvoiceProcessingReturnedInvoiceApi.md#apiInventoryV1ReturnedInvoicePostPost) | **POST** /api/inventory/v1/returned_invoice/post | Post returned invoice |
| [**apiInventoryV1ReturnedInvoiceUnpostPost()**](PublicApiInvoiceProcessingReturnedInvoiceApi.md#apiInventoryV1ReturnedInvoiceUnpostPost) | **POST** /api/inventory/v1/returned_invoice/unpost | Unpost returned invoice |
| [**apiInventoryV1ReturnedInvoiceUpdatePost()**](PublicApiInvoiceProcessingReturnedInvoiceApi.md#apiInventoryV1ReturnedInvoiceUpdatePost) | **POST** /api/inventory/v1/returned_invoice/update | Edit returned invoice |


## `apiInventoryV1ReturnedInvoiceCancelPost()`

```php
apiInventoryV1ReturnedInvoiceCancelPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Cancel returned invoice draft

Changes the returned invoice status from NEW to CANCELED

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingReturnedInvoiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document draft cancellation request body

try {
    $result = $apiInstance->apiInventoryV1ReturnedInvoiceCancelPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingReturnedInvoiceApi->apiInventoryV1ReturnedInvoiceCancelPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **document_transactions_list_request** | [**\IIKO\Model\DocumentTransactionsListRequest**](../Model/DocumentTransactionsListRequest.md)| Document draft cancellation request body | |

### Return type

[**\IIKO\Model\DisassembleDocumentSaveResponse**](../Model/DisassembleDocumentSaveResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiInventoryV1ReturnedInvoiceCreatePost()`

```php
apiInventoryV1ReturnedInvoiceCreatePost($returned_invoice_create_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Create returned invoice

Creates a returned invoice from request parameters

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingReturnedInvoiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$returned_invoice_create_request = new \IIKO\Model\ReturnedInvoiceCreateRequest(); // \IIKO\Model\ReturnedInvoiceCreateRequest | Document creation request body

try {
    $result = $apiInstance->apiInventoryV1ReturnedInvoiceCreatePost($returned_invoice_create_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingReturnedInvoiceApi->apiInventoryV1ReturnedInvoiceCreatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **returned_invoice_create_request** | [**\IIKO\Model\ReturnedInvoiceCreateRequest**](../Model/ReturnedInvoiceCreateRequest.md)| Document creation request body | |

### Return type

[**\IIKO\Model\DisassembleDocumentSaveResponse**](../Model/DisassembleDocumentSaveResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiInventoryV1ReturnedInvoiceGetPost()`

```php
apiInventoryV1ReturnedInvoiceGetPost($document_transactions_list_request): \IIKO\Model\ReturnedInvoiceGetResponse
```

Get returned invoice by identifier

Returns a returned invoice by identifier

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingReturnedInvoiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document retrieval by identifier request body

try {
    $result = $apiInstance->apiInventoryV1ReturnedInvoiceGetPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingReturnedInvoiceApi->apiInventoryV1ReturnedInvoiceGetPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **document_transactions_list_request** | [**\IIKO\Model\DocumentTransactionsListRequest**](../Model/DocumentTransactionsListRequest.md)| Document retrieval by identifier request body | |

### Return type

[**\IIKO\Model\ReturnedInvoiceGetResponse**](../Model/ReturnedInvoiceGetResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiInventoryV1ReturnedInvoiceListPost()`

```php
apiInventoryV1ReturnedInvoiceListPost($list_request): \IIKO\Model\ReturnedInvoiceListItem[]
```

Export returned invoices

Exports returned invoices from RMS for the specified period

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingReturnedInvoiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$list_request = new \IIKO\Model\ListRequest(); // \IIKO\Model\ListRequest | Document list retrieval request body

try {
    $result = $apiInstance->apiInventoryV1ReturnedInvoiceListPost($list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingReturnedInvoiceApi->apiInventoryV1ReturnedInvoiceListPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **list_request** | [**\IIKO\Model\ListRequest**](../Model/ListRequest.md)| Document list retrieval request body | |

### Return type

[**\IIKO\Model\ReturnedInvoiceListItem[]**](../Model/ReturnedInvoiceListItem.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiInventoryV1ReturnedInvoicePostPost()`

```php
apiInventoryV1ReturnedInvoicePostPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Post returned invoice

Changes the returned invoice status from NEW to PROCESSED

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingReturnedInvoiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document posting request body

try {
    $result = $apiInstance->apiInventoryV1ReturnedInvoicePostPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingReturnedInvoiceApi->apiInventoryV1ReturnedInvoicePostPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **document_transactions_list_request** | [**\IIKO\Model\DocumentTransactionsListRequest**](../Model/DocumentTransactionsListRequest.md)| Document posting request body | |

### Return type

[**\IIKO\Model\DisassembleDocumentSaveResponse**](../Model/DisassembleDocumentSaveResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiInventoryV1ReturnedInvoiceUnpostPost()`

```php
apiInventoryV1ReturnedInvoiceUnpostPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Unpost returned invoice

Changes the returned invoice status from PROCESSED to NEW

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingReturnedInvoiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document unposting request body

try {
    $result = $apiInstance->apiInventoryV1ReturnedInvoiceUnpostPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingReturnedInvoiceApi->apiInventoryV1ReturnedInvoiceUnpostPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **document_transactions_list_request** | [**\IIKO\Model\DocumentTransactionsListRequest**](../Model/DocumentTransactionsListRequest.md)| Document unposting request body | |

### Return type

[**\IIKO\Model\DisassembleDocumentSaveResponse**](../Model/DisassembleDocumentSaveResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiInventoryV1ReturnedInvoiceUpdatePost()`

```php
apiInventoryV1ReturnedInvoiceUpdatePost($returned_invoice_update_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Edit returned invoice

Updates a returned invoice from request parameters

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingReturnedInvoiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$returned_invoice_update_request = new \IIKO\Model\ReturnedInvoiceUpdateRequest(); // \IIKO\Model\ReturnedInvoiceUpdateRequest | Document update request body

try {
    $result = $apiInstance->apiInventoryV1ReturnedInvoiceUpdatePost($returned_invoice_update_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingReturnedInvoiceApi->apiInventoryV1ReturnedInvoiceUpdatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **returned_invoice_update_request** | [**\IIKO\Model\ReturnedInvoiceUpdateRequest**](../Model/ReturnedInvoiceUpdateRequest.md)| Document update request body | |

### Return type

[**\IIKO\Model\DisassembleDocumentSaveResponse**](../Model/DisassembleDocumentSaveResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
