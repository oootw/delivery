# IIKO\PublicApiInvoiceProcessingOutgoingInvoicesApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**apiInventoryV1CostingsCalculatePost()**](PublicApiInvoiceProcessingOutgoingInvoicesApi.md#apiInventoryV1CostingsCalculatePost) | **POST** /api/inventory/v1/costings/calculate | Get cost prices for nomenclature items |
| [**apiInventoryV1OutgoingInvoiceCancelPost()**](PublicApiInvoiceProcessingOutgoingInvoicesApi.md#apiInventoryV1OutgoingInvoiceCancelPost) | **POST** /api/inventory/v1/outgoing_invoice/cancel | Cancel outgoing invoice draft |
| [**apiInventoryV1OutgoingInvoiceCreatePost()**](PublicApiInvoiceProcessingOutgoingInvoicesApi.md#apiInventoryV1OutgoingInvoiceCreatePost) | **POST** /api/inventory/v1/outgoing_invoice/create | Create outgoing invoice |
| [**apiInventoryV1OutgoingInvoiceGetPost()**](PublicApiInvoiceProcessingOutgoingInvoicesApi.md#apiInventoryV1OutgoingInvoiceGetPost) | **POST** /api/inventory/v1/outgoing_invoice/get | Get outgoing invoice by ID |
| [**apiInventoryV1OutgoingInvoiceListPost()**](PublicApiInvoiceProcessingOutgoingInvoicesApi.md#apiInventoryV1OutgoingInvoiceListPost) | **POST** /api/inventory/v1/outgoing_invoice/list | Export outgoing invoices |
| [**apiInventoryV1OutgoingInvoiceModifyAddPaymentPost()**](PublicApiInvoiceProcessingOutgoingInvoicesApi.md#apiInventoryV1OutgoingInvoiceModifyAddPaymentPost) | **POST** /api/inventory/v1/outgoing_invoice/modify/add_payment | Pay outgoing invoice |
| [**apiInventoryV1OutgoingInvoicePatchSetPaymentDatePost()**](PublicApiInvoiceProcessingOutgoingInvoicesApi.md#apiInventoryV1OutgoingInvoicePatchSetPaymentDatePost) | **POST** /api/inventory/v1/outgoing_invoice/patch/set_payment_date | Set payment date for outgoing invoice |
| [**apiInventoryV1OutgoingInvoicePostPost()**](PublicApiInvoiceProcessingOutgoingInvoicesApi.md#apiInventoryV1OutgoingInvoicePostPost) | **POST** /api/inventory/v1/outgoing_invoice/post | Post outgoing invoice |
| [**apiInventoryV1OutgoingInvoiceUnpostPost()**](PublicApiInvoiceProcessingOutgoingInvoicesApi.md#apiInventoryV1OutgoingInvoiceUnpostPost) | **POST** /api/inventory/v1/outgoing_invoice/unpost | Unpost outgoing invoice |
| [**apiInventoryV1OutgoingInvoiceUpdatePost()**](PublicApiInvoiceProcessingOutgoingInvoicesApi.md#apiInventoryV1OutgoingInvoiceUpdatePost) | **POST** /api/inventory/v1/outgoing_invoice/update | Edit outgoing invoice |


## `apiInventoryV1CostingsCalculatePost()`

```php
apiInventoryV1CostingsCalculatePost($get_cost_prices_request): \IIKO\Model\GetCostPricesResponse
```

Get cost prices for nomenclature items

Gets cost prices for nomenclature items as of the specified date from RMS

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingOutgoingInvoicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$get_cost_prices_request = new \IIKO\Model\GetCostPricesRequest(); // \IIKO\Model\GetCostPricesRequest | Cost prices request parameters

try {
    $result = $apiInstance->apiInventoryV1CostingsCalculatePost($get_cost_prices_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingOutgoingInvoicesApi->apiInventoryV1CostingsCalculatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **get_cost_prices_request** | [**\IIKO\Model\GetCostPricesRequest**](../Model/GetCostPricesRequest.md)| Cost prices request parameters | |

### Return type

[**\IIKO\Model\GetCostPricesResponse**](../Model/GetCostPricesResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiInventoryV1OutgoingInvoiceCancelPost()`

```php
apiInventoryV1OutgoingInvoiceCancelPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Cancel outgoing invoice draft

Changes the outgoing invoice status from NEW to CANCELED

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingOutgoingInvoicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document draft cancellation request body

try {
    $result = $apiInstance->apiInventoryV1OutgoingInvoiceCancelPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingOutgoingInvoicesApi->apiInventoryV1OutgoingInvoiceCancelPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1OutgoingInvoiceCreatePost()`

```php
apiInventoryV1OutgoingInvoiceCreatePost($outgoing_invoice_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Create outgoing invoice

Creates an outgoing invoice from request parameters

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingOutgoingInvoicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$outgoing_invoice_request = new \IIKO\Model\OutgoingInvoiceRequest(); // \IIKO\Model\OutgoingInvoiceRequest | Document creation request body

try {
    $result = $apiInstance->apiInventoryV1OutgoingInvoiceCreatePost($outgoing_invoice_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingOutgoingInvoicesApi->apiInventoryV1OutgoingInvoiceCreatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **outgoing_invoice_request** | [**\IIKO\Model\OutgoingInvoiceRequest**](../Model/OutgoingInvoiceRequest.md)| Document creation request body | |

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

## `apiInventoryV1OutgoingInvoiceGetPost()`

```php
apiInventoryV1OutgoingInvoiceGetPost($document_transactions_list_request): \IIKO\Model\OutgoingInvoice
```

Get outgoing invoice by ID

Returns an outgoing invoice by identifier from RMS

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingOutgoingInvoicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document retrieval by identifier request body

try {
    $result = $apiInstance->apiInventoryV1OutgoingInvoiceGetPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingOutgoingInvoicesApi->apiInventoryV1OutgoingInvoiceGetPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **document_transactions_list_request** | [**\IIKO\Model\DocumentTransactionsListRequest**](../Model/DocumentTransactionsListRequest.md)| Document retrieval by identifier request body | |

### Return type

[**\IIKO\Model\OutgoingInvoice**](../Model/OutgoingInvoice.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiInventoryV1OutgoingInvoiceListPost()`

```php
apiInventoryV1OutgoingInvoiceListPost($list_request): \IIKO\Model\OutgoingInvoice[]
```

Export outgoing invoices

Exports outgoing invoices from RMS for the specified period

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingOutgoingInvoicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$list_request = new \IIKO\Model\ListRequest(); // \IIKO\Model\ListRequest | Document list retrieval request body

try {
    $result = $apiInstance->apiInventoryV1OutgoingInvoiceListPost($list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingOutgoingInvoicesApi->apiInventoryV1OutgoingInvoiceListPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **list_request** | [**\IIKO\Model\ListRequest**](../Model/ListRequest.md)| Document list retrieval request body | |

### Return type

[**\IIKO\Model\OutgoingInvoice[]**](../Model/OutgoingInvoice.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `apiInventoryV1OutgoingInvoiceModifyAddPaymentPost()`

```php
apiInventoryV1OutgoingInvoiceModifyAddPaymentPost($pay_outgoing_invoice_request): \IIKO\Model\AccountingTransactionUserResponse
```

Pay outgoing invoice

Creates a payment for an outgoing invoice in RMS

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingOutgoingInvoicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$pay_outgoing_invoice_request = new \IIKO\Model\PayOutgoingInvoiceRequest(); // \IIKO\Model\PayOutgoingInvoiceRequest | Outgoing invoice payment parameters

try {
    $result = $apiInstance->apiInventoryV1OutgoingInvoiceModifyAddPaymentPost($pay_outgoing_invoice_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingOutgoingInvoicesApi->apiInventoryV1OutgoingInvoiceModifyAddPaymentPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **pay_outgoing_invoice_request** | [**\IIKO\Model\PayOutgoingInvoiceRequest**](../Model/PayOutgoingInvoiceRequest.md)| Outgoing invoice payment parameters | |

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

## `apiInventoryV1OutgoingInvoicePatchSetPaymentDatePost()`

```php
apiInventoryV1OutgoingInvoicePatchSetPaymentDatePost($set_payment_date_outgoing_request): \IIKO\Model\SetPaymentDateOutgoingResponse
```

Set payment date for outgoing invoice

Sets the payment date for an outgoing invoice. The operation is available only for an already paid invoice.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingOutgoingInvoicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$set_payment_date_outgoing_request = new \IIKO\Model\SetPaymentDateOutgoingRequest(); // \IIKO\Model\SetPaymentDateOutgoingRequest | Request parameters

try {
    $result = $apiInstance->apiInventoryV1OutgoingInvoicePatchSetPaymentDatePost($set_payment_date_outgoing_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingOutgoingInvoicesApi->apiInventoryV1OutgoingInvoicePatchSetPaymentDatePost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1OutgoingInvoicePostPost()`

```php
apiInventoryV1OutgoingInvoicePostPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Post outgoing invoice

Changes the outgoing invoice status from NEW to PROCESSED

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingOutgoingInvoicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document posting request body

try {
    $result = $apiInstance->apiInventoryV1OutgoingInvoicePostPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingOutgoingInvoicesApi->apiInventoryV1OutgoingInvoicePostPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1OutgoingInvoiceUnpostPost()`

```php
apiInventoryV1OutgoingInvoiceUnpostPost($document_transactions_list_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Unpost outgoing invoice

Changes the outgoing invoice status from PROCESSED to NEW

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingOutgoingInvoicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$document_transactions_list_request = new \IIKO\Model\DocumentTransactionsListRequest(); // \IIKO\Model\DocumentTransactionsListRequest | Document unposting request body

try {
    $result = $apiInstance->apiInventoryV1OutgoingInvoiceUnpostPost($document_transactions_list_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingOutgoingInvoicesApi->apiInventoryV1OutgoingInvoiceUnpostPost: ', $e->getMessage(), PHP_EOL;
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

## `apiInventoryV1OutgoingInvoiceUpdatePost()`

```php
apiInventoryV1OutgoingInvoiceUpdatePost($outgoing_invoice_request): \IIKO\Model\DisassembleDocumentSaveResponse
```

Edit outgoing invoice

Updates an outgoing invoice from request parameters

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\PublicApiInvoiceProcessingOutgoingInvoicesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$outgoing_invoice_request = new \IIKO\Model\OutgoingInvoiceRequest(); // \IIKO\Model\OutgoingInvoiceRequest | Document update request body

try {
    $result = $apiInstance->apiInventoryV1OutgoingInvoiceUpdatePost($outgoing_invoice_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PublicApiInvoiceProcessingOutgoingInvoicesApi->apiInventoryV1OutgoingInvoiceUpdatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **outgoing_invoice_request** | [**\IIKO\Model\OutgoingInvoiceRequest**](../Model/OutgoingInvoiceRequest.md)| Document update request body | |

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
