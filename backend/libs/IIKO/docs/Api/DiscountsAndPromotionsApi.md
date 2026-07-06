# IIKO\DiscountsAndPromotionsApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**api1LoyaltyIikoCalculatePost()**](DiscountsAndPromotionsApi.md#api1LoyaltyIikoCalculatePost) | **POST** /api/1/loyalty/iiko/calculate | Calculate checkin. |
| [**api1LoyaltyIikoCouponsBySeriesPost()**](DiscountsAndPromotionsApi.md#api1LoyaltyIikoCouponsBySeriesPost) | **POST** /api/1/loyalty/iiko/coupons/by_series | Get non-activated coupons |
| [**api1LoyaltyIikoCouponsInfoPost()**](DiscountsAndPromotionsApi.md#api1LoyaltyIikoCouponsInfoPost) | **POST** /api/1/loyalty/iiko/coupons/info | Get coupon info. |
| [**api1LoyaltyIikoCouponsSeriesPost()**](DiscountsAndPromotionsApi.md#api1LoyaltyIikoCouponsSeriesPost) | **POST** /api/1/loyalty/iiko/coupons/series | Get coupon series with non-activated coupons. |
| [**api1LoyaltyIikoManualConditionPost()**](DiscountsAndPromotionsApi.md#api1LoyaltyIikoManualConditionPost) | **POST** /api/1/loyalty/iiko/manual_condition | Get manual conditions. |
| [**api1LoyaltyIikoProgramPost()**](DiscountsAndPromotionsApi.md#api1LoyaltyIikoProgramPost) | **POST** /api/1/loyalty/iiko/program | Get programs. |


## `api1LoyaltyIikoCalculatePost()`

```php
api1LoyaltyIikoCalculatePost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_loyalty_result_calculate_checkin_request): \IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultCalculateCheckinResponse
```

Calculate checkin.

Calculate discounts and other loyalty items for an order.   > Restriction group: `Loyalty: order calculate`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DiscountsAndPromotionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_loyalty_result_calculate_checkin_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultCalculateCheckinRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultCalculateCheckinRequest

try {
    $result = $apiInstance->api1LoyaltyIikoCalculatePost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_loyalty_result_calculate_checkin_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DiscountsAndPromotionsApi->api1LoyaltyIikoCalculatePost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_loyalty_result_calculate_checkin_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultCalculateCheckinRequest**](../Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultCalculateCheckinRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultCalculateCheckinResponse**](../Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultCalculateCheckinResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1LoyaltyIikoCouponsBySeriesPost()`

```php
api1LoyaltyIikoCouponsBySeriesPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_loyalty_result_not_activated_coupon_request): \IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultNotActivatedCouponResponse
```

Get non-activated coupons

Get list of non-activated coupons.   > Restriction group: `Loyalty: coupons`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DiscountsAndPromotionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_loyalty_result_not_activated_coupon_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultNotActivatedCouponRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultNotActivatedCouponRequest

try {
    $result = $apiInstance->api1LoyaltyIikoCouponsBySeriesPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_loyalty_result_not_activated_coupon_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DiscountsAndPromotionsApi->api1LoyaltyIikoCouponsBySeriesPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_loyalty_result_not_activated_coupon_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultNotActivatedCouponRequest**](../Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultNotActivatedCouponRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultNotActivatedCouponResponse**](../Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultNotActivatedCouponResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1LoyaltyIikoCouponsInfoPost()`

```php
api1LoyaltyIikoCouponsInfoPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_loyalty_result_coupon_info_request): \IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultCouponInfoResponse
```

Get coupon info.

Get information about the specified coupon.   > Restriction group: `Loyalty: coupons`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DiscountsAndPromotionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_loyalty_result_coupon_info_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultCouponInfoRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultCouponInfoRequest

try {
    $result = $apiInstance->api1LoyaltyIikoCouponsInfoPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_loyalty_result_coupon_info_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DiscountsAndPromotionsApi->api1LoyaltyIikoCouponsInfoPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_loyalty_result_coupon_info_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultCouponInfoRequest**](../Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultCouponInfoRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultCouponInfoResponse**](../Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultCouponInfoResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1LoyaltyIikoCouponsSeriesPost()`

```php
api1LoyaltyIikoCouponsSeriesPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_get_categories_request): \IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultSeriesWithNotActivatedCouponsResponse
```

Get coupon series with non-activated coupons.

Get a list of coupon series in which there are not deleted and not activated coupons.   > Restriction group: `Loyalty: coupons`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DiscountsAndPromotionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_customer_get_categories_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerGetCategoriesRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerGetCategoriesRequest

try {
    $result = $apiInstance->api1LoyaltyIikoCouponsSeriesPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_customer_get_categories_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DiscountsAndPromotionsApi->api1LoyaltyIikoCouponsSeriesPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_customer_get_categories_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCustomerGetCategoriesRequest**](../Model/IikoNetServiceContractsApiIikoTransportCustomerGetCategoriesRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultSeriesWithNotActivatedCouponsResponse**](../Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultSeriesWithNotActivatedCouponsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1LoyaltyIikoManualConditionPost()`

```php
api1LoyaltyIikoManualConditionPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_common_get_by_organization_id_request): \IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultGetManualConditionsResponse
```

Get manual conditions.

Get all organization's manual conditions.   > Restriction group: `Loyalty: dictionaries`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DiscountsAndPromotionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_common_get_by_organization_id_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportCommonGetByOrganizationIdRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportCommonGetByOrganizationIdRequest

try {
    $result = $apiInstance->api1LoyaltyIikoManualConditionPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_common_get_by_organization_id_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DiscountsAndPromotionsApi->api1LoyaltyIikoManualConditionPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_common_get_by_organization_id_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportCommonGetByOrganizationIdRequest**](../Model/IikoNetServiceContractsApiIikoTransportCommonGetByOrganizationIdRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoNetServiceContractsApiIikoTransportLoyaltyResultGetManualConditionsResponse**](../Model/IikoNetServiceContractsApiIikoTransportLoyaltyResultGetManualConditionsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1LoyaltyIikoProgramPost()`

```php
api1LoyaltyIikoProgramPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_organization_get_programs_request): \IIKO\Model\IikoNetServiceContractsApiIikoTransportOrganizationGetProgramsResponse
```

Get programs.

Get all loyalty programs for organization.   > Restriction group: `Loyalty: dictionaries`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\DiscountsAndPromotionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_net_service_contracts_api_iiko_transport_organization_get_programs_request = new \IIKO\Model\IikoNetServiceContractsApiIikoTransportOrganizationGetProgramsRequest(); // \IIKO\Model\IikoNetServiceContractsApiIikoTransportOrganizationGetProgramsRequest

try {
    $result = $apiInstance->api1LoyaltyIikoProgramPost($authorization, $timeout, $iiko_net_service_contracts_api_iiko_transport_organization_get_programs_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DiscountsAndPromotionsApi->api1LoyaltyIikoProgramPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_net_service_contracts_api_iiko_transport_organization_get_programs_request** | [**\IIKO\Model\IikoNetServiceContractsApiIikoTransportOrganizationGetProgramsRequest**](../Model/IikoNetServiceContractsApiIikoTransportOrganizationGetProgramsRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoNetServiceContractsApiIikoTransportOrganizationGetProgramsResponse**](../Model/IikoNetServiceContractsApiIikoTransportOrganizationGetProgramsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
