# IIKO\CustomersApi

Loyalty systems API.

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**api1LoyaltyIikoCustomerCardAddPost()**](CustomersApi.md#api1LoyaltyIikoCustomerCardAddPost) | **POST** /api/1/loyalty/iiko/customer/card/add | Add card. |
| [**api1LoyaltyIikoCustomerCardRemovePost()**](CustomersApi.md#api1LoyaltyIikoCustomerCardRemovePost) | **POST** /api/1/loyalty/iiko/customer/card/remove | Delete card. |
| [**api1LoyaltyIikoCustomerCreateOrUpdatePost()**](CustomersApi.md#api1LoyaltyIikoCustomerCreateOrUpdatePost) | **POST** /api/1/loyalty/iiko/customer/create_or_update | Create or update customer. |
| [**api1LoyaltyIikoCustomerInfoPost()**](CustomersApi.md#api1LoyaltyIikoCustomerInfoPost) | **POST** /api/1/loyalty/iiko/customer/info | Get customer info. |
| [**api1LoyaltyIikoCustomerProgramAddPost()**](CustomersApi.md#api1LoyaltyIikoCustomerProgramAddPost) | **POST** /api/1/loyalty/iiko/customer/program/add | Add customer to program. |
| [**api1LoyaltyIikoCustomerWalletCancelHoldPost()**](CustomersApi.md#api1LoyaltyIikoCustomerWalletCancelHoldPost) | **POST** /api/1/loyalty/iiko/customer/wallet/cancel_hold | Cancel hold money. |
| [**api1LoyaltyIikoCustomerWalletChargeoffPost()**](CustomersApi.md#api1LoyaltyIikoCustomerWalletChargeoffPost) | **POST** /api/1/loyalty/iiko/customer/wallet/chargeoff | Withdraw balance. |
| [**api1LoyaltyIikoCustomerWalletHoldPost()**](CustomersApi.md#api1LoyaltyIikoCustomerWalletHoldPost) | **POST** /api/1/loyalty/iiko/customer/wallet/hold | Hold money. |
| [**api1LoyaltyIikoCustomerWalletTopupPost()**](CustomersApi.md#api1LoyaltyIikoCustomerWalletTopupPost) | **POST** /api/1/loyalty/iiko/customer/wallet/topup | Refill balance. |
| [**api1LoyaltyIikoDeleteCustomersPost()**](CustomersApi.md#api1LoyaltyIikoDeleteCustomersPost) | **POST** /api/1/loyalty/iiko/delete_customers | Logical deletion of customers. |
| [**api1LoyaltyIikoGetCountersPost()**](CustomersApi.md#api1LoyaltyIikoGetCountersPost) | **POST** /api/1/loyalty/iiko/get_counters | Get counters. |
| [**api1LoyaltyIikoRestoreCustomersPost()**](CustomersApi.md#api1LoyaltyIikoRestoreCustomersPost) | **POST** /api/1/loyalty/iiko/restore_customers | Logical recovery of customers. |


## `api1LoyaltyIikoCustomerCardAddPost()`

```php
api1LoyaltyIikoCustomerCardAddPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_add_magnet_card_request): object
```

Add card.

Add new card for customer.   > Restriction group: `Guests: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\CustomersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_customer_add_magnet_card_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerAddMagnetCardRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerAddMagnetCardRequest

try {
    $result = $apiInstance->api1LoyaltyIikoCustomerCardAddPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_add_magnet_card_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CustomersApi->api1LoyaltyIikoCustomerCardAddPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_customer_add_magnet_card_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerAddMagnetCardRequest**](../Model/IikoNetServiceContractsApiIikoTransportCustomerAddMagnetCardRequest.md)|  | [optional] |

### Return type

**object**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1LoyaltyIikoCustomerCardRemovePost()`

```php
api1LoyaltyIikoCustomerCardRemovePost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_delete_magnet_card_request): object
```

Delete card.

Delete existing card for customer.   > Restriction group: `Guests: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\CustomersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_customer_delete_magnet_card_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerDeleteMagnetCardRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerDeleteMagnetCardRequest

try {
    $result = $apiInstance->api1LoyaltyIikoCustomerCardRemovePost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_delete_magnet_card_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CustomersApi->api1LoyaltyIikoCustomerCardRemovePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_customer_delete_magnet_card_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerDeleteMagnetCardRequest**](../Model/IikoNetServiceContractsApiIikoTransportCustomerDeleteMagnetCardRequest.md)|  | [optional] |

### Return type

**object**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1LoyaltyIikoCustomerCreateOrUpdatePost()`

```php
api1LoyaltyIikoCustomerCreateOrUpdatePost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_create_or_update_customer_request): \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerCreateOrUpdateCustomerResponse
```

Create or update customer.

Create or update customer info by id or phone or card track.   > Restriction group: `Guests: creating`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\CustomersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_customer_create_or_update_customer_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerCreateOrUpdateCustomerRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerCreateOrUpdateCustomerRequest

try {
    $result = $apiInstance->api1LoyaltyIikoCustomerCreateOrUpdatePost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_create_or_update_customer_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CustomersApi->api1LoyaltyIikoCustomerCreateOrUpdatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_customer_create_or_update_customer_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerCreateOrUpdateCustomerRequest**](../Model/IikoNetServiceContractsApiIikoTransportCustomerCreateOrUpdateCustomerRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerCreateOrUpdateCustomerResponse**](../Model/IikoNetServiceContractsApiIikoTransportCustomerCreateOrUpdateCustomerResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1LoyaltyIikoCustomerInfoPost()`

```php
api1LoyaltyIikoCustomerInfoPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_get_customer_info_request): \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerGetCustomerInfoResponse
```

Get customer info.

Get customer info by specified criterion.   > Restriction group: `Guests: info`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\CustomersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_customer_get_customer_info_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerGetCustomerInfoRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerGetCustomerInfoRequest

try {
    $result = $apiInstance->api1LoyaltyIikoCustomerInfoPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_get_customer_info_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CustomersApi->api1LoyaltyIikoCustomerInfoPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_customer_get_customer_info_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerGetCustomerInfoRequest**](../Model/IikoNetServiceContractsApiIikoTransportCustomerGetCustomerInfoRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerGetCustomerInfoResponse**](../Model/IikoNetServiceContractsApiIikoTransportCustomerGetCustomerInfoResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1LoyaltyIikoCustomerProgramAddPost()`

```php
api1LoyaltyIikoCustomerProgramAddPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_add_customer_to_program_request): \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerAddCustomerToProgramResponse
```

Add customer to program.

Add new customer for program.   > Restriction group: `Guests: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\CustomersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_customer_add_customer_to_program_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerAddCustomerToProgramRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerAddCustomerToProgramRequest

try {
    $result = $apiInstance->api1LoyaltyIikoCustomerProgramAddPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_add_customer_to_program_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CustomersApi->api1LoyaltyIikoCustomerProgramAddPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_customer_add_customer_to_program_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerAddCustomerToProgramRequest**](../Model/IikoNetServiceContractsApiIikoTransportCustomerAddCustomerToProgramRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerAddCustomerToProgramResponse**](../Model/IikoNetServiceContractsApiIikoTransportCustomerAddCustomerToProgramResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1LoyaltyIikoCustomerWalletCancelHoldPost()`

```php
api1LoyaltyIikoCustomerWalletCancelHoldPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_cancel_hold_money_request): object
```

Cancel hold money.

Cancel holding transaction that created earlier.   > Restriction group: `Loyalty: wallets`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\CustomersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_customer_cancel_hold_money_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerCancelHoldMoneyRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerCancelHoldMoneyRequest

try {
    $result = $apiInstance->api1LoyaltyIikoCustomerWalletCancelHoldPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_cancel_hold_money_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CustomersApi->api1LoyaltyIikoCustomerWalletCancelHoldPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_customer_cancel_hold_money_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerCancelHoldMoneyRequest**](../Model/IikoNetServiceContractsApiIikoTransportCustomerCancelHoldMoneyRequest.md)|  | [optional] |

### Return type

**object**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1LoyaltyIikoCustomerWalletChargeoffPost()`

```php
api1LoyaltyIikoCustomerWalletChargeoffPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_change_user_balance_request): object
```

Withdraw balance.

Withdraw customer balance.   > Restriction group: `Loyalty: wallets`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\CustomersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_customer_change_user_balance_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerChangeUserBalanceRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerChangeUserBalanceRequest

try {
    $result = $apiInstance->api1LoyaltyIikoCustomerWalletChargeoffPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_change_user_balance_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CustomersApi->api1LoyaltyIikoCustomerWalletChargeoffPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_customer_change_user_balance_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerChangeUserBalanceRequest**](../Model/IikoNetServiceContractsApiIikoTransportCustomerChangeUserBalanceRequest.md)|  | [optional] |

### Return type

**object**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1LoyaltyIikoCustomerWalletHoldPost()`

```php
api1LoyaltyIikoCustomerWalletHoldPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_hold_money_request): \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerHoldMoneyResponse
```

Hold money.

Hold customer's money in loyalty program. Payment will be process on POS during processing of an order.   > Restriction group: `Loyalty: wallets`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\CustomersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_customer_hold_money_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerHoldMoneyRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerHoldMoneyRequest

try {
    $result = $apiInstance->api1LoyaltyIikoCustomerWalletHoldPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_hold_money_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CustomersApi->api1LoyaltyIikoCustomerWalletHoldPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_customer_hold_money_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerHoldMoneyRequest**](../Model/IikoNetServiceContractsApiIikoTransportCustomerHoldMoneyRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerHoldMoneyResponse**](../Model/IikoNetServiceContractsApiIikoTransportCustomerHoldMoneyResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1LoyaltyIikoCustomerWalletTopupPost()`

```php
api1LoyaltyIikoCustomerWalletTopupPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_change_user_balance_request): object
```

Refill balance.

Refill customer balance.   > Restriction group: `Loyalty: wallets`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\CustomersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_customer_change_user_balance_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerChangeUserBalanceRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerChangeUserBalanceRequest

try {
    $result = $apiInstance->api1LoyaltyIikoCustomerWalletTopupPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_change_user_balance_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CustomersApi->api1LoyaltyIikoCustomerWalletTopupPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_customer_change_user_balance_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerChangeUserBalanceRequest**](../Model/IikoNetServiceContractsApiIikoTransportCustomerChangeUserBalanceRequest.md)|  | [optional] |

### Return type

**object**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1LoyaltyIikoDeleteCustomersPost()`

```php
api1LoyaltyIikoDeleteCustomersPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_delete_customers_request): \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerDeleteCustomersResponse
```

Logical deletion of customers.

Mark customers as deleted.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\CustomersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_customer_delete_customers_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerDeleteCustomersRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerDeleteCustomersRequest

try {
    $result = $apiInstance->api1LoyaltyIikoDeleteCustomersPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_delete_customers_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CustomersApi->api1LoyaltyIikoDeleteCustomersPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_customer_delete_customers_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerDeleteCustomersRequest**](../Model/IikoNetServiceContractsApiIikoTransportCustomerDeleteCustomersRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerDeleteCustomersResponse**](../Model/IikoNetServiceContractsApiIikoTransportCustomerDeleteCustomersResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1LoyaltyIikoGetCountersPost()`

```php
api1LoyaltyIikoGetCountersPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_loyalty_result_get_counters_request): \IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultGetCountersResponse
```

Get counters.

Get customer orders count and sum for different period.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\CustomersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_loyalty_result_get_counters_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultGetCountersRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultGetCountersRequest

try {
    $result = $apiInstance->api1LoyaltyIikoGetCountersPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_loyalty_result_get_counters_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CustomersApi->api1LoyaltyIikoGetCountersPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_loyalty_result_get_counters_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultGetCountersRequest**](../Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultGetCountersRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultGetCountersResponse**](../Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultGetCountersResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1LoyaltyIikoRestoreCustomersPost()`

```php
api1LoyaltyIikoRestoreCustomersPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_delete_customers_request): \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerRestoreCustomersResponse
```

Logical recovery of customers.

Removing deletion flags for customers.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\CustomersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_customer_delete_customers_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerDeleteCustomersRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerDeleteCustomersRequest

try {
    $result = $apiInstance->api1LoyaltyIikoRestoreCustomersPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_delete_customers_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CustomersApi->api1LoyaltyIikoRestoreCustomersPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_customer_delete_customers_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerDeleteCustomersRequest**](../Model/IikoNetServiceContractsApiIikoTransportCustomerDeleteCustomersRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerRestoreCustomersResponse**](../Model/IikoNetServiceContractsApiIikoTransportCustomerRestoreCustomersResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
