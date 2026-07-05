# IIKO\PublicApiInvoiceProcessingSalesDocumentApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**apiInventoryV1SalesDocumentCancelPost()**](PublicApiInvoiceProcessingSalesDocumentApi.md#apiInventoryV1SalesDocumentCancelPost) | **POST** /api/inventory/v1/sales_document/cancel | Cancel sales document draft |
| [**apiInventoryV1SalesDocumentCreatePost()**](PublicApiInvoiceProcessingSalesDocumentApi.md#apiInventoryV1SalesDocumentCreatePost) | **POST** /api/inventory/v1/sales_document/create | Create sales document |
| [**apiInventoryV1SalesDocumentGetPost()**](PublicApiInvoiceProcessingSalesDocumentApi.md#apiInventoryV1SalesDocumentGetPost) | **POST** /api/inventory/v1/sales_document/get | Get sales document |
| [**apiInventoryV1SalesDocumentListPost()**](PublicApiInvoiceProcessingSalesDocumentApi.md#apiInventoryV1SalesDocumentListPost) | **POST** /api/inventory/v1/sales_document/list | Export sales documents |
| [**apiInventoryV1SalesDocumentPostPost()**](PublicApiInvoiceProcessingSalesDocumentApi.md#apiInventoryV1SalesDocumentPostPost) | **POST** /api/inventory/v1/sales_document/post | Post sales document |
| [**apiInventoryV1SalesDocumentUnpostPost()**](PublicApiInvoiceProcessingSalesDocumentApi.md#apiInventoryV1SalesDocumentUnpostPost) | **POST** /api/inventory/v1/sales_document/unpost | Unpost sales document |
| [**apiInventoryV1SalesDocumentUpdatePost()**](PublicApiInvoiceProcessingSalesDocumentApi.md#apiInventoryV1SalesDocumentUpdatePost) | **POST** /api/inventory/v1/sales_document/update | Edit sales document |


## `apiInventoryV1SalesDocumentCancelPost()`

```php
apiInventoryV1SalesDocumentCancelPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Cancel sales document draft

Changes the sales document status from NEW to CANCELED

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingSalesDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document draft cancellation request body

try {
    $result = $apiInstance->apiInventoryV1SalesDocumentCancelPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingSalesDocumentApi->apiInventoryV1SalesDocumentCancelPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1SalesDocumentCreatePost()`

```php
apiInventoryV1SalesDocumentCreatePost($sales_document_create_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Create sales document

Creates a new sales document in RMS

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingSalesDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$sales_document_create_request = new \IIKO\Model\SalesDocumentCreateRequest(); // \IIKO\Model\SalesDocumentCreateRequest | Document creation request body

try {
    $result = $apiInstance->apiInventoryV1SalesDocumentCreatePost($sales_document_create_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingSalesDocumentApi->apiInventoryV1SalesDocumentCreatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **sales_document_create_request** | [**\IIKO\Model\SalesDocumentCreateRequest**](../Model/SalesDocumentCreateRequest.md)| Document creation request body | |

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

## `apiInventoryV1SalesDocumentGetPost()`

```php
apiInventoryV1SalesDocumentGetPost($document_transactions_list_request): \IIKO\Model\SalesDocumentGetResponse
```

Get sales document

Gets a sales document by identifier from RMS

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingSalesDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document retrieval by identifier request body

try {
    $result = $apiInstance->apiInventoryV1SalesDocumentGetPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingSalesDocumentApi->apiInventoryV1SalesDocumentGetPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **document_transactions_list_request** | [**\IIKO\Model\DocumentTransactionsListRequest**](../Model/DocumentTransactionsListRequest.md)| Document retrieval by identifier request body | |

### Return type

[**\IIKO\Model\SalesDocumentGetResponse**](../Model/SalesDocumentGetResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiInventoryV1SalesDocumentListPost()`

```php
apiInventoryV1SalesDocumentListPost($list_request): \IIKO\Model\SalesDocumentListItem[]
```

Export sales documents

Exports sales documents from RMS for the specified period

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingSalesDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$list_request = new \IIKO\Model\ListRequest(); // \IIKO\Model\ListRequest | Document list retrieval request body

try {
    $result = $apiInstance->apiInventoryV1SalesDocumentListPost($list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingSalesDocumentApi->apiInventoryV1SalesDocumentListPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **list_request** | [**\IIKO\Model\ListRequest**](../Model/ListRequest.md)| Document list retrieval request body | |

### Return type

[**\IIKO\Model\SalesDocumentListItem[]**](../Model/SalesDocumentListItem.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiInventoryV1SalesDocumentPostPost()`

```php
apiInventoryV1SalesDocumentPostPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Post sales document

Changes the sales document status from NEW to PROCESSED

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingSalesDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document posting request body

try {
    $result = $apiInstance->apiInventoryV1SalesDocumentPostPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingSalesDocumentApi->apiInventoryV1SalesDocumentPostPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1SalesDocumentUnpostPost()`

```php
apiInventoryV1SalesDocumentUnpostPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Unpost sales document

Changes the sales document status from PROCESSED to NEW

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingSalesDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document unposting request body

try {
    $result = $apiInstance->apiInventoryV1SalesDocumentUnpostPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingSalesDocumentApi->apiInventoryV1SalesDocumentUnpostPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1SalesDocumentUpdatePost()`

```php
apiInventoryV1SalesDocumentUpdatePost($sales_document_update_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Edit sales document

Edits an existing sales document in RMS

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingSalesDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$sales_document_update_request = new \IIKO\Model\SalesDocumentUpdateRequest(); // \IIKO\Model\SalesDocumentUpdateRequest | Document update request body

try {
    $result = $apiInstance->apiInventoryV1SalesDocumentUpdatePost($sales_document_update_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingSalesDocumentApi->apiInventoryV1SalesDocumentUpdatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **sales_document_update_request** | [**\IIKO\Model\SalesDocumentUpdateRequest**](../Model/SalesDocumentUpdateRequest.md)| Document update request body | |

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
