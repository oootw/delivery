# IIKO\CustomerCategoriesApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**api1LoyaltyIikoCustomerCategoryAddPost()**](CustomerCategoriesApi.md#api1LoyaltyIikoCustomerCategoryAddPost) | **POST** /api/1/loyalty/iiko/customer_category/add | Add category for customer. |
| [**api1LoyaltyIikoCustomerCategoryPost()**](CustomerCategoriesApi.md#api1LoyaltyIikoCustomerCategoryPost) | **POST** /api/1/loyalty/iiko/customer_category | Get customer categories. |
| [**api1LoyaltyIikoCustomerCategoryRemovePost()**](CustomerCategoriesApi.md#api1LoyaltyIikoCustomerCategoryRemovePost) | **POST** /api/1/loyalty/iiko/customer_category/remove | Remove category for customer. |


## `api1LoyaltyIikoCustomerCategoryAddPost()`

```php
api1LoyaltyIikoCustomerCategoryAddPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_change_category_for_customer_request): object
```

Add category for customer.

Add specified category for customer.   > Restriction group: `Guests: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\CustomerCategoriesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_customer_change_category_for_customer_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerChangeCategoryForCustomerRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerChangeCategoryForCustomerRequest

try {
    $result = $apiInstance->api1LoyaltyIikoCustomerCategoryAddPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_change_category_for_customer_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CustomerCategoriesApi->api1LoyaltyIikoCustomerCategoryAddPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_customer_change_category_for_customer_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerChangeCategoryForCustomerRequest**](../Model/IikoNetServiceContractsApiIikoTransportCustomerChangeCategoryForCustomerRequest.md)|  | [optional] |

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

## `api1LoyaltyIikoCustomerCategoryPost()`

```php
api1LoyaltyIikoCustomerCategoryPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_get_categories_request): \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerGetCategoriesResponse
```

Get customer categories.

Get all organization's customer categories.   > Restriction group: `Loyalty: dictionaries`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\CustomerCategoriesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_customer_get_categories_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerGetCategoriesRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerGetCategoriesRequest

try {
    $result = $apiInstance->api1LoyaltyIikoCustomerCategoryPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_get_categories_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CustomerCategoriesApi->api1LoyaltyIikoCustomerCategoryPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_customer_get_categories_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerGetCategoriesRequest**](../Model/IikoNetServiceContractsApiIikoTransportCustomerGetCategoriesRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerGetCategoriesResponse**](../Model/IikoNetServiceContractsApiIikoTransportCustomerGetCategoriesResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1LoyaltyIikoCustomerCategoryRemovePost()`

```php
api1LoyaltyIikoCustomerCategoryRemovePost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_change_category_for_customer_request): object
```

Remove category for customer.

Remove specified category for customer.   > Restriction group: `Guests: changing`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\CustomerCategoriesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_customer_change_category_for_customer_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerChangeCategoryForCustomerRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerChangeCategoryForCustomerRequest

try {
    $result = $apiInstance->api1LoyaltyIikoCustomerCategoryRemovePost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_change_category_for_customer_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CustomerCategoriesApi->api1LoyaltyIikoCustomerCategoryRemovePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_customer_change_category_for_customer_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerChangeCategoryForCustomerRequest**](../Model/IikoNetServiceContractsApiIikoTransportCustomerChangeCategoryForCustomerRequest.md)|  | [optional] |

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
