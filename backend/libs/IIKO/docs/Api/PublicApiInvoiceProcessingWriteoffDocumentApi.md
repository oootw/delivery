# IIKO\PublicApiInvoiceProcessingWriteoffDocumentApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**apiInventoryV1WriteoffDocumentCancelPost()**](PublicApiInvoiceProcessingWriteoffDocumentApi.md#apiInventoryV1WriteoffDocumentCancelPost) | **POST** /api/inventory/v1/writeoff_document/cancel | Cancel write-off document draft |
| [**apiInventoryV1WriteoffDocumentCreatePost()**](PublicApiInvoiceProcessingWriteoffDocumentApi.md#apiInventoryV1WriteoffDocumentCreatePost) | **POST** /api/inventory/v1/writeoff_document/create | Create write-off document |
| [**apiInventoryV1WriteoffDocumentGetPost()**](PublicApiInvoiceProcessingWriteoffDocumentApi.md#apiInventoryV1WriteoffDocumentGetPost) | **POST** /api/inventory/v1/writeoff_document/get | Get write-off document by identifier |
| [**apiInventoryV1WriteoffDocumentListPost()**](PublicApiInvoiceProcessingWriteoffDocumentApi.md#apiInventoryV1WriteoffDocumentListPost) | **POST** /api/inventory/v1/writeoff_document/list | Export write-off documents |
| [**apiInventoryV1WriteoffDocumentPostPost()**](PublicApiInvoiceProcessingWriteoffDocumentApi.md#apiInventoryV1WriteoffDocumentPostPost) | **POST** /api/inventory/v1/writeoff_document/post | Post write-off document |
| [**apiInventoryV1WriteoffDocumentUnpostPost()**](PublicApiInvoiceProcessingWriteoffDocumentApi.md#apiInventoryV1WriteoffDocumentUnpostPost) | **POST** /api/inventory/v1/writeoff_document/unpost | Unpost write-off document |
| [**apiInventoryV1WriteoffDocumentUpdatePost()**](PublicApiInvoiceProcessingWriteoffDocumentApi.md#apiInventoryV1WriteoffDocumentUpdatePost) | **POST** /api/inventory/v1/writeoff_document/update | Edit write-off document |


## `apiInventoryV1WriteoffDocumentCancelPost()`

```php
apiInventoryV1WriteoffDocumentCancelPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Cancel write-off document draft

Changes the write-off document status from NEW to CANCELED

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingWriteoffDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document draft cancellation request body

try {
    $result = $apiInstance->apiInventoryV1WriteoffDocumentCancelPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingWriteoffDocumentApi->apiInventoryV1WriteoffDocumentCancelPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1WriteoffDocumentCreatePost()`

```php
apiInventoryV1WriteoffDocumentCreatePost($writeoff_document_create_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Create write-off document

Creates a new write-off document in RMS

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingWriteoffDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$writeoff_document_create_request = new \IIKO\Model\WriteoffDocumentCreateRequest(); // \IIKO\Model\WriteoffDocumentCreateRequest | Document creation request body

try {
    $result = $apiInstance->apiInventoryV1WriteoffDocumentCreatePost($writeoff_document_create_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingWriteoffDocumentApi->apiInventoryV1WriteoffDocumentCreatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **writeoff_document_create_request** | [**\IIKO\Model\WriteoffDocumentCreateRequest**](../Model/WriteoffDocumentCreateRequest.md)| Document creation request body | |

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

## `apiInventoryV1WriteoffDocumentGetPost()`

```php
apiInventoryV1WriteoffDocumentGetPost($document_transactions_list_request): \IIKO\Model\WriteoffDocumentGetResponse
```

Get write-off document by identifier

Gets a write-off document by identifier from RMS

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingWriteoffDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document retrieval by identifier request body

try {
    $result = $apiInstance->apiInventoryV1WriteoffDocumentGetPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingWriteoffDocumentApi->apiInventoryV1WriteoffDocumentGetPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **document_transactions_list_request** | [**\IIKO\Model\DocumentTransactionsListRequest**](../Model/DocumentTransactionsListRequest.md)| Document retrieval by identifier request body | |

### Return type

[**\IIKO\Model\WriteoffDocumentGetResponse**](../Model/WriteoffDocumentGetResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiInventoryV1WriteoffDocumentListPost()`

```php
apiInventoryV1WriteoffDocumentListPost($list_request): \IIKO\Model\WriteoffDocumentListItem[]
```

Export write-off documents

Exports write-off documents from RMS for the specified period

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingWriteoffDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$list_request = new \IIKO\Model\ListRequest(); // \IIKO\Model\ListRequest | Document list retrieval request body

try {
    $result = $apiInstance->apiInventoryV1WriteoffDocumentListPost($list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingWriteoffDocumentApi->apiInventoryV1WriteoffDocumentListPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **list_request** | [**\IIKO\Model\ListRequest**](../Model/ListRequest.md)| Document list retrieval request body | |

### Return type

[**\IIKO\Model\WriteoffDocumentListItem[]**](../Model/WriteoffDocumentListItem.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiInventoryV1WriteoffDocumentPostPost()`

```php
apiInventoryV1WriteoffDocumentPostPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Post write-off document

Changes the write-off document status from NEW to PROCESSED

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingWriteoffDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document posting request body

try {
    $result = $apiInstance->apiInventoryV1WriteoffDocumentPostPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingWriteoffDocumentApi->apiInventoryV1WriteoffDocumentPostPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1WriteoffDocumentUnpostPost()`

```php
apiInventoryV1WriteoffDocumentUnpostPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Unpost write-off document

Changes the write-off document status from PROCESSED to NEW

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingWriteoffDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document unposting request body

try {
    $result = $apiInstance->apiInventoryV1WriteoffDocumentUnpostPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingWriteoffDocumentApi->apiInventoryV1WriteoffDocumentUnpostPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1WriteoffDocumentUpdatePost()`

```php
apiInventoryV1WriteoffDocumentUpdatePost($writeoff_document_update_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Edit write-off document

Edits an existing write-off document in RMS

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingWriteoffDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$writeoff_document_update_request = new \IIKO\Model\WriteoffDocumentUpdateRequest(); // \IIKO\Model\WriteoffDocumentUpdateRequest | Document update request body

try {
    $result = $apiInstance->apiInventoryV1WriteoffDocumentUpdatePost($writeoff_document_update_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingWriteoffDocumentApi->apiInventoryV1WriteoffDocumentUpdatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **writeoff_document_update_request** | [**\IIKO\Model\WriteoffDocumentUpdateRequest**](../Model/WriteoffDocumentUpdateRequest.md)| Document update request body | |

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
