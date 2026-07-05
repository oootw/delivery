# IIKO\PublicApiInvoiceProcessingInternalTransferApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**apiInventoryV1InternalTransferCancelPost()**](PublicApiInvoiceProcessingInternalTransferApi.md#apiInventoryV1InternalTransferCancelPost) | **POST** /api/inventory/v1/internal_transfer/cancel | Cancel internal transfer act draft |
| [**apiInventoryV1InternalTransferCreatePost()**](PublicApiInvoiceProcessingInternalTransferApi.md#apiInventoryV1InternalTransferCreatePost) | **POST** /api/inventory/v1/internal_transfer/create | Create internal transfer act |
| [**apiInventoryV1InternalTransferGetPost()**](PublicApiInvoiceProcessingInternalTransferApi.md#apiInventoryV1InternalTransferGetPost) | **POST** /api/inventory/v1/internal_transfer/get | Get internal transfer act by identifier |
| [**apiInventoryV1InternalTransferListPost()**](PublicApiInvoiceProcessingInternalTransferApi.md#apiInventoryV1InternalTransferListPost) | **POST** /api/inventory/v1/internal_transfer/list | Export internal transfer acts |
| [**apiInventoryV1InternalTransferPostPost()**](PublicApiInvoiceProcessingInternalTransferApi.md#apiInventoryV1InternalTransferPostPost) | **POST** /api/inventory/v1/internal_transfer/post | Post internal transfer act |
| [**apiInventoryV1InternalTransferUnpostPost()**](PublicApiInvoiceProcessingInternalTransferApi.md#apiInventoryV1InternalTransferUnpostPost) | **POST** /api/inventory/v1/internal_transfer/unpost | Unpost internal transfer act |
| [**apiInventoryV1InternalTransferUpdatePost()**](PublicApiInvoiceProcessingInternalTransferApi.md#apiInventoryV1InternalTransferUpdatePost) | **POST** /api/inventory/v1/internal_transfer/update | Edit internal transfer act |


## `apiInventoryV1InternalTransferCancelPost()`

```php
apiInventoryV1InternalTransferCancelPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Cancel internal transfer act draft

Changes the internal transfer act status from NEW to CANCELED

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingInternalTransferApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document draft cancellation request body

try {
    $result = $apiInstance->apiInventoryV1InternalTransferCancelPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingInternalTransferApi->apiInventoryV1InternalTransferCancelPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1InternalTransferCreatePost()`

```php
apiInventoryV1InternalTransferCreatePost($internal_transfer_create_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Create internal transfer act

Creates a new internal transfer act

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingInternalTransferApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$internal_transfer_create_request = new \IIKO\Model\InternalTransferCreateRequest(); // \IIKO\Model\InternalTransferCreateRequest | Document creation request body

try {
    $result = $apiInstance->apiInventoryV1InternalTransferCreatePost($internal_transfer_create_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingInternalTransferApi->apiInventoryV1InternalTransferCreatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **internal_transfer_create_request** | [**\IIKO\Model\InternalTransferCreateRequest**](../Model/InternalTransferCreateRequest.md)| Document creation request body | |

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

## `apiInventoryV1InternalTransferGetPost()`

```php
apiInventoryV1InternalTransferGetPost($document_transactions_list_request): \IIKO\Model\InternalTransferGetResponse
```

Get internal transfer act by identifier

Gets an internal transfer act by its unique identifier

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingInternalTransferApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document retrieval by identifier request body

try {
    $result = $apiInstance->apiInventoryV1InternalTransferGetPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingInternalTransferApi->apiInventoryV1InternalTransferGetPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **document_transactions_list_request** | [**\IIKO\Model\DocumentTransactionsListRequest**](../Model/DocumentTransactionsListRequest.md)| Document retrieval by identifier request body | |

### Return type

[**\IIKO\Model\InternalTransferGetResponse**](../Model/InternalTransferGetResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiInventoryV1InternalTransferListPost()`

```php
apiInventoryV1InternalTransferListPost($list_request): \IIKO\Model\DisassembleDocumentListItem[]
```

Export internal transfer acts

Gets a list of internal transfer acts for the specified period

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingInternalTransferApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$list_request = new \IIKO\Model\ListRequest(); // \IIKO\Model\ListRequest | Document list retrieval request body

try {
    $result = $apiInstance->apiInventoryV1InternalTransferListPost($list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingInternalTransferApi->apiInventoryV1InternalTransferListPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1InternalTransferPostPost()`

```php
apiInventoryV1InternalTransferPostPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Post internal transfer act

Changes the internal transfer act status from NEW to PROCESSED

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingInternalTransferApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document posting request body

try {
    $result = $apiInstance->apiInventoryV1InternalTransferPostPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingInternalTransferApi->apiInventoryV1InternalTransferPostPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1InternalTransferUnpostPost()`

```php
apiInventoryV1InternalTransferUnpostPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Unpost internal transfer act

Changes the internal transfer act status from PROCESSED to NEW

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingInternalTransferApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document unposting request body

try {
    $result = $apiInstance->apiInventoryV1InternalTransferUnpostPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingInternalTransferApi->apiInventoryV1InternalTransferUnpostPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1InternalTransferUpdatePost()`

```php
apiInventoryV1InternalTransferUpdatePost($internal_transfer_update_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Edit internal transfer act

Edits an existing internal transfer act

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingInternalTransferApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$internal_transfer_update_request = new \IIKO\Model\InternalTransferUpdateRequest(); // \IIKO\Model\InternalTransferUpdateRequest | Document update request body

try {
    $result = $apiInstance->apiInventoryV1InternalTransferUpdatePost($internal_transfer_update_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingInternalTransferApi->apiInventoryV1InternalTransferUpdatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **internal_transfer_update_request** | [**\IIKO\Model\InternalTransferUpdateRequest**](../Model/InternalTransferUpdateRequest.md)| Document update request body | |

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
