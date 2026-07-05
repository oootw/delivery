# IIKO\PublicApiInvoiceProcessingIncomingInvoicesApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**apiInventoryV1IncomingInvoiceCancelPost()**](PublicApiInvoiceProcessingIncomingInvoicesApi.md#apiInventoryV1IncomingInvoiceCancelPost) | **POST** /api/inventory/v1/incoming_invoice/cancel | Cancel incoming invoice draft |
| [**apiInventoryV1IncomingInvoiceCreatePost()**](PublicApiInvoiceProcessingIncomingInvoicesApi.md#apiInventoryV1IncomingInvoiceCreatePost) | **POST** /api/inventory/v1/incoming_invoice/create | Create incoming invoice |
| [**apiInventoryV1IncomingInvoiceGetPost()**](PublicApiInvoiceProcessingIncomingInvoicesApi.md#apiInventoryV1IncomingInvoiceGetPost) | **POST** /api/inventory/v1/incoming_invoice/get | Get incoming invoice by identifier |
| [**apiInventoryV1IncomingInvoiceListPost()**](PublicApiInvoiceProcessingIncomingInvoicesApi.md#apiInventoryV1IncomingInvoiceListPost) | **POST** /api/inventory/v1/incoming_invoice/list | Export incoming invoices |
| [**apiInventoryV1IncomingInvoiceModifyAddPaymentPost()**](PublicApiInvoiceProcessingIncomingInvoicesApi.md#apiInventoryV1IncomingInvoiceModifyAddPaymentPost) | **POST** /api/inventory/v1/incoming_invoice/modify/add_payment | Pay incoming invoice |
| [**apiInventoryV1IncomingInvoicePatchSetPaymentDatePost()**](PublicApiInvoiceProcessingIncomingInvoicesApi.md#apiInventoryV1IncomingInvoicePatchSetPaymentDatePost) | **POST** /api/inventory/v1/incoming_invoice/patch/set_payment_date | Set payment date for incoming invoice |
| [**apiInventoryV1IncomingInvoicePostPost()**](PublicApiInvoiceProcessingIncomingInvoicesApi.md#apiInventoryV1IncomingInvoicePostPost) | **POST** /api/inventory/v1/incoming_invoice/post | Post incoming invoice |
| [**apiInventoryV1IncomingInvoiceUnpostPost()**](PublicApiInvoiceProcessingIncomingInvoicesApi.md#apiInventoryV1IncomingInvoiceUnpostPost) | **POST** /api/inventory/v1/incoming_invoice/unpost | Unpost incoming invoice |
| [**apiInventoryV1IncomingInvoiceUpdatePost()**](PublicApiInvoiceProcessingIncomingInvoicesApi.md#apiInventoryV1IncomingInvoiceUpdatePost) | **POST** /api/inventory/v1/incoming_invoice/update | Edit incoming invoice |


## `apiInventoryV1IncomingInvoiceCancelPost()`

```php
apiInventoryV1IncomingInvoiceCancelPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Cancel incoming invoice draft

Changes the incoming invoice status from NEW to CANCELED

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingIncomingInvoicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document draft cancellation request body

try {
    $result = $apiInstance->apiInventoryV1IncomingInvoiceCancelPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingIncomingInvoicesApi->apiInventoryV1IncomingInvoiceCancelPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1IncomingInvoiceCreatePost()`

```php
apiInventoryV1IncomingInvoiceCreatePost($incoming_invoice_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Create incoming invoice

Creates an incoming invoice from request parameters

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingIncomingInvoicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$incoming_invoice_request = new \IIKO\Model\IncomingInvoiceRequest(); // \IIKO\Model\IncomingInvoiceRequest | Document creation request body

try {
    $result = $apiInstance->apiInventoryV1IncomingInvoiceCreatePost($incoming_invoice_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingIncomingInvoicesApi->apiInventoryV1IncomingInvoiceCreatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **incoming_invoice_request** | [**\IIKO\Model\IncomingInvoiceRequest**](../Model/IncomingInvoiceRequest.md)| Document creation request body | |

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

## `apiInventoryV1IncomingInvoiceGetPost()`

```php
apiInventoryV1IncomingInvoiceGetPost($document_transactions_list_request): \IIKO\Model\IncomingInvoice
```

Get incoming invoice by identifier

Gets an incoming invoice by identifier from RMS

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingIncomingInvoicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document retrieval by identifier request body

try {
    $result = $apiInstance->apiInventoryV1IncomingInvoiceGetPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingIncomingInvoicesApi->apiInventoryV1IncomingInvoiceGetPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **document_transactions_list_request** | [**\IIKO\Model\DocumentTransactionsListRequest**](../Model/DocumentTransactionsListRequest.md)| Document retrieval by identifier request body | |

### Return type

[**\IIKO\Model\IncomingInvoice**](../Model/IncomingInvoice.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiInventoryV1IncomingInvoiceListPost()`

```php
apiInventoryV1IncomingInvoiceListPost($list_request): \IIKO\Model\IncomingInvoice[]
```

Export incoming invoices

Exports incoming invoices from RMS for the specified period

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingIncomingInvoicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$list_request = new \IIKO\Model\ListRequest(); // \IIKO\Model\ListRequest | Document list retrieval request body

try {
    $result = $apiInstance->apiInventoryV1IncomingInvoiceListPost($list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingIncomingInvoicesApi->apiInventoryV1IncomingInvoiceListPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **list_request** | [**\IIKO\Model\ListRequest**](../Model/ListRequest.md)| Document list retrieval request body | |

### Return type

[**\IIKO\Model\IncomingInvoice[]**](../Model/IncomingInvoice.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiInventoryV1IncomingInvoiceModifyAddPaymentPost()`

```php
apiInventoryV1IncomingInvoiceModifyAddPaymentPost($pay_request): \IIKO\Model\AccountingTransactionUserResponse
```

Pay incoming invoice

Creates a payment for an incoming invoice in RMS

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingIncomingInvoicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$pay_request = new \IIKO\Model\PayRequest(); // \IIKO\Model\PayRequest | Incoming invoice payment parameters

try {
    $result = $apiInstance->apiInventoryV1IncomingInvoiceModifyAddPaymentPost($pay_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingIncomingInvoicesApi->apiInventoryV1IncomingInvoiceModifyAddPaymentPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **pay_request** | [**\IIKO\Model\PayRequest**](../Model/PayRequest.md)| Incoming invoice payment parameters | |

### Return type

[**\IIKO\Model\AccountingTransactionUserResponse**](../Model/AccountingTransactionUserResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiInventoryV1IncomingInvoicePatchSetPaymentDatePost()`

```php
apiInventoryV1IncomingInvoicePatchSetPaymentDatePost($set_payment_date_outgoing_request): \IIKO\Model\SetPaymentDateOutgoingResponse
```

Set payment date for incoming invoice

Sets the payment date for an incoming invoice in RMS. The operation is available only for an already paid invoice (unpaid sum = 0).

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingIncomingInvoicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$set_payment_date_outgoing_request = new \IIKO\Model\SetPaymentDateOutgoingRequest(); // \IIKO\Model\SetPaymentDateOutgoingRequest | Request parameters

try {
    $result = $apiInstance->apiInventoryV1IncomingInvoicePatchSetPaymentDatePost($set_payment_date_outgoing_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingIncomingInvoicesApi->apiInventoryV1IncomingInvoicePatchSetPaymentDatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **set_payment_date_outgoing_request** | [**\IIKO\Model\SetPaymentDateOutgoingRequest**](../Model/SetPaymentDateOutgoingRequest.md)| Request parameters | |

### Return type

[**\IIKO\Model\SetPaymentDateOutgoingResponse**](../Model/SetPaymentDateOutgoingResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiInventoryV1IncomingInvoicePostPost()`

```php
apiInventoryV1IncomingInvoicePostPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Post incoming invoice

Changes the incoming invoice status from NEW to PROCESSED

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingIncomingInvoicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document posting request body

try {
    $result = $apiInstance->apiInventoryV1IncomingInvoicePostPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingIncomingInvoicesApi->apiInventoryV1IncomingInvoicePostPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1IncomingInvoiceUnpostPost()`

```php
apiInventoryV1IncomingInvoiceUnpostPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Unpost incoming invoice

Changes the incoming invoice status from PROCESSED to NEW

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingIncomingInvoicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document unposting request body

try {
    $result = $apiInstance->apiInventoryV1IncomingInvoiceUnpostPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingIncomingInvoicesApi->apiInventoryV1IncomingInvoiceUnpostPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1IncomingInvoiceUpdatePost()`

```php
apiInventoryV1IncomingInvoiceUpdatePost($incoming_invoice_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Edit incoming invoice

Updates an incoming invoice from request parameters

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingIncomingInvoicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$incoming_invoice_request = new \IIKO\Model\IncomingInvoiceRequest(); // \IIKO\Model\IncomingInvoiceRequest | Document update request body

try {
    $result = $apiInstance->apiInventoryV1IncomingInvoiceUpdatePost($incoming_invoice_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingIncomingInvoicesApi->apiInventoryV1IncomingInvoiceUpdatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **incoming_invoice_request** | [**\IIKO\Model\IncomingInvoiceRequest**](../Model/IncomingInvoiceRequest.md)| Document update request body | |

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
