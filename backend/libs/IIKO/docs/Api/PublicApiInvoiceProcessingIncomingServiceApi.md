# IIKO\PublicApiInvoiceProcessingIncomingServiceApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**apiFinanceV1IncomingServiceCancelPost()**](PublicApiInvoiceProcessingIncomingServiceApi.md#apiFinanceV1IncomingServiceCancelPost) | **POST** /api/finance/v1/incoming_service/cancel | Cancel incoming service act draft |
| [**apiFinanceV1IncomingServiceCreatePost()**](PublicApiInvoiceProcessingIncomingServiceApi.md#apiFinanceV1IncomingServiceCreatePost) | **POST** /api/finance/v1/incoming_service/create | Create incoming service act |
| [**apiFinanceV1IncomingServiceGetPost()**](PublicApiInvoiceProcessingIncomingServiceApi.md#apiFinanceV1IncomingServiceGetPost) | **POST** /api/finance/v1/incoming_service/get | Get incoming service act |
| [**apiFinanceV1IncomingServiceListPost()**](PublicApiInvoiceProcessingIncomingServiceApi.md#apiFinanceV1IncomingServiceListPost) | **POST** /api/finance/v1/incoming_service/list | Export incoming service acts |
| [**apiFinanceV1IncomingServicePostPost()**](PublicApiInvoiceProcessingIncomingServiceApi.md#apiFinanceV1IncomingServicePostPost) | **POST** /api/finance/v1/incoming_service/post | Post incoming service act |
| [**apiFinanceV1IncomingServiceUnpostPost()**](PublicApiInvoiceProcessingIncomingServiceApi.md#apiFinanceV1IncomingServiceUnpostPost) | **POST** /api/finance/v1/incoming_service/unpost | Unpost incoming service act |
| [**apiFinanceV1IncomingServiceUpdatePost()**](PublicApiInvoiceProcessingIncomingServiceApi.md#apiFinanceV1IncomingServiceUpdatePost) | **POST** /api/finance/v1/incoming_service/update | Edit incoming service act |


## `apiFinanceV1IncomingServiceCancelPost()`

```php
apiFinanceV1IncomingServiceCancelPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Cancel incoming service act draft

Changes the incoming service act status from NEW to CANCELED

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingIncomingServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Draft cancellation request body

try {
    $result = $apiInstance->apiFinanceV1IncomingServiceCancelPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingIncomingServiceApi->apiFinanceV1IncomingServiceCancelPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **document_transactions_list_request** | [**\IIKO\Model\DocumentTransactionsListRequest**](../Model/DocumentTransactionsListRequest.md)| Draft cancellation request body | |

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

## `apiFinanceV1IncomingServiceCreatePost()`

```php
apiFinanceV1IncomingServiceCreatePost($incoming_service_create_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Create incoming service act

Creates a new incoming service act in RMS

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingIncomingServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$incoming_service_create_request = new \IIKO\Model\IncomingServiceCreateRequest(); // \IIKO\Model\IncomingServiceCreateRequest | Document creation request body

try {
    $result = $apiInstance->apiFinanceV1IncomingServiceCreatePost($incoming_service_create_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingIncomingServiceApi->apiFinanceV1IncomingServiceCreatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **incoming_service_create_request** | [**\IIKO\Model\IncomingServiceCreateRequest**](../Model/IncomingServiceCreateRequest.md)| Document creation request body | |

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

## `apiFinanceV1IncomingServiceGetPost()`

```php
apiFinanceV1IncomingServiceGetPost($document_transactions_list_request): \IIKO\Model\IncomingServiceGetResponse
```

Get incoming service act

Gets an incoming service act by identifier from RMS

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingIncomingServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document retrieval by identifier request body

try {
    $result = $apiInstance->apiFinanceV1IncomingServiceGetPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingIncomingServiceApi->apiFinanceV1IncomingServiceGetPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **document_transactions_list_request** | [**\IIKO\Model\DocumentTransactionsListRequest**](../Model/DocumentTransactionsListRequest.md)| Document retrieval by identifier request body | |

### Return type

[**\IIKO\Model\IncomingServiceGetResponse**](../Model/IncomingServiceGetResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiFinanceV1IncomingServiceListPost()`

```php
apiFinanceV1IncomingServiceListPost($list_request): \IIKO\Model\IncomingServiceListItem[]
```

Export incoming service acts

Exports incoming service acts from RMS for the specified period

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingIncomingServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$list_request = new \IIKO\Model\ListRequest(); // \IIKO\Model\ListRequest | Document list retrieval request body

try {
    $result = $apiInstance->apiFinanceV1IncomingServiceListPost($list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingIncomingServiceApi->apiFinanceV1IncomingServiceListPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **list_request** | [**\IIKO\Model\ListRequest**](../Model/ListRequest.md)| Document list retrieval request body | |

### Return type

[**\IIKO\Model\IncomingServiceListItem[]**](../Model/IncomingServiceListItem.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiFinanceV1IncomingServicePostPost()`

```php
apiFinanceV1IncomingServicePostPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Post incoming service act

Changes the incoming service act status from NEW to PROCESSED

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingIncomingServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document posting request body

try {
    $result = $apiInstance->apiFinanceV1IncomingServicePostPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingIncomingServiceApi->apiFinanceV1IncomingServicePostPost: ', $e->getMessage(), PHP_EOL;
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

## `apiFinanceV1IncomingServiceUnpostPost()`

```php
apiFinanceV1IncomingServiceUnpostPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Unpost incoming service act

Changes the incoming service act status from PROCESSED to NEW

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingIncomingServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document unposting request body

try {
    $result = $apiInstance->apiFinanceV1IncomingServiceUnpostPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingIncomingServiceApi->apiFinanceV1IncomingServiceUnpostPost: ', $e->getMessage(), PHP_EOL;
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

## `apiFinanceV1IncomingServiceUpdatePost()`

```php
apiFinanceV1IncomingServiceUpdatePost($incoming_service_update_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Edit incoming service act

Edits an existing incoming service act in RMS

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingIncomingServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$incoming_service_update_request = new \IIKO\Model\IncomingServiceUpdateRequest(); // \IIKO\Model\IncomingServiceUpdateRequest | Document update request body

try {
    $result = $apiInstance->apiFinanceV1IncomingServiceUpdatePost($incoming_service_update_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingIncomingServiceApi->apiFinanceV1IncomingServiceUpdatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **incoming_service_update_request** | [**\IIKO\Model\IncomingServiceUpdateRequest**](../Model/IncomingServiceUpdateRequest.md)| Document update request body | |

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
