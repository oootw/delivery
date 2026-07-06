# IIKO\PublicApiInvoiceProcessingDisassembleDocumentApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**apiInventoryV1DisassembleDocumentCancelPost()**](PublicApiInvoiceProcessingDisassembleDocumentApi.md#apiInventoryV1DisassembleDocumentCancelPost) | **POST** /api/inventory/v1/disassemble_document/cancel | Cancel disassemble document draft |
| [**apiInventoryV1DisassembleDocumentCreatePost()**](PublicApiInvoiceProcessingDisassembleDocumentApi.md#apiInventoryV1DisassembleDocumentCreatePost) | **POST** /api/inventory/v1/disassemble_document/create | Create disassemble document |
| [**apiInventoryV1DisassembleDocumentGetPost()**](PublicApiInvoiceProcessingDisassembleDocumentApi.md#apiInventoryV1DisassembleDocumentGetPost) | **POST** /api/inventory/v1/disassemble_document/get | Get disassemble document by identifier |
| [**apiInventoryV1DisassembleDocumentListPost()**](PublicApiInvoiceProcessingDisassembleDocumentApi.md#apiInventoryV1DisassembleDocumentListPost) | **POST** /api/inventory/v1/disassemble_document/list | Export disassemble documents |
| [**apiInventoryV1DisassembleDocumentPostPost()**](PublicApiInvoiceProcessingDisassembleDocumentApi.md#apiInventoryV1DisassembleDocumentPostPost) | **POST** /api/inventory/v1/disassemble_document/post | Post disassemble document |
| [**apiInventoryV1DisassembleDocumentUnpostPost()**](PublicApiInvoiceProcessingDisassembleDocumentApi.md#apiInventoryV1DisassembleDocumentUnpostPost) | **POST** /api/inventory/v1/disassemble_document/unpost | Unpost disassemble document |
| [**apiInventoryV1DisassembleDocumentUpdatePost()**](PublicApiInvoiceProcessingDisassembleDocumentApi.md#apiInventoryV1DisassembleDocumentUpdatePost) | **POST** /api/inventory/v1/disassemble_document/update | Edit disassemble document |


## `apiInventoryV1DisassembleDocumentCancelPost()`

```php
apiInventoryV1DisassembleDocumentCancelPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Cancel disassemble document draft

Changes the disassemble document status from NEW to CANCELED

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingDisassembleDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document draft cancellation request body

try {
    $result = $apiInstance->apiInventoryV1DisassembleDocumentCancelPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingDisassembleDocumentApi->apiInventoryV1DisassembleDocumentCancelPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1DisassembleDocumentCreatePost()`

```php
apiInventoryV1DisassembleDocumentCreatePost($disassemble_document_create_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Create disassemble document

Creates a disassemble document from request parameters

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingDisassembleDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$disassemble_document_create_request = new \IIKO\Model\DisassembleDocumentCreateRequest(); // \IIKO\Model\DisassembleDocumentCreateRequest | Document creation request body

try {
    $result = $apiInstance->apiInventoryV1DisassembleDocumentCreatePost($disassemble_document_create_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingDisassembleDocumentApi->apiInventoryV1DisassembleDocumentCreatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **disassemble_document_create_request** | [**\IIKO\Model\DisassembleDocumentCreateRequest**](../Model/DisassembleDocumentCreateRequest.md)| Document creation request body | |

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

## `apiInventoryV1DisassembleDocumentGetPost()`

```php
apiInventoryV1DisassembleDocumentGetPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentGetResponse
```

Get disassemble document by identifier

Returns a disassemble document by identifier

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingDisassembleDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document retrieval by identifier request body

try {
    $result = $apiInstance->apiInventoryV1DisassembleDocumentGetPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingDisassembleDocumentApi->apiInventoryV1DisassembleDocumentGetPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **document_transactions_list_request** | [**\IIKO\Model\DocumentTransactionsListRequest**](../Model/DocumentTransactionsListRequest.md)| Document retrieval by identifier request body | |

### Return type

[**\IIKO\Model\DisassembleDocumentGetResponse**](../Model/DisassembleDocumentGetResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiInventoryV1DisassembleDocumentListPost()`

```php
apiInventoryV1DisassembleDocumentListPost($list_request): \IIKO\Model\DisassembleDocumentListItem[]
```

Export disassemble documents

Exports disassemble documents from RMS for the specified period

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingDisassembleDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$list_request = new \IIKO\Model\ListRequest(); // \IIKO\Model\ListRequest | Document list retrieval request body

try {
    $result = $apiInstance->apiInventoryV1DisassembleDocumentListPost($list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingDisassembleDocumentApi->apiInventoryV1DisassembleDocumentListPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **list_request** | [**\IIKO\Model\ListRequest**](../Model/ListRequest.md)| Document list retrieval request body | |

### Return type

[**\IIKO\Model\DisassembleDocumentListItem[]**](../Model/DisassembleDocumentListItem.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiInventoryV1DisassembleDocumentPostPost()`

```php
apiInventoryV1DisassembleDocumentPostPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Post disassemble document

Changes the disassemble document status from NEW to PROCESSED

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingDisassembleDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document posting request body

try {
    $result = $apiInstance->apiInventoryV1DisassembleDocumentPostPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingDisassembleDocumentApi->apiInventoryV1DisassembleDocumentPostPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1DisassembleDocumentUnpostPost()`

```php
apiInventoryV1DisassembleDocumentUnpostPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Unpost disassemble document

Changes the disassemble document status from PROCESSED to NEW

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingDisassembleDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document unposting request body

try {
    $result = $apiInstance->apiInventoryV1DisassembleDocumentUnpostPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingDisassembleDocumentApi->apiInventoryV1DisassembleDocumentUnpostPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1DisassembleDocumentUpdatePost()`

```php
apiInventoryV1DisassembleDocumentUpdatePost($disassemble_document_update_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Edit disassemble document

Updates a disassemble document from request parameters

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingDisassembleDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$disassemble_document_update_request = new \IIKO\Model\DisassembleDocumentUpdateRequest(); // \IIKO\Model\DisassembleDocumentUpdateRequest | Document update request body

try {
    $result = $apiInstance->apiInventoryV1DisassembleDocumentUpdatePost($disassemble_document_update_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingDisassembleDocumentApi->apiInventoryV1DisassembleDocumentUpdatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **disassemble_document_update_request** | [**\IIKO\Model\DisassembleDocumentUpdateRequest**](../Model/DisassembleDocumentUpdateRequest.md)| Document update request body | |

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
