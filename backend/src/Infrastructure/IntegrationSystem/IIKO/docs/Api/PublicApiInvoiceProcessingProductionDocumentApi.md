# IIKO\PublicApiInvoiceProcessingProductionDocumentApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**apiInventoryV1ProductionDocumentCancelPost()**](PublicApiInvoiceProcessingProductionDocumentApi.md#apiInventoryV1ProductionDocumentCancelPost) | **POST** /api/inventory/v1/production_document/cancel | Cancel production document draft |
| [**apiInventoryV1ProductionDocumentCreatePost()**](PublicApiInvoiceProcessingProductionDocumentApi.md#apiInventoryV1ProductionDocumentCreatePost) | **POST** /api/inventory/v1/production_document/create | Create production document |
| [**apiInventoryV1ProductionDocumentGetPost()**](PublicApiInvoiceProcessingProductionDocumentApi.md#apiInventoryV1ProductionDocumentGetPost) | **POST** /api/inventory/v1/production_document/get | Get production document |
| [**apiInventoryV1ProductionDocumentListPost()**](PublicApiInvoiceProcessingProductionDocumentApi.md#apiInventoryV1ProductionDocumentListPost) | **POST** /api/inventory/v1/production_document/list | Export production documents |
| [**apiInventoryV1ProductionDocumentPostPost()**](PublicApiInvoiceProcessingProductionDocumentApi.md#apiInventoryV1ProductionDocumentPostPost) | **POST** /api/inventory/v1/production_document/post | Post production document |
| [**apiInventoryV1ProductionDocumentUnpostPost()**](PublicApiInvoiceProcessingProductionDocumentApi.md#apiInventoryV1ProductionDocumentUnpostPost) | **POST** /api/inventory/v1/production_document/unpost | Unpost production document |
| [**apiInventoryV1ProductionDocumentUpdatePost()**](PublicApiInvoiceProcessingProductionDocumentApi.md#apiInventoryV1ProductionDocumentUpdatePost) | **POST** /api/inventory/v1/production_document/update | Edit production document |


## `apiInventoryV1ProductionDocumentCancelPost()`

```php
apiInventoryV1ProductionDocumentCancelPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Cancel production document draft

Changes the production document status from NEW to CANCELED

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingProductionDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document draft cancellation request body

try {
    $result = $apiInstance->apiInventoryV1ProductionDocumentCancelPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingProductionDocumentApi->apiInventoryV1ProductionDocumentCancelPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1ProductionDocumentCreatePost()`

```php
apiInventoryV1ProductionDocumentCreatePost($production_document_create_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Create production document

Creates a new production document in RMS

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingProductionDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$production_document_create_request = new \IIKO\Model\ProductionDocumentCreateRequest(); // \IIKO\Model\ProductionDocumentCreateRequest | Document creation request body

try {
    $result = $apiInstance->apiInventoryV1ProductionDocumentCreatePost($production_document_create_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingProductionDocumentApi->apiInventoryV1ProductionDocumentCreatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **production_document_create_request** | [**\IIKO\Model\ProductionDocumentCreateRequest**](../Model/ProductionDocumentCreateRequest.md)| Document creation request body | |

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

## `apiInventoryV1ProductionDocumentGetPost()`

```php
apiInventoryV1ProductionDocumentGetPost($document_transactions_list_request): \IIKO\Model\ProductionDocumentGetResponse
```

Get production document

Gets a production document by identifier from RMS

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingProductionDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document retrieval by identifier request body

try {
    $result = $apiInstance->apiInventoryV1ProductionDocumentGetPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingProductionDocumentApi->apiInventoryV1ProductionDocumentGetPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **document_transactions_list_request** | [**\IIKO\Model\DocumentTransactionsListRequest**](../Model/DocumentTransactionsListRequest.md)| Document retrieval by identifier request body | |

### Return type

[**\IIKO\Model\ProductionDocumentGetResponse**](../Model/ProductionDocumentGetResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiInventoryV1ProductionDocumentListPost()`

```php
apiInventoryV1ProductionDocumentListPost($list_request): \IIKO\Model\DisassembleDocumentListItem[]
```

Export production documents

Exports production documents from RMS for the specified period

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingProductionDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$list_request = new \IIKO\Model\ListRequest(); // \IIKO\Model\ListRequest | Document list retrieval request body

try {
    $result = $apiInstance->apiInventoryV1ProductionDocumentListPost($list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingProductionDocumentApi->apiInventoryV1ProductionDocumentListPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1ProductionDocumentPostPost()`

```php
apiInventoryV1ProductionDocumentPostPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Post production document

Changes the production document status from NEW to PROCESSED

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingProductionDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document posting request body

try {
    $result = $apiInstance->apiInventoryV1ProductionDocumentPostPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingProductionDocumentApi->apiInventoryV1ProductionDocumentPostPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1ProductionDocumentUnpostPost()`

```php
apiInventoryV1ProductionDocumentUnpostPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Unpost production document

Changes the production document status from PROCESSED to NEW

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingProductionDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document unposting request body

try {
    $result = $apiInstance->apiInventoryV1ProductionDocumentUnpostPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingProductionDocumentApi->apiInventoryV1ProductionDocumentUnpostPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1ProductionDocumentUpdatePost()`

```php
apiInventoryV1ProductionDocumentUpdatePost($production_document_update_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Edit production document

Edits an existing production document in RMS

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingProductionDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$production_document_update_request = new \IIKO\Model\ProductionDocumentUpdateRequest(); // \IIKO\Model\ProductionDocumentUpdateRequest | Document update request body

try {
    $result = $apiInstance->apiInventoryV1ProductionDocumentUpdatePost($production_document_update_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingProductionDocumentApi->apiInventoryV1ProductionDocumentUpdatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **production_document_update_request** | [**\IIKO\Model\ProductionDocumentUpdateRequest**](../Model/ProductionDocumentUpdateRequest.md)| Document update request body | |

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
