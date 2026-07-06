# IIKO\ReportApi

Loyalty systems API.

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**api1LoyaltyIikoCustomerTransactionsByDatePost()**](ReportApi.md#api1LoyaltyIikoCustomerTransactionsByDatePost) | **POST** /api/1/loyalty/iiko/customer/transactions/by_date | Get transaction report by period. |
| [**api1LoyaltyIikoCustomerTransactionsByRevisionPost()**](ReportApi.md#api1LoyaltyIikoCustomerTransactionsByRevisionPost) | **POST** /api/1/loyalty/iiko/customer/transactions/by_revision | Get transaction report by revision. |


## `api1LoyaltyIikoCustomerTransactionsByDatePost()`

```php
api1LoyaltyIikoCustomerTransactionsByDatePost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_report_get_transactions_report_by_period_request): \IIKO\Model\IikoNetServiceContractsApiIikoTransportReportGetTransactionsReportByPeriodResponse
```

Get transaction report by period.

Get transaction report for specified customer by provided date range.   > Restriction group: `Guests: info`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\ReportApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_report_get_transactions_report_by_period_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportReportGetTransactionsReportByPeriodRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportReportGetTransactionsReportByPeriodRequest

try {
    $result = $apiInstance->api1LoyaltyIikoCustomerTransactionsByDatePost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_report_get_transactions_report_by_period_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ReportApi->api1LoyaltyIikoCustomerTransactionsByDatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_report_get_transactions_report_by_period_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportReportGetTransactionsReportByPeriodRequest**](../Model/IikoNetServiceContractsApiIikoTransportReportGetTransactionsReportByPeriodRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoNetServiceContractsApiIikoTransportReportGetTransactionsReportByPeriodResponse**](../Model/IikoNetServiceContractsApiIikoTransportReportGetTransactionsReportByPeriodResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1LoyaltyIikoCustomerTransactionsByRevisionPost()`

```php
api1LoyaltyIikoCustomerTransactionsByRevisionPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_report_get_transactions_report_by_revision_request): \IIKO\Model\IikoNetServiceContractsApiIikoTransportReportGetTransactionsReportByRevisionResponse
```

Get transaction report by revision.

Get transaction report for specified customer by provided revision.   > Restriction group: `Guests: info`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\ReportApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_report_get_transactions_report_by_revision_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportReportGetTransactionsReportByRevisionRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportReportGetTransactionsReportByRevisionRequest

try {
    $result = $apiInstance->api1LoyaltyIikoCustomerTransactionsByRevisionPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_report_get_transactions_report_by_revision_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ReportApi->api1LoyaltyIikoCustomerTransactionsByRevisionPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_report_get_transactions_report_by_revision_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportReportGetTransactionsReportByRevisionRequest**](../Model/IikoNetServiceContractsApiIikoTransportReportGetTransactionsReportByRevisionRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoNetServiceContractsApiIikoTransportReportGetTransactionsReportByRevisionResponse**](../Model/IikoNetServiceContractsApiIikoTransportReportGetTransactionsReportByRevisionResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
