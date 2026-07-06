# IIKO\AddressesApi

Regions/cities/streets API.

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**api1CitiesPost()**](AddressesApi.md#api1CitiesPost) | **POST** /api/1/cities | Cities. |
| [**api1RegionsPost()**](AddressesApi.md#api1RegionsPost) | **POST** /api/1/regions | Regions. |
| [**api1StreetsByCityPost()**](AddressesApi.md#api1StreetsByCityPost) | **POST** /api/1/streets/by_city | Streets by city. |
| [**api1StreetsByIdPost()**](AddressesApi.md#api1StreetsByIdPost) | **POST** /api/1/streets/by_id | Streets by id or by classifierId. |


## `api1CitiesPost()`

```php
api1CitiesPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_cities_request): \IIKO\Model\IikoTransportPublicApiContractsAddressCitiesResponse
```

Cities.

> Restriction group: `Data: geo`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\AddressesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_address_cities_request = new \IIKO\Model\IikoTransportPublicApiContractsAddressCitiesRequest(); // \IIKO\Model\IikoTransportPublicApiContractsAddressCitiesRequest

try {
    $result = $apiInstance->api1CitiesPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_cities_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AddressesApi->api1CitiesPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_address_cities_request** | [**\IIKO\Model\IikoTransportPublicApiContractsAddressCitiesRequest**](../Model/IikoTransportPublicApiContractsAddressCitiesRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsAddressCitiesResponse**](../Model/IikoTransportPublicApiContractsAddressCitiesResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1RegionsPost()`

```php
api1RegionsPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_regions_request): \IIKO\Model\IikoTransportPublicApiContractsAddressRegionsResponse
```

Regions.

> Restriction group: `Data: geo`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\AddressesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_address_regions_request = new \IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest(); // \IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest

try {
    $result = $apiInstance->api1RegionsPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_regions_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AddressesApi->api1RegionsPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_address_regions_request** | [**\IIKO\Model\IikoTransportPublicApiContractsAddressRegionsRequest**](../Model/IikoTransportPublicApiContractsAddressRegionsRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsAddressRegionsResponse**](../Model/IikoTransportPublicApiContractsAddressRegionsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1StreetsByCityPost()`

```php
api1StreetsByCityPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_streets_by_city_request): \IIKO\Model\IikoTransportPublicApiContractsAddressStreetsResponse
```

Streets by city.

> Restriction group: `Data: geo`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\AddressesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_address_streets_by_city_request = new \IIKO\Model\IikoTransportPublicApiContractsAddressStreetsByCityRequest(); // \IIKO\Model\IikoTransportPublicApiContractsAddressStreetsByCityRequest

try {
    $result = $apiInstance->api1StreetsByCityPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_streets_by_city_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AddressesApi->api1StreetsByCityPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_address_streets_by_city_request** | [**\IIKO\Model\IikoTransportPublicApiContractsAddressStreetsByCityRequest**](../Model/IikoTransportPublicApiContractsAddressStreetsByCityRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsAddressStreetsResponse**](../Model/IikoTransportPublicApiContractsAddressStreetsResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `api1StreetsByIdPost()`

```php
api1StreetsByIdPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_streets_by_id_request): \IIKO\Model\IikoTransportPublicApiContractsAddressStreetsByIdResponse
```

Streets by id or by classifierId.

> Restriction group: `Data: geo`.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new IIKO\Api\AddressesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$authorization = Bearer nRzIn0dJu1LpbGMbVfnCFDjKM4iwPhDV8tMlh7X5eWBR64iw; // string | Authorization token.
$timeout = 10; // int | Timeout in seconds.
$iiko_transport_public_api_contracts_address_streets_by_id_request = new \IIKO\Model\IikoTransportPublicApiContractsAddressStreetsByIdRequest(); // \IIKO\Model\IikoTransportPublicApiContractsAddressStreetsByIdRequest

try {
    $result = $apiInstance->api1StreetsByIdPost($authorization, $timeout, $iiko_transport_public_api_contracts_address_streets_by_id_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AddressesApi->api1StreetsByIdPost: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **authorization** | **string**| Authorization token. | |
| **timeout** | **int**| Timeout in seconds. | [optional] [default to 15] |
| **iiko_transport_public_api_contracts_address_streets_by_id_request** | [**\IIKO\Model\IikoTransportPublicApiContractsAddressStreetsByIdRequest**](../Model/IikoTransportPublicApiContractsAddressStreetsByIdRequest.md)|  | [optional] |

### Return type

[**\IIKO\Model\IikoTransportPublicApiContractsAddressStreetsByIdResponse**](../Model/IikoTransportPublicApiContractsAddressStreetsByIdResponse.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
