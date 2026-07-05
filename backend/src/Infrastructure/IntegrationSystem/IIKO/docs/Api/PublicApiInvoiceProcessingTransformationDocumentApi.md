# IIKO\PublicApiInvoiceProcessingTransformationDocumentApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**apiInventoryV1TransformationDocumentCancelPost()**](PublicApiInvoiceProcessingTransformationDocumentApi.md#apiInventoryV1TransformationDocumentCancelPost) | **POST** /api/inventory/v1/transformation_document/cancel | Cancel transformation document draft |
| [**apiInventoryV1TransformationDocumentCreatePost()**](PublicApiInvoiceProcessingTransformationDocumentApi.md#apiInventoryV1TransformationDocumentCreatePost) | **POST** /api/inventory/v1/transformation_document/create | Create transformation document |
| [**apiInventoryV1TransformationDocumentGetPost()**](PublicApiInvoiceProcessingTransformationDocumentApi.md#apiInventoryV1TransformationDocumentGetPost) | **POST** /api/inventory/v1/transformation_document/get | Get transformation document |
| [**apiInventoryV1TransformationDocumentListPost()**](PublicApiInvoiceProcessingTransformationDocumentApi.md#apiInventoryV1TransformationDocumentListPost) | **POST** /api/inventory/v1/transformation_document/list | List transformation documents |
| [**apiInventoryV1TransformationDocumentPostPost()**](PublicApiInvoiceProcessingTransformationDocumentApi.md#apiInventoryV1TransformationDocumentPostPost) | **POST** /api/inventory/v1/transformation_document/post | Post transformation document |
| [**apiInventoryV1TransformationDocumentUnpostPost()**](PublicApiInvoiceProcessingTransformationDocumentApi.md#apiInventoryV1TransformationDocumentUnpostPost) | **POST** /api/inventory/v1/transformation_document/unpost | Unpost transformation document |
| [**apiInventoryV1TransformationDocumentUpdatePost()**](PublicApiInvoiceProcessingTransformationDocumentApi.md#apiInventoryV1TransformationDocumentUpdatePost) | **POST** /api/inventory/v1/transformation_document/update | Edit transformation document |


## `apiInventoryV1TransformationDocumentCancelPost()`

```php
apiInventoryV1TransformationDocumentCancelPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Cancel transformation document draft

Changes the transformation document status from NEW to CANCELED

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingTransformationDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document draft cancellation request body

try {
    $result = $apiInstance->apiInventoryV1TransformationDocumentCancelPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingTransformationDocumentApi->apiInventoryV1TransformationDocumentCancelPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1TransformationDocumentCreatePost()`

```php
apiInventoryV1TransformationDocumentCreatePost($transformation_document_create_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Create transformation document

Creates a new transformation document in RMS

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingTransformationDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$transformation_document_create_request = new \IIKO\Model\TransformationDocumentCreateRequest(); // \IIKO\Model\TransformationDocumentCreateRequest | Document creation request body

try {
    $result = $apiInstance->apiInventoryV1TransformationDocumentCreatePost($transformation_document_create_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingTransformationDocumentApi->apiInventoryV1TransformationDocumentCreatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **transformation_document_create_request** | [**\IIKO\Model\TransformationDocumentCreateRequest**](../Model/TransformationDocumentCreateRequest.md)| Document creation request body | |

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

## `apiInventoryV1TransformationDocumentGetPost()`

```php
apiInventoryV1TransformationDocumentGetPost($document_transactions_list_request): \IIKO\Model\TransformationDocumentGetResponse
```

Get transformation document

Gets a transformation document by identifier from RMS

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingTransformationDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document retrieval by identifier request body

try {
    $result = $apiInstance->apiInventoryV1TransformationDocumentGetPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingTransformationDocumentApi->apiInventoryV1TransformationDocumentGetPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **document_transactions_list_request** | [**\IIKO\Model\DocumentTransactionsListRequest**](../Model/DocumentTransactionsListRequest.md)| Document retrieval by identifier request body | |

### Return type

[**\IIKO\Model\TransformationDocumentGetResponse**](../Model/TransformationDocumentGetResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiInventoryV1TransformationDocumentListPost()`

```php
apiInventoryV1TransformationDocumentListPost($list_request): \IIKO\Model\DisassembleDocumentListItem[]
```

List transformation documents

Returns a list of transformation documents for the specified period

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingTransformationDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$list_request = new \IIKO\Model\ListRequest(); // \IIKO\Model\ListRequest | Document list retrieval request body

try {
    $result = $apiInstance->apiInventoryV1TransformationDocumentListPost($list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingTransformationDocumentApi->apiInventoryV1TransformationDocumentListPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1TransformationDocumentPostPost()`

```php
apiInventoryV1TransformationDocumentPostPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Post transformation document

Changes the transformation document status from NEW to PROCESSED

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingTransformationDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document posting request body

try {
    $result = $apiInstance->apiInventoryV1TransformationDocumentPostPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingTransformationDocumentApi->apiInventoryV1TransformationDocumentPostPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1TransformationDocumentUnpostPost()`

```php
apiInventoryV1TransformationDocumentUnpostPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Unpost transformation document

Changes the transformation document status from PROCESSED to NEW

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingTransformationDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document unposting request body

try {
    $result = $apiInstance->apiInventoryV1TransformationDocumentUnpostPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingTransformationDocumentApi->apiInventoryV1TransformationDocumentUnpostPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1TransformationDocumentUpdatePost()`

```php
apiInventoryV1TransformationDocumentUpdatePost($transformation_document_update_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Edit transformation document

Edits an existing transformation document in RMS

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingTransformationDocumentApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$transformation_document_update_request = new \IIKO\Model\TransformationDocumentUpdateRequest(); // \IIKO\Model\TransformationDocumentUpdateRequest | Document update request body

try {
    $result = $apiInstance->apiInventoryV1TransformationDocumentUpdatePost($transformation_document_update_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingTransformationDocumentApi->apiInventoryV1TransformationDocumentUpdatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **transformation_document_update_request** | [**\IIKO\Model\TransformationDocumentUpdateRequest**](../Model/TransformationDocumentUpdateRequest.md)| Document update request body | |

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
