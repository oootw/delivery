# IIKO\MarketingSourcesApi



All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**api1MarketingSourcesPost()**](MarketingSourcesApi.md#api1MarketingSourcesPost) | **POST** /api/1/marketing_sources | Marketing sources. |


## `api1MarketingSourcesPost()`

```php
api1MarketingSourcesPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_regions_request): \IIKO\Model\IikoTransportPublicApiContractsMarketingSourcesMarketingSourcesResponse
```

Marketing sources.

> Allowed from version `7.2.5`.   > Restriction group: `Data: dictionaries`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\MarketingSourcesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_address_regions_request = new \IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest

try {
    $result = $apiInstance->api1MarketingSourcesPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_regions_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MarketingSourcesApi->api1MarketingSourcesPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_address_regions_request** | [**\IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest**](../Model/IikoTransportPublicApiContractsAddressRegionsRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsMarketingSourcesMarketingSourcesResponse**](../Model/IikoTransportPublicApiContractsMarketingSourcesMarketingSourcesResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
