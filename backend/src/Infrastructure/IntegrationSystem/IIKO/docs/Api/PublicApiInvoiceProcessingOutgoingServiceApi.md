# IIKO\PublicApiInvoiceProcessingOutgoingServiceApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**apiFinanceV1OutgoingServiceCancelPost()**](PublicApiInvoiceProcessingOutgoingServiceApi.md#apiFinanceV1OutgoingServiceCancelPost) | **POST** /api/finance/v1/outgoing_service/cancel | Cancel outgoing service act draft |
| [**apiFinanceV1OutgoingServiceCreatePost()**](PublicApiInvoiceProcessingOutgoingServiceApi.md#apiFinanceV1OutgoingServiceCreatePost) | **POST** /api/finance/v1/outgoing_service/create | Create outgoing service act |
| [**apiFinanceV1OutgoingServiceGetPost()**](PublicApiInvoiceProcessingOutgoingServiceApi.md#apiFinanceV1OutgoingServiceGetPost) | **POST** /api/finance/v1/outgoing_service/get | Get outgoing service act |
| [**apiFinanceV1OutgoingServiceListPost()**](PublicApiInvoiceProcessingOutgoingServiceApi.md#apiFinanceV1OutgoingServiceListPost) | **POST** /api/finance/v1/outgoing_service/list | Export outgoing service acts |
| [**apiFinanceV1OutgoingServicePostPost()**](PublicApiInvoiceProcessingOutgoingServiceApi.md#apiFinanceV1OutgoingServicePostPost) | **POST** /api/finance/v1/outgoing_service/post | Post outgoing service act |
| [**apiFinanceV1OutgoingServiceUnpostPost()**](PublicApiInvoiceProcessingOutgoingServiceApi.md#apiFinanceV1OutgoingServiceUnpostPost) | **POST** /api/finance/v1/outgoing_service/unpost | Unpost outgoing service act |
| [**apiFinanceV1OutgoingServiceUpdatePost()**](PublicApiInvoiceProcessingOutgoingServiceApi.md#apiFinanceV1OutgoingServiceUpdatePost) | **POST** /api/finance/v1/outgoing_service/update | Edit outgoing service act |


## `apiFinanceV1OutgoingServiceCancelPost()`

```php
apiFinanceV1OutgoingServiceCancelPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Cancel outgoing service act draft

Changes the outgoing service act status from NEW to CANCELED

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingOutgoingServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Draft cancellation request body

try {
    $result = $apiInstance->apiFinanceV1OutgoingServiceCancelPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingOutgoingServiceApi->apiFinanceV1OutgoingServiceCancelPost: ', $e->getMessage(), PHP_EOL;
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

## `apiFinanceV1OutgoingServiceCreatePost()`

```php
apiFinanceV1OutgoingServiceCreatePost($outgoing_service_create_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Create outgoing service act

Creates a new outgoing service act in RMS

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingOutgoingServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$outgoing_service_create_request = new \IIKO\Model\OutgoingServiceCreateRequest(); // \IIKO\Model\OutgoingServiceCreateRequest | Document creation request body

try {
    $result = $apiInstance->apiFinanceV1OutgoingServiceCreatePost($outgoing_service_create_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingOutgoingServiceApi->apiFinanceV1OutgoingServiceCreatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **outgoing_service_create_request** | [**\IIKO\Model\OutgoingServiceCreateRequest**](../Model/OutgoingServiceCreateRequest.md)| Document creation request body | |

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

## `apiFinanceV1OutgoingServiceGetPost()`

```php
apiFinanceV1OutgoingServiceGetPost($document_transactions_list_request): \IIKO\Model\OutgoingServiceGetResponse
```

Get outgoing service act

Gets an outgoing service act by identifier from RMS

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingOutgoingServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document retrieval by identifier request body

try {
    $result = $apiInstance->apiFinanceV1OutgoingServiceGetPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingOutgoingServiceApi->apiFinanceV1OutgoingServiceGetPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **document_transactions_list_request** | [**\IIKO\Model\DocumentTransactionsListRequest**](../Model/DocumentTransactionsListRequest.md)| Document retrieval by identifier request body | |

### Return type

[**\IIKO\Model\OutgoingServiceGetResponse**](../Model/OutgoingServiceGetResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiFinanceV1OutgoingServiceListPost()`

```php
apiFinanceV1OutgoingServiceListPost($list_request): \IIKO\Model\IncomingServiceListItem[]
```

Export outgoing service acts

Exports outgoing service acts from RMS for the specified period

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingOutgoingServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$list_request = new \IIKO\Model\ListRequest(); // \IIKO\Model\ListRequest | Document list retrieval request body

try {
    $result = $apiInstance->apiFinanceV1OutgoingServiceListPost($list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingOutgoingServiceApi->apiFinanceV1OutgoingServiceListPost: ', $e->getMessage(), PHP_EOL;
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

## `apiFinanceV1OutgoingServicePostPost()`

```php
apiFinanceV1OutgoingServicePostPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Post outgoing service act

Changes the outgoing service act status from NEW to PROCESSED

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingOutgoingServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document posting request body

try {
    $result = $apiInstance->apiFinanceV1OutgoingServicePostPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingOutgoingServiceApi->apiFinanceV1OutgoingServicePostPost: ', $e->getMessage(), PHP_EOL;
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

## `apiFinanceV1OutgoingServiceUnpostPost()`

```php
apiFinanceV1OutgoingServiceUnpostPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Unpost outgoing service act

Changes the outgoing service act status from PROCESSED to NEW

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingOutgoingServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document unposting request body

try {
    $result = $apiInstance->apiFinanceV1OutgoingServiceUnpostPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingOutgoingServiceApi->apiFinanceV1OutgoingServiceUnpostPost: ', $e->getMessage(), PHP_EOL;
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

## `apiFinanceV1OutgoingServiceUpdatePost()`

```php
apiFinanceV1OutgoingServiceUpdatePost($outgoing_service_update_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Edit outgoing service act

Edits an existing outgoing service act in RMS

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingOutgoingServiceApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$outgoing_service_update_request = new \IIKO\Model\OutgoingServiceUpdateRequest(); // \IIKO\Model\OutgoingServiceUpdateRequest | Document update request body

try {
    $result = $apiInstance->apiFinanceV1OutgoingServiceUpdatePost($outgoing_service_update_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingOutgoingServiceApi->apiFinanceV1OutgoingServiceUpdatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **outgoing_service_update_request** | [**\IIKO\Model\OutgoingServiceUpdateRequest**](../Model/OutgoingServiceUpdateRequest.md)| Document update request body | |

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
